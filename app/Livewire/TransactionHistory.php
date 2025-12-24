<?php

namespace App\Livewire;

use Livewire\Component;

class TransactionHistory extends Component
{
    public function render()
    {
        return view('livewire.transaction-history')
            ->layout('layouts.app',[
                'title' => 'Riwayat Transaksi'
            ]);;
    }
}
