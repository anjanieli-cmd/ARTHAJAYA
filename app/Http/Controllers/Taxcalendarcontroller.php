<?php

namespace App\Http\Controllers;

use App\Models\TaxCalendarEvent;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaxCalendarController extends Controller
{
    use LogsActivity;

    public function index(Request $request)
    {
        $user = Auth::user();
        $company = $user->company;

        $query = TaxCalendarEvent::where('company_id', $company->id)->orderBy('date');

        if ($request->filled('q')) {
            $q = strtolower($request->q);
            $query->where(function ($sub) use ($q) {
                $sub->whereRaw('LOWER(title) LIKE ?', ["%{$q}%"])
                    ->orWhereRaw('LOWER(type) LIKE ?', ["%{$q}%"]);
            });
        }

        $calendarEvents = $query->get();

        if ($request->ajax()) {
            return view('tax-calendar.index', compact('user', 'company', 'calendarEvents'))->render();
        }

        return view('tax-calendar.index', compact('user', 'company', 'calendarEvents'));
    }

    public function create()
    {
        $user = Auth::user();
        $company = $user->company;
        return view('tax-calendar.create', compact('user', 'company'));
    }

    public function store(Request $request)
    {
        $company = Auth::user()->company;

        $data = $request->validate([
            'title'  => 'required|string|max:255',
            'date'   => 'required|date',
            'type'   => 'nullable|string',
            'desc'   => 'nullable|string',
            'status' => 'nullable|string',
        ]);

        $event = TaxCalendarEvent::create([
            'company_id'  => $company->id,
            'title'       => $data['title'],
            'date'        => $data['date'],
            'type'        => $data['type'] ?? null,
            'status'      => $data['status'] ?? 'upcoming',
            'description' => $data['desc'] ?? null,
        ]);

        $this->logActivity('created', "Menambahkan event pajak: {$event->title}", $event);

        return redirect()->route('tax-calendar.index')->with('success', 'Event berhasil ditambahkan!');
    }

    public function show(TaxCalendarEvent $taxCalendarEvent)
    {
        $this->authorizeCompany($taxCalendarEvent);
        $user = Auth::user();
        $company = $user->company;
        $event = $taxCalendarEvent;
        return view('tax-calendar.show', compact('user', 'company', 'event'));
    }

    public function edit(TaxCalendarEvent $taxCalendarEvent)
    {
        $this->authorizeCompany($taxCalendarEvent);
        $user = Auth::user();
        $company = $user->company;
        $event = $taxCalendarEvent;
        return view('tax-calendar.edit', compact('user', 'company', 'event'));
    }

    public function update(Request $request, TaxCalendarEvent $taxCalendarEvent)
    {
        $this->authorizeCompany($taxCalendarEvent);

        $taxCalendarEvent->update([
            'title'       => $request->input('title', $taxCalendarEvent->title),
            'date'        => $request->input('date', $taxCalendarEvent->date),
            'type'        => $request->input('type', $taxCalendarEvent->type),
            'status'      => $request->input('status', $taxCalendarEvent->status),
            'description' => $request->input('desc', $taxCalendarEvent->description),
        ]);

        $this->logActivity('updated', "Mengupdate event pajak: {$taxCalendarEvent->title}", $taxCalendarEvent);

        return redirect()->route('tax-calendar.index')->with('success', 'Event berhasil diupdate!');
    }

    public function destroy(TaxCalendarEvent $taxCalendarEvent)
    {
        $this->authorizeCompany($taxCalendarEvent);

        $title = $taxCalendarEvent->title;
        $taxCalendarEvent->delete();

        $this->logActivity('deleted', "Menghapus event pajak: {$title}");

        return redirect()->route('tax-calendar.index')->with('success', 'Event berhasil dihapus!');
    }

    private function authorizeCompany(TaxCalendarEvent $taxCalendarEvent): void
    {
        abort_unless($taxCalendarEvent->company_id === Auth::user()->company->id, 404);
    }
}