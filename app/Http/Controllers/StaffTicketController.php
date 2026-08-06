<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketReply;
use App\Models\User;
use App\Notifications\TicketCreated;
use App\Notifications\TicketReplied;
use Illuminate\Http\Request;

class StaffTicketController extends Controller
{
    /**
     * Daftar tiket milik staff yang sedang login.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $tickets = Ticket::where('user_id', $user->id)
            ->latest()
            ->get();

        return view('staff.tickets.index', compact('tickets'));
    }

    /**
     * Form bikin tiket baru.
     */
    public function create()
    {
        return view('staff.tickets.create');
    }

    /**
     * Simpan tiket baru & notify semua admin di company yang sama.
     */
    public function store(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'subject'  => ['required', 'string', 'max:255'],
            'category' => ['required', 'in:technical,billing,feature_request,other'],
            'priority' => ['required', 'in:low,medium,high'],
            'message'  => ['required', 'string', 'max:2000'],
        ]);

        $ticket = Ticket::create([
            'company_id' => $user->company_id,
            'user_id'    => $user->id,
            'subject'    => $validated['subject'],
            'category'   => $validated['category'],
            'priority'   => $validated['priority'],
            'message'    => $validated['message'],
            'status'     => 'open',
        ]);

        // Notify semua admin di company yang sama
        $admins = User::where('company_id', $user->company_id)
            ->where('access_level', \App\Enums\AccessLevel::Admin)
            ->get();

        foreach ($admins as $admin) {
            $admin->notify(new TicketCreated($ticket));
        }

        return redirect()->route('staff.tickets.show', $ticket->id)
            ->with('success', 'Tiket berhasil diajukan.');
    }

    /**
     * Detail tiket + thread balasan.
     */
    public function show(Request $request, Ticket $ticket)
    {
        $user = $request->user();

        abort_unless($ticket->user_id === $user->id, 403);

        $ticket->load('replies.user');

        return view('staff.tickets.show', compact('ticket'));
    }

    /**
     * Staff membalas tiketnya sendiri.
     */
    public function reply(Request $request, Ticket $ticket)
    {
        $user = $request->user();

        abort_unless($ticket->user_id === $user->id, 403);

        if ($ticket->status === 'closed') {
            return back()->with('error', 'Tiket ini sudah ditutup.');
        }

        $validated = $request->validate([
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $reply = TicketReply::create([
            'ticket_id'      => $ticket->id,
            'user_id'        => $user->id,
            'is_admin_reply' => false,
            'message'        => $validated['message'],
        ]);

        // Notify semua admin di company yang sama
        $admins = User::where('company_id', $user->company_id)
            ->where('access_level', \App\Enums\AccessLevel::Admin)
            ->get();

        foreach ($admins as $admin) {
            $admin->notify(new TicketReplied($ticket, $reply));
        }

        return redirect()->route('staff.tickets.show', $ticket->id);
    }
}