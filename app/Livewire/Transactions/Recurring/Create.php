<?php

namespace App\Livewire\Transactions\Recurring;

use App\Models\RecurringTransaction;
use Livewire\Component;

class Create extends Component
{
    public $name;
    public $type;
    public $amount;
    public $is_active;
    public $frequency;
    public $start_date;
    public $end_date;
    
    protected $rules = [
        'name' => 'required|string|min:3',
        'amount' => 'required|integer|min:1',
        'type' => 'required|in:income,expense',
        'start_date' => 'required|date|after_or_equal:today',
        'end_date' => 'required|date|after_or_equal:start_date',
        'frequency' => 'required|in:daily,weekly,monthly,yearly',
    ];


    protected $messages = [
        'amount.required' => 'Jumlah tidak boleh kosong',
        'amount.integer' => 'Jumlah harus berupa angka',
        'type.required' => 'Type tidak boleh kosong',
        'start_date.required' => 'Tanggal tidak boleh kosong',
        'end_date.required' => 'Tanggal tidak boleh kosong',
        'name.required' => 'Nama tidak boleh kosong',
        'frequency.required' => 'Frekuensi tidak boleh kosong',
        'type.in' => 'Type tidak valid',
        'start_date.date' => 'Format tanggal tidak valid',
        'end_date.date' => 'Format tanggal tidak valid',
        'name.min' => 'Nama minimal 3 karakter',
        'start_date.after_or_equal' => 'Tanggal tidak boleh kurang dari hari ini.',
        'end_date.after_or_equal' => 'Tanggal tidak boleh kurang dari hari ini.',
    ];

    public function save() {
        $this->validate();

        RecurringTransaction::create([
            'user_id' => auth()->id(),
            'name' => $this->name,
            'amount' =>  (int) $this->amount,
            'type' => $this->type,
            'frequency' => $this->frequency,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'is_active' => true
        ]);
       $this->reset([
            'name','type','amount','frequency','start_date','end_date'
        ]);
        $this->dispatch('close-modal','modal-create');
        $this->dispatch(event: 'recurring-transaction-created');
    }

    public function render()
    {
        return view('livewire.transactions.recurring.create');
    }
}
