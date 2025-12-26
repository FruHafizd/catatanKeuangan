<?php

namespace App\Livewire;

use App\Models\Trasction;
use Livewire\Component;
use Livewire\WithPagination;

class TransactionHistory extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $year;
    public $month;
    public $type_transaction;
    public $payment_method;

    public function mount()
    {
        $this->year = Trasction::max(\DB::raw('YEAR(date)'));
        $this->month = null;
    }

    /** reset page saat filter berubah */
    public function updated($property)
    {
        if (in_array($property, [
            'year', 'month', 'type_transaction', 'payment_method'
        ])) {
            $this->resetPage();
        }
    }

    public function clearFilter()
    {
        $this->reset([
            'year',
            'month',
            'type_transaction',
            'payment_method'
        ]);
        $this->resetPage();
    }

    /** QUERY UTAMA */
    public function getTransactionProperty()
    {
        return Trasction::query()
            ->when($this->year, fn ($q) =>
                $q->whereYear('date', $this->year)
            )
            ->when($this->month, fn ($q) =>
                $q->whereMonth('date', $this->month)
            )
            ->when($this->type_transaction, fn ($q) =>
                $q->where('type_transaction', $this->type_transaction)
            )
            ->when($this->payment_method, fn ($q) =>
                $q->where('payment_method', $this->payment_method)
            )
            ->latest('date')
            ->paginate(5);
    }

    /** RINGKASAN IKUT FILTER */

    public function getYearsProperty()
    {
        return Trasction::selectRaw('YEAR(date) as year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');
    }

    public function getTotalIncomeProperty()
    {
        return $this->transaction
            ->where('type_transaction', 'Income')
            ->sum('amount_money');
    }

    public function getTotalExpenditureProperty()
    {
        return $this->transaction
            ->where('type_transaction', 'Expenditure')
            ->sum('amount_money');
    }

    public function getBalanceProperty()
    {
        return $this->totalIncome - $this->totalExpenditure;
    }

    public function render()
    {
        return view('livewire.transaction-history')
            ->layout('layouts.app', [
                'title' => 'Riwayat Transaksi'
            ]);
    }
}
