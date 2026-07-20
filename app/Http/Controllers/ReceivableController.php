<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReceivableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil data dari SESSION
        $invoices = session('invoices', []);
        
        // Filter dan mapping untuk tampilan AR
        $receivables = collect($invoices)->filter(function($invoice) {
            // Hanya tampilkan yang statusnya 'sent' atau 'overdue'
            // Kecuali 'paid' tetap muncul tapi statusnya 'lunas'
            return in_array($invoice['status'], ['sent', 'overdue', 'paid']);
        })->map(function($invoice) {
            // Mapping status dari invoice ke AR
            $arStatus = 'lancar';
            
            if ($invoice['status'] === 'overdue') {
                $arStatus = 'jatuh_tempo';
            } elseif ($invoice['status'] === 'paid') {
                $arStatus = 'lunas';
            } else {
                // Cek apakah sudah overdue (due date < today)
                $dueDate = strtotime($invoice['due']);
                $today = strtotime(date('Y-m-d'));
                if ($dueDate < $today) {
                    $arStatus = 'jatuh_tempo';
                }
            }
            
            return [
                'id' => $invoice['id'] ?? rand(1, 9999),
                'client' => $invoice['client'],
                'invoice' => $invoice['invoice'],
                'date' => $invoice['date'],
                'due' => $invoice['due'],
                'status' => $arStatus,
                'amount' => $invoice['amount'],
                'items' => $invoice['items'] ?? [],
            ];
        })->values()->toArray();

        return view('receivables.index', compact('receivables'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return redirect()->route('invoices.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $invoices = session('invoices', []);
        
        foreach ($invoices as $key => $inv) {
            if ($inv['id'] == (int)$id) {
                unset($invoices[$key]);
                break;
            }
        }
        
        session(['invoices' => array_values($invoices)]);
        
        return redirect()->route('receivables.index')->with('success', 'Faktur berhasil dihapus!');
    }
}