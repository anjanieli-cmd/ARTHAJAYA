<?php

namespace App\Notifications;

use App\Models\ExpenseSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ExpenseReviewed extends Notification
{
    use Queueable;

    public function __construct(public ExpenseSubmission $expense)
    {
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        $label = $this->expense->status === 'approved' ? 'disetujui' : 'ditolak';

        return [
            'type'       => 'expense_reviewed',
            'expense_id' => $this->expense->id,
            'title'      => $this->expense->status === 'approved' ? 'Pengeluaran Disetujui' : 'Pengeluaran Ditolak',
            'message'    => 'Pengajuan "' . $this->expense->description . '" sebesar Rp' . number_format($this->expense->amount, 0, ',', '.') . ' telah ' . $label . '.',
            'url'        => route('user.expenses.index'),
            'status'     => $this->expense->status,
        ];
    }
}