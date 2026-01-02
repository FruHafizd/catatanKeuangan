<?php

namespace App\Livewire\Transactions;

use App\Models\Transaction;
use Livewire\Component;

class Index extends Component
{   
    protected $listeners = [
        'transaction-created' => '$refresh',
        'transaction-deleted' => '$refresh',
        'transaction-updated' => '$refresh'
    ];

    public function render()
    {
        return view('livewire.transactions.index',[
            'transactions' => $this->transactions,
        ]);
    }

    public function getTransactionsProperty()  {
        return Transaction::where('user_id', auth()->id())
            ->latest()
            ->limit(9)
            ->get();
    }
}
