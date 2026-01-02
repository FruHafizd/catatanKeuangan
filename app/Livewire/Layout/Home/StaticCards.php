<?php

namespace App\Livewire\Layout\Home;

use App\Models\Transaction;
use Illuminate\Support\Carbon;
use Livewire\Component;

class StaticCards extends Component
{   
    public function calculateMontlySummary($month, $year) 
    {
        $income = Transaction::where("user_id",auth()->id())
                            ->where("type","income")
                            ->whereMonth("date",$month)
                            ->whereYear("date",$year)
                            ->sum("amount");
        $expnse = Transaction::where("user_id", auth()->id())
                            ->where("type","expense")
                            ->whereMonth("date",$month)
                            ->whereYear("date",$year)
                            ->sum("amount");
        $diffrence = $income - $expnse;
    }

    public function render()
    {   
        $thisMonth = Carbon::now()->month;
        $thisYear = Carbon::now()->year;

        $incomMoney = Transaction::where('type','income')
                        ->whereMonth('date', $thisMonth)
                        ->whereYear('date', $thisYear)->sum('amount');

        $expenseMoney = Transaction::where('type','expense')
                        ->whereMonth('date', $thisMonth)
                        ->whereYear('date', $thisYear)->sum('amount');

        $totalMoney = $incomMoney - $expenseMoney;

                        
        return view('livewire.layout.home.static-cards',[
            'incomeMoney' => $incomMoney,
            'expenseMoney' => $expenseMoney,
            'totalMoney' => $totalMoney
        ]);
    }
}
