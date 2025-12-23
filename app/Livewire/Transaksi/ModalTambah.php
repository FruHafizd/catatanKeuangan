<?php

namespace App\Livewire\Transaksi;

use App\Models\Trasction;
use Livewire\Component;

class ModalTambah extends Component
{
    public $date;
    public $amount_money;
    public $type_transaction;
    public $payment_method;
    public $information;

    protected $rules = [
        'date' => 'required|date',
        'amount_money' => 'required|numeric|min:1',
        'type_transaction' => 'required',
        'payment_method' => 'required',
        'information' => 'required',
    ];

    public function submit()
    {   
        $this->validate();
        try {
            Trasction::create([
                'date' => $this->date,
                'amount_money' => $this->amount_money,
                'type_transaction' => $this->type_transaction,
                'payment_method' => $this->payment_method,
                'information' => $this->information
            ]);

            return redirect()->to("/home");
        } catch (\Exception $ex) {
            
        }
    }

    public function render()
    {
        return view('livewire.transaksi.modal-tambah');
    }
}
