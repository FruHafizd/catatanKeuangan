<?php

namespace App\Livewire\Transactions;

use App\Models\Transaction;
use Livewire\Component;

class Create extends Component
{   
    public $amount; 
    public $type;
    public $date;
    public $description;

    protected $rules = [
        'amount' => 'required|numeric|min:1',
        'type' => 'required|in:income,expense',
        'date' => 'required|date',
        'description' => 'required|string|min:3'
    ];

    protected $messages = [
        'amount.required' => 'Jumlah tidak boleh kosong',
        'amount.numeric' => 'Jumlah harus berupa angka',
        'type.required' => 'Type tidak boleh kosong',
        'date.required' => 'Tanggal tidak boleh kosong',
        'description.required' => 'Deskripsi tidak boleh kosong',
        'type.in' => 'Type tidak valid',
        'date.date' => 'Format tanggal tidak valid',
        'description.min' => 'Deskripsi minimal 3 karakter',
    ];

    public function save()  {

        $this->validate();

        Transaction::create([
            'user_id' => auth()->id(),
            'amount' => $this->amount,
            'type' => $this->type,
            'date' => $this->date,
            'description' => $this->description
        ]);
        $this->reset();
        $this->dispatch('close-modal', 'modal-create');
        $this->dispatch('transaction-created');
    }

    public function render()
    {
        return view('livewire.transactions.create');
    }
}
