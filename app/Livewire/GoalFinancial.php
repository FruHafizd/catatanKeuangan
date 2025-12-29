<?php

namespace App\Livewire;

use App\Models\GoalFinancial as ModelsGoalFinancial;
use Livewire\Component;

class GoalFinancial extends Component
{
    public $targets = [];

    public function mount()
    {
        $this->targets = ModelsGoalFinancial::latest()->get();
    }

    public function render()
    {
        return view('livewire.goal-financial')
            ->layout('layouts.app');
    }
}
