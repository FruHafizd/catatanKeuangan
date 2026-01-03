<?php

namespace App\Livewire\Transactions\History;

use App\Models\Transaction;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{   
    use WithPagination;
    protected $paginationTheme = 'tailwind';

    public function getTransactionsProperty(){
        return Transaction::where('user_id', auth()->id())->paginate(10);
    }

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
        return view('livewire.transactions.history.index',[
            'transactions' => $this->transactions,
            'summary' => $this->summary
        ])->layout('layouts.app', [
                'title' => 'Riwayat Transaksi'
            ]);;
    }
}
