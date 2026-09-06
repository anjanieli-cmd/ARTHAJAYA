<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payable;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgingController extends Controller
{
    /**
     * ===== AGING REPORT (AR & AP) =====
     * Sebelumnya halaman ini pakai array hardcoded + session, jadi semua
     * user baru melihat data fiktif yang sama. Sekarang datanya dihitung
     * langsung dari tabel `invoices` (piutang, sama seperti ReceivableController)
     * dan `payables` (utang, sama seperti PayableController), dikelompokkan
     * ke bucket umur 0 / 1-30 / 31-60 / 61-90+ hari berdasarkan due_date.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $company = $user->company;

        abort_if(! $company, 403, 'Lengkapi setup perusahaan terlebih dahulu.');

        $arRows = $this->buildArRows($company->id);
        $apRows = $this->buildApRows($company->id);

        if ($request->filled('q')) {
            $q = strtolower($request->get('q'));

            $arRows = array_values(array_filter($arRows, function ($row) use ($q) {
                return str_contains(strtolower($row['name']), $q)
                    || str_contains(strtolower($row['invoice']), $q);
            }));

            $apRows = array_values(array_filter($apRows, function ($row) use ($q) {
                return str_contains(strtolower($row['name']), $q)
                    || str_contains(strtolower($row['invoice']), $q);
            }));
        }

        if ($request->ajax()) {
            return view('aging.index', compact('user', 'company', 'arRows', 'apRows'))->render();
        }

        return view('aging.index', compact('user', 'company', 'arRows', 'apRows'));
    }

    /**
     * Detail satu baris aging (AR atau AP), diambil langsung dari
     * record aslinya di database, bukan dari array session.
     */
    public function show(Request $request, $id)
    {
        $user = Auth::user();
        $company = $user->company;

        abort_if(! $company, 403, 'Lengkapi setup perusahaan terlebih dahulu.');

        $type = $request->get('type', 'ar');

        if ($type === 'ar') {
            $invoice = Invoice::with('client')
                ->where('company_id', $company->id)
                ->find($id);

            abort_if(! $invoice, 404, 'Data piutang tidak ditemukan');

            $row = $this->toArRow($invoice);
        } else {
            $payable = Payable::where('company_id', $company->id)->find($id);

            abort_if(! $payable, 404, 'Data utang tidak ditemukan');

            $row = $this->toApRow($payable);
        }

        $index = $id;

        return view('aging.show', compact('user', 'company', 'row', 'index', 'type'));
    }

    /**
     * Hapus record dari halaman Aging Report. Karena aging hanya
     * "menumpang" di atas Invoice/Payable, menghapus baris di sini
     * berarti menghapus record aslinya juga (sama seperti tombol hapus
     * di halaman Piutang Usaha / Utang Usaha).
     */
    public function destroy(Request $request, $id)
    {
        $company = Auth::user()->company;
        $type = $request->get('type', 'ar');

        if ($type === 'ar') {
            $invoice = Invoice::where('company_id', $company->id)->find($id);

            if ($invoice) {
                $invoice->delete();
            }
        } else {
            $payable = Payable::where('company_id', $company->id)->find($id);

            if ($payable) {
                $payable->delete();
            }
        }

        return redirect()->route('aging.index')->with('success', 'Data berhasil dihapus!');
    }

    public function exportPdf(Request $request)
    {
        $company = Auth::user()->company;
        $type = $request->get('type', 'ar');

        $data = $type === 'ar'
            ? $this->buildArRows($company->id)
            : $this->buildApRows($company->id);

        $title = $type === 'ar' ? 'Piutang (AR)' : 'Utang (AP)';

        return view('aging.export', compact('data', 'title', 'type'));
    }

    public function exportExcel(Request $request)
    {
        // Catatan: export Excel masih placeholder (belum generate file
        // beneran), sama seperti sebelumnya. Di luar cakupan perbaikan
        // "data dummy" ini -- kalau mau diaktifkan, perlu package seperti
        // maatwebsite/excel.
        return redirect()->route('aging.index')->with('success', 'File Excel berhasil diekspor!');
    }

    /**
     * ===== HELPERS =====
     */

    private function buildArRows(int $companyId): array
    {
        return Invoice::with('client')
            ->where('company_id', $companyId)
            ->whereIn('status', ['sent']) // hanya yang masih outstanding; "paid" sudah lunas, tidak relevan untuk aging
            ->orderBy('due_date')
            ->get()
            ->map(fn (Invoice $invoice) => $this->toArRow($invoice))
            ->values()
            ->toArray();
    }

    private function buildApRows(int $companyId): array
    {
        return Payable::where('company_id', $companyId)
            ->where('status', '!=', Payable::STATUS_LUNAS) // hanya yang masih outstanding
            ->orderBy('due')
            ->get()
            ->map(fn (Payable $payable) => $this->toApRow($payable))
            ->values()
            ->toArray();
    }

    private function toArRow(Invoice $invoice): array
    {
        $buckets = $this->bucketize((float) $invoice->total, $invoice->due_date);

        return array_merge([
            'id' => $invoice->id,
            'name' => $invoice->client->name ?? 'Klien terhapus',
            'invoice' => $invoice->invoice_number,
        ], $buckets);
    }

    private function toApRow(Payable $payable): array
    {
        $buckets = $this->bucketize((float) $payable->amount, $payable->due);

        return array_merge([
            'id' => $payable->id,
            'name' => $payable->vendor,
            'invoice' => $payable->bill_number,
        ], $buckets);
    }

    /**
     * Kelompokkan satu nominal ke bucket umur berdasarkan tanggal jatuh
     * tempo dibanding hari ini: 0 (belum jatuh tempo), 1-30, 31-60, 61-90+.
     */
    private function bucketize(float $amount, $dueDate): array
    {
        $empty = ['current' => 0, 'd30' => 0, 'd60' => 0, 'd90' => 0];

        if (! $dueDate) {
            $empty['current'] = $amount;
            return $empty;
        }

        $due = $dueDate instanceof Carbon ? $dueDate : Carbon::parse($dueDate);
        $today = Carbon::today();

        if ($due->greaterThanOrEqualTo($today)) {
            $empty['current'] = $amount;
            return $empty;
        }

        $daysOverdue = $due->diffInDays($today);

        if ($daysOverdue <= 30) {
            $empty['d30'] = $amount;
        } elseif ($daysOverdue <= 60) {
            $empty['d60'] = $amount;
        } else {
            $empty['d90'] = $amount;
        }

        return $empty;
    }
}