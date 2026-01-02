<?php

namespace App\Livewire\Transactions;

use App\Models\Transaction;
use Illuminate\Support\Carbon;
use Livewire\Component;

class StaticCards extends Component
{    
    protected $listeners = [
        'transaction-created' => '$refresh',
        'transaction-deleted' => '$refresh',
        'transaction-updated' => '$refresh',
    ];

    public function getSummaryProperty()  
    {
        $now = Carbon::now();
        
        $transactions = Transaction::where('user_id', auth()->id())
                                    ->whereMonth('date', $now->month)
                                    ->whereYear('date', $now->year)
                                    ->select('type', 'amount')
                                    ->get();
        
        $income = $transactions
                    ->where('type','income')
                    ->sum('amount');
        
        $expense = $transactions
                    ->where('type', 'expense')
                    ->sum('amount');

        return [
          'income' => $income,
          'expense' => $expense,
          'difference' => $income - $expense  
        ];
    }


    public function render()
    {
        return view('livewire.transactions.static-cards',[
            'summary' => $this->summary
        ]);
    }
}
