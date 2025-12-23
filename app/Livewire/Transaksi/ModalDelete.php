<?php

namespace App\Livewire\Transaksi;

use App\Models\Trasction;
use Livewire\Component;
use Livewire\Attributes\On;

class ModalDelete extends Component
{
    public $transactionId;

    #[On('confirm-delete')]
    public function setTransaction($id)
    {
        $this->transactionId = $id;
    }

    public function destroy()
    {
        Trasction::findOrFail($this->transactionId)->delete();

        $this->dispatch('close-modal', 'modal-delete');
    }

    public function render()
    {
        return view('livewire.transaksi.modal-delete');
    }
}
