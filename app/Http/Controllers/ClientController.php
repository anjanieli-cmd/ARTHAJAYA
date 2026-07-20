<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $company = Auth::user()->company;
        $companyId = $company->id;

        $clients = Client::where('company_id', $companyId)
            ->when($request->filled('q'), function ($query) use ($request) {
                $search = $request->q;
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('company_name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->withCount(['invoices', 'quotes'])
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        // dihitung dari total company, bukan hasil filter/pagination di atas
        $stats = [
            'total_count'         => Client::where('company_id', $companyId)->count(),
            'with_invoices_count' => Client::where('company_id', $companyId)
                                        ->has('invoices')
                                        ->count(),
            'outstanding_amount'  => Invoice::where('company_id', $companyId)
                                        ->whereNotIn('status', ['paid', 'cancelled'])
                                        ->sum('total'),
            'new_this_month'      => Client::where('company_id', $companyId)
                                        ->whereYear('created_at', now()->year)
                                        ->whereMonth('created_at', now()->month)
                                        ->count(),
        ];

        return view('clients.index', compact('clients', 'stats', 'company'));
    }

    public function create()
    {
        $company = Auth::user()->company;

        return view('clients.create', compact('company'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['company_id'] = Auth::user()->company->id;

        Client::create($data);

        return redirect()->route('clients.index')->with('success', 'Klien berhasil ditambahkan.');
    }

    public function show(Client $client)
    {
        $company = Auth::user()->company;

        $client->loadCount(['invoices', 'quotes']);
        $client->load([
            'invoices' => fn ($q) => $q->latest('issue_date')->limit(5),
            'quotes'   => fn ($q) => $q->latest('issue_date')->limit(5),
        ]);

        return view('clients.show', compact('client', 'company'));
    }

    public function edit(Client $client)
    {
        $company = Auth::user()->company;

        return view('clients.edit', compact('client', 'company'));
    }

    public function update(Request $request, Client $client)
    {
        $data = $this->validateData($request);

        $client->update($data);

        return redirect()->route('clients.index')->with('success', 'Klien berhasil diperbarui.');
    }

    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->route('clients.index')->with('success', 'Klien berhasil dihapus.');
    }

    protected function validateData(Request $request): array
    {
        return $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'email'        => ['nullable', 'email', 'max:255'],
            'phone'        => ['nullable', 'string', 'max:50'],
            'address'      => ['nullable', 'string'],
            'notes'        => ['nullable', 'string'],
        ]);
    }
}