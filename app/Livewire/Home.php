<?php

namespace App\Livewire;

use App\Models\Trasction;
use Livewire\Component;

class Home extends Component
{    
    public function render()
    {   
        $transaction = Trasction::latest()->limit(10)->get();

        return view('livewire.home',[
           "transactions" => $transaction 
        ])
            ->layout('layouts.app',[
                'title' => 'Beranda'
            ]);
    }
}
