<?php

namespace App\Livewire\Layout\Home;

use App\Models\Trasction;
use Illuminate\Support\Carbon;
use Livewire\Component;

class StaticCards extends Component
{
    public function render()
    {   
        $thisMonth = Carbon::now()->month;
        $thisYear = Carbon::now()->year;

        $incomMoney = Trasction::where('type_transaction','Income')
                        ->whereMonth('date', $thisMonth)
                        ->whereYear('date', $thisYear)->sum('amount_money');

        $expenseMoney = Trasction::where('type_transaction','Expenditure')
                        ->whereMonth('date', $thisMonth)
                        ->whereYear('date', $thisYear)->sum('amount_money');

        $totalMoney = $incomMoney - $expenseMoney;

                        
        return view('livewire.layout.home.static-cards',[
            'incomeMoney' => $incomMoney,
            'expenseMoney' => $expenseMoney,
            'totalMoney' => $totalMoney
        ]);
    }
}
