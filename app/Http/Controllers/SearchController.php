<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Invoice;
use App\Models\Client;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $q = trim((string) $request->query('q', ''));

        if ($q === '') {
            return response()->json(['results' => []]);
        }

        $results = [];
        $lower = mb_strtolower($q);

        // ===== 1. INVOICES (database) =====
        // Sesuaikan nama kolom kalau beda di model Invoice-mu
        $invoices = Invoice::where('number', 'like', "%{$q}%")
            ->orWhere('client_name', 'like', "%{$q}%")
            ->limit(8)->get();

        foreach ($invoices as $inv) {
            $results[] = [
                'type'  => 'invoice',
                'title' => ($inv->number ?? 'INV') . ' — ' . ($inv->client_name ?? 'Klien'),
                'desc'  => 'Rp ' . number_format($inv->amount ?? 0, 0, ',', '.') . ' • ' . optional($inv->date)?->format('d M Y'),
                'url'   => route('invoices.show', $inv->id),
                'priority' => 1,
            ];
        }

        // ===== 2. RECEIVABLES / PIUTANG (AR — query dari tabel invoices juga) =====
        // Sesuai catatan: modul AR-mu query langsung ke tabel invoices, filter yang belum lunas
        $receivables = Invoice::where(function ($sub) use ($q) {
                $sub->where('number', 'like', "%{$q}%")
                    ->orWhere('client_name', 'like', "%{$q}%");
            })
            ->whereIn('status', ['unpaid', 'overdue', 'pending']) // sesuaikan status yang dianggap "piutang"
            ->limit(8)->get();

        foreach ($receivables as $rec) {
            $results[] = [
                'type'  => 'receivable',
                'title' => ($rec->number ?? 'AR') . ' — ' . ($rec->client_name ?? 'Klien'),
                'desc'  => 'Rp ' . number_format($rec->amount ?? 0, 0, ',', '.') . ' • Piutang',
                'url'   => route('receivables.show', $rec->id),
                'priority' => 2,
            ];
        }

        // ===== 3. CLIENTS (database) =====
        $clients = Client::where('name', 'like', "%{$q}%")
            ->orWhere('email', 'like', "%{$q}%")
            ->limit(8)->get();

        foreach ($clients as $client) {
            $results[] = [
                'type'  => 'client',
                'title' => $client->name,
                'desc'  => ($client->email ?? '') . ' • ' . ($client->phone ?? ''),
                'url'   => route('clients.show', $client->id),
                'priority' => 3,
            ];
        }

        // ===== 4. Modul session-based (payables, expenses, dst) =====
        $results = array_merge($results, $this->searchSession('payables', $lower, function ($item, $i) {
            return [
                'type'  => 'payable',
                'title' => ($item['bill'] ?? '#B') . ' — ' . ($item['vendor'] ?? 'Vendor'),
                'desc'  => 'Rp ' . number_format($item['amount'] ?? 0, 0, ',', '.') . ' • Jatuh tempo: ' . ($item['due'] ?? ''),
                'url'   => route('payables.show', $i),
                'priority' => 4,
            ];
        }, ['bill', 'vendor']));

        $results = array_merge($results, $this->searchSession('expenses', $lower, function ($item, $i) {
            return [
                'type'  => 'expense',
                'title' => $item['desc'] ?? 'Pengeluaran',
                'desc'  => 'Rp ' . number_format($item['amount'] ?? 0, 0, ',', '.') . ' • ' . ($item['kategori'] ?? ''),
                'url'   => route('expenses.show', $i),
                'priority' => 5,
            ];
        }, ['desc', 'kategori']));

        $results = array_merge($results, $this->searchSession('expense_categories', $lower, function ($item, $i) {
            return [
                'type'  => 'category',
                'title' => $item['name'] ?? 'Kategori',
                'desc'  => 'Total: Rp ' . number_format($item['total'] ?? 0, 0, ',', '.'),
                'url'   => route('expense-categories.show', $i),
                'priority' => 6,
            ];
        }, ['name']));

        $results = array_merge($results, $this->searchSession('bank_mutations', $lower, function ($item, $i) {
            $sign = ($item['type'] ?? 'masuk') === 'masuk' ? '+' : '-';
            return [
                'type'  => 'transaction',
                'title' => $item['desc'] ?? 'Transaksi',
                'desc'  => $sign . 'Rp ' . number_format($item['amount'] ?? 0, 0, ',', '.'),
                'url'   => route('bank-mutations.show', $i),
                'priority' => 7,
            ];
        }, ['desc']));

        $results = array_merge($results, $this->searchSession('employees', $lower, function ($item, $i) {
            return [
                'type'  => 'employee',
                'title' => $item['name'] ?? 'Karyawan',
                'desc'  => ($item['position'] ?? '-') . ' • ' . ($item['department'] ?? ''),
                'url'   => route('employees.show', $i),
                'priority' => 8,
            ];
        }, ['name', 'position']));

        $results = array_merge($results, $this->searchSession('budgets', $lower, function ($item, $i) {
            return [
                'type'  => 'budget',
                'title' => $item['category'] ?? 'Kategori',
                'desc'  => 'Target: Rp ' . number_format($item['target'] ?? 0, 0, ',', '.'),
                'url'   => route('budgets.show', $i),
                'priority' => 9,
            ];
        }, ['category']));

        $results = array_merge($results, $this->searchSession('payrolls', $lower, function ($item, $i) {
            return [
                'type'  => 'payroll',
                'title' => $item['employee'] ?? 'Karyawan',
                'desc'  => 'Rp ' . number_format($item['total'] ?? 0, 0, ',', '.') . ' • ' . ($item['period'] ?? ''),
                'url'   => route('payroll.show', $i),
                'priority' => 10,
            ];
        }, ['employee']));

        usort($results, fn ($a, $b) => $a['priority'] <=> $b['priority']);

        return response()->json(['results' => array_slice($results, 0, 20)]);
    }

    /**
     * Helper cari di dalam array session berdasarkan field tertentu.
     */
    private function searchSession(string $key, string $lowerQuery, callable $mapper, array $searchFields): array
    {
        $items = session($key, []);
        $matches = [];

        foreach ($items as $i => $item) {
            foreach ($searchFields as $field) {
                if (isset($item[$field]) && str_contains(mb_strtolower((string) $item[$field]), $lowerQuery)) {
                    $matches[] = $mapper($item, $i);
                    break;
                }
            }
        }

        return $matches;
    }
}