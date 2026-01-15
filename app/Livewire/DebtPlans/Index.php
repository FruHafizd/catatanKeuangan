<?php

namespace App\Livewire\DebtPlans;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.debt-plans.index')->layout('layouts.app');
    }
}
