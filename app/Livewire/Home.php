<?php

namespace App\Livewire;

use App\Models\Transaction;
use Livewire\Component;

class Home extends Component
{    
    public function render()
    {   
        return view('livewire.home')
            ->layout('layouts.app',[
                'title' => 'Beranda'
            ]);
    }
}
