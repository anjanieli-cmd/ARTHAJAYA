<?php

namespace App\Http\Controllers;

use App\Models\TaxCalendarEvent;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;

class TaxCalendarController extends Controller
{
    use LogsActivity;

    public function index(Request $request)
    {
        $user = $request->user();
        $company = $user->company;

        $query = TaxCalendarEvent::where('company_id', $company->id)
            ->orderBy('date');

        if ($q = $request->get('q')) {
            $q = strtolower($q);

            $query->where(function ($sub) use ($q) {
                $sub->whereRaw('LOWER(title) LIKE ?', ["%{$q}%"])
                    ->orWhereRaw('LOWER(type) LIKE ?', ["%{$q}%"]);
            });
        }

        $calendarEvents = $query->get()->map(function ($event) {
            return [
                '_index' => $event->id,
                'title'  => $event->title,
                'date'   => $event->date->format('Y-m-d'),
                'type'   => $event->type,
                'status' => $event->status,
                'desc'   => $event->desc,
            ];
        })->toArray();

        if ($request->ajax()) {
            return view(
                'tax-calendar.index',
                compact('user', 'company', 'calendarEvents')
            )->render();
        }

        return view(
            'tax-calendar.index',
            compact('user', 'company', 'calendarEvents')
        );
    }

    public function create(Request $request)
    {
        $user = $request->user();
        $company = $user->company;

        return view('tax-calendar.create', compact('user', 'company'));
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'date'  => 'required|date',
            'type'  => 'required|in:pph,ppn',
            'desc'  => 'nullable|string',
        ]);

        $event = TaxCalendarEvent::create([
            'company_id' => $user->company_id,
            'title'      => $validated['title'],
            'date'       => $validated['date'],
            'type'       => $validated['type'],
            'desc'       => $validated['desc'] ?? null,
        ]);

        // Masuk ke Riwayat
        $this->logActivity(
            'created',
            "Menambahkan event pajak {$event->title}",
            $event
        );

        return redirect()
            ->route('tax-calendar.index')
            ->with('success', 'Event berhasil ditambahkan!');
    }

    public function show(Request $request, $index)
    {
        $user = $request->user();

        $event = TaxCalendarEvent::where(
            'company_id',
            $user->company_id
        )->findOrFail($index);

        return view('tax-calendar.show', [
            'user' => $user,
            'company' => $user->company,
            'event' => [
                '_index' => $event->id,
                'title'  => $event->title,
                'date'   => $event->date->format('Y-m-d'),
                'type'   => $event->type,
                'status' => $event->status,
                'desc'   => $event->desc,
            ],
            'index' => $event->id,
        ]);
    }

    public function edit(Request $request, $index)
    {
        $user = $request->user();

        $event = TaxCalendarEvent::where(
            'company_id',
            $user->company_id
        )->findOrFail($index);

        return view('tax-calendar.edit', [
            'user' => $user,
            'company' => $user->company,
            'event' => [
                '_index' => $event->id,
                'title'  => $event->title,
                'date'   => $event->date->format('Y-m-d'),
                'type'   => $event->type,
                'status' => $event->status,
                'desc'   => $event->desc,
            ],
            'index' => $event->id,
        ]);
    }

    public function update(Request $request, $index)
    {
        $user = $request->user();

        $event = TaxCalendarEvent::where(
            'company_id',
            $user->company_id
        )->findOrFail($index);

        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'date'  => 'required|date',
            'type'  => 'required|in:pph,ppn',
            'desc'  => 'nullable|string',
        ]);

        $event->update([
            'title' => $validated['title'],
            'date'  => $validated['date'],
            'type'  => $validated['type'],
            'desc'  => $validated['desc'] ?? null,
        ]);

        // Masuk ke Riwayat
        $this->logActivity(
            'updated',
            "Mengupdate event pajak {$event->title}",
            $event
        );

        return redirect()
            ->route('tax-calendar.index')
            ->with('success', 'Event berhasil diupdate!');
    }

    public function destroy(Request $request, $index)
    {
        $user = $request->user();

        $event = TaxCalendarEvent::where(
            'company_id',
            $user->company_id
        )->findOrFail($index);

        $title = $event->title;

        // Simpan data sebelum dihapus kalau trait membutuhkan model
        $this->logActivity(
            'deleted',
            "Menghapus event pajak {$title}",
            $event
        );

        $event->delete();

        return redirect()
            ->route('tax-calendar.index')
            ->with('success', 'Event berhasil dihapus!');
    }
}