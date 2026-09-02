<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class ReceivableController extends Controller
{
    /**
     * Tampilkan daftar piutang usaha (AR).
     * Sumber data: tabel `invoices` (sama seperti InvoiceController),
     * BUKAN session — supaya status jatuh tempo selalu sinkron dengan
     * halaman "Semua Faktur".
     */
    public function index()
    {
        $company = auth()->user()->company;

        abort_if(! $company, 403, 'Lengkapi setup perusahaan terlebih dahulu.');

        // Hanya faktur yang masih "sent" (belum lunas) atau sudah "paid".
        // Faktur draft/cancelled tidak relevan untuk piutang.
        $invoices = Invoice::with('client')
            ->where('company_id', $company->id)
            ->whereIn('status', ['sent', 'paid'])
            ->orderBy('due_date')
            ->get();

        $receivables = $invoices->map(function (Invoice $invoice) {
            // Logika overdue SAMA PERSIS dengan InvoiceController@index dan
            // Invoice::getIsOverdueAttribute() — status "sent" + due_date sudah lewat.
            $arStatus = 'lancar';

            if ($invoice->status === 'paid') {
                $arStatus = 'lunas';
            } elseif ($invoice->is_overdue) {
                $arStatus = 'jatuh_tempo';
            }

            return [
                'id' => $invoice->id,
                'client' => $invoice->client->name ?? 'Klien terhapus',
                'invoice' => $invoice->invoice_number,
                'date' => optional($invoice->issue_date)->format('Y-m-d'),
                'due' => optional($invoice->due_date)->format('Y-m-d'),
                'status' => $arStatus,
                'amount' => (float) $invoice->total,
            ];
        })->values()->toArray();

        return view('receivables.index', compact('receivables', 'company'));
    }

    /**
     * Piutang bukan entity terpisah -- dia "menumpang" di atas Invoice.
     * Jadi create/store/edit/update semuanya diarahkan ke halaman Invoice
     * yang sesungguhnya, satu sumber kebenaran, konsisten dengan show()
     * di bawah yang juga redirect ke invoices.show.
     *
     * SEBELUM INI: route receivables.create/store/edit/update di web.php
     * memanggil method yang tidak ada di controller ini sama sekali --
     * kalau ada yang mengaksesnya akan 500 error (method not found).
     */
    public function create()
    {
        return redirect()->route('invoices.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('invoices.create');
    }

    public function edit($id)
    {
        return redirect()->route('invoices.edit', $id);
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('invoices.edit', $id);
    }

    /**
     * Detail piutang -> arahkan ke halaman detail faktur aslinya
     * (satu sumber kebenaran, tidak ada halaman show terpisah untuk AR).
     */
    public function show($id)
    {
        return redirect()->route('invoices.show', $id);
    }

    /**
     * Hapus faktur langsung dari halaman Piutang Usaha.
     */
    public function destroy($id)
    {
        $company = auth()->user()->company;

        $invoice = Invoice::where('company_id', $company->id)->findOrFail($id);
        $invoice->delete();

        return redirect()->route('receivables.index')->with('success', 'Faktur berhasil dihapus!');
    }
}