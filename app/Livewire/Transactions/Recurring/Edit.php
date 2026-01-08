<?php

namespace App\Livewire\Transactions\Recurring;

use App\Models\RecurringTransaction;
use Livewire\Component;

class Edit extends Component
{   
    public $recurringTransactionsId;
    public $name;
    public $type;
    public $amount;
    public $is_active;
    public $frequency;
    public $start_date;
    public $end_date;
    
    protected $listeners = [
        'edit-recurring-transaction' => 'recurringLoadTransaction',
        'close-edit-modal' => 'resetForm',
    ];

    protected $rules = [
        'name' => 'required|string|min:3',
        'amount' => 'required|integer|min:1',
        'type' => 'required|in:income,expense',
        'frequency' => 'required|in:daily,weekly,monthly,yearly',
        'start_date' => 'required|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
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

    public function recurringLoadTransaction($id)  {
        $this->resetForm();
        $recurringTransaction = RecurringTransaction::where('id',$id)
                        ->where('user_id', auth()->id())
                        ->firstOrFail();

        $this->recurringTransactionsId = $recurringTransaction->id;
        $this->name = $recurringTransaction->name;
        $this->amount = $recurringTransaction->amount;
        $this->type = $recurringTransaction->type;   
        $this->frequency = $recurringTransaction->frequency;   
        $this->start_date = $recurringTransaction->start_date->format('Y-m-d');
        $this->end_date = $recurringTransaction->end_date->format('Y-m-d');
        $this->is_active = $recurringTransaction->is_active;
    }

    public function resetForm()  {
        $this->reset([
            'recurringTransactionsId',
            'amount',
            'type',
            'frequency',
            'start_date',
            'end_date',
            'name',
            'is_active'
        ]);
    }

    public function update()  {
        if (!$this->recurringTransactionsId) {
            return;
        }

        $this->validate();
        $recurring = RecurringTransaction::where('id', $this->recurringTransactionsId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $recurring->update([
            'name' => $this->name,
            'amount' => (int) $this->amount,
            'type' => $this->type,
            'frequency' => $this->frequency,
            'end_date' => $this->end_date,
            'is_active' => $this->is_active,
        ]);

        $this->resetForm();
        $this->dispatch('recurring-transaction-updated');
        $this->dispatch('close-modal','modal-edit-recurring-transaction');
    }

    public function render()
    {
        return view('livewire.transactions.recurring.edit');
    }
}
