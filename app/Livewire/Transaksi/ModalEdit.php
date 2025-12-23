<?php

namespace App\Livewire\Transaksi;

use App\Models\Trasction;
use Livewire\Attributes\On;
use Livewire\Component;

class ModalEdit extends Component
{
    public $transactionId;
    public $date;
    public $amount_money;
    public $type_transaction;
    public $payment_method;
    public $information;

    #[On('edit-transaction')]
    public function edit($id)
    {
        $transaction = Trasction::findOrFail($id);

        $this->transactionId    = $transaction->id;
        $this->date             = $transaction->date;
        $this->amount_money     = $transaction->amount_money;
        $this->type_transaction = $transaction->type_transaction;
        $this->payment_method   = $transaction->payment_method;
        $this->information      = $transaction->information;
    }

    public function update()
    {
        Trasction::where('id', $this->transactionId)->update([
            'date'             => $this->date,
            'amount_money'     => $this->amount_money,
            'type_transaction' => $this->type_transaction,
            'payment_method'   => $this->payment_method,
            'information'      => $this->information,
        ]);

        $this->dispatch('close-modal', 'modal-edit');
    }

    public function render()
    {
        return view('livewire.transaksi.modal-edit');
    }
}
