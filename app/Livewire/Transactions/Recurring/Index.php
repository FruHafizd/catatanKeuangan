<?php

namespace App\Livewire\Transactions\Recurring;

use App\Models\RecurringTransaction;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{      
    use WithPagination;
    protected $paginationTheme = 'tailwind';

    protected $listeners = [
        'recurring-transaction-created' => '$refresh',
        'recurring-transaction-updated' => '$refresh',
        'recurring-transaction-deleted' => '$refresh',
    ];

    public function render()
    {
        return view('livewire.transactions.recurring.index',[
            'recurringTransactions' => $this->recurringTransactions
        ])->layout('layouts.app', ['title' => 'Transaksi Berulang']);
    }

    public function getRecurringTransactionsProperty()  {
        return RecurringTransaction::where('user_id', auth()->id())->orderBy('is_active', 'desc')->paginate(10);
    }
}
