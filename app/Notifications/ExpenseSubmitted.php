<?php

namespace App\Notifications;

use App\Models\ExpenseSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ExpenseSubmitted extends Notification
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
        return [
            'type'        => 'expense_submitted',
            'expense_id'  => $this->expense->id,
            'title'       => 'Pengajuan Pengeluaran Baru',
            'message'     => $this->expense->submitter->name . ' mengajukan pengeluaran "' . $this->expense->description . '" sebesar Rp' . number_format($this->expense->amount, 0, ',', '.'),
            'url' => route('staff.expense-approvals.index'),
        ];
    }
}