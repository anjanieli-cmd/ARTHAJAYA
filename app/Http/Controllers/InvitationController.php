<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Http\Request;

class InvitationController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $invitations = Invitation::where('company_id', $user->company_id)
            ->latest()
            ->get();

        return view('staff.invitations', compact('invitations'));
    }

    public function store(Request $request)
    {
        $user = $request->user();

        if (! $user->company_id) {
            return back()->withErrors(['company' => 'Lengkapi onboarding perusahaan dulu sebelum mengundang User.']);
        }

        $invitation = Invitation::generateForCompany($user->company_id, $user->id);

        return back()->with('newCode', $invitation->code);
    }
}