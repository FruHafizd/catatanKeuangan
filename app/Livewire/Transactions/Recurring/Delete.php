<?php

namespace App\Livewire\Transactions\Recurring;

use App\Models\RecurringTransaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Delete extends Component
{
    protected $listeners = [
        'delete-recurring-transaction' => 'confirmDelete',
    ];

    public ?int $recurringTransactionId = null;

    public function confirmDelete(int $id): void
    {
        $this->recurringTransactionId = $id;
    }

    public function delete(): void
    {
        if (!$this->recurringTransactionId) {
            return;
        }

        $recurring = RecurringTransaction::query()
            ->whereKey($this->recurringTransactionId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($recurring->transactions()->exists()) {
            $recurring->update(['is_active' => false]);
        } else {
            $recurring->delete();
        }

        $this->dispatch('recurring-transaction-deleted');
        $this->close();
    }

    private function close(): void
    {
        $this->reset('recurringTransactionId');
        $this->dispatch('close-modal', 'modal-delete');
    }

    public function render()
    {
        return view('livewire.transactions.recurring.delete');
    }
}
