<?php

namespace App\Livewire\DebtPlans\Modal;

use Livewire\Component;
use App\Models\DebtPlan;
use App\Http\Services\DebtPlanCalculator;

class Create extends Component
{
    public $debt_name;
    public $total_loan;
    public $tenor_unit = 'month';
    public $tenor_value;
    public $income_type;
    public $income_value;

    // Properties untuk hasil perhitungan
    public $calculation_result = null;
    public $is_feasible = null;
    public $warning_message = null;
    public $daily_saving = null;
    public $ratio_percentage = null;

    protected $rules = [
        'debt_name' => 'required|string|min:3',
        'total_loan' => 'required|numeric|min:1',
        'tenor_unit' => 'required|in:month,year',
        'tenor_value' => 'required|numeric',
        'income_type' => 'required|in:daily,weekly,yearly',
        'income_value' => 'required|numeric|min:1'
    ];

    protected $messages = [
        'debt_name.required' => 'Nama rencana wajib diisi',
        'total_loan.required' => 'Total pinjaman wajib diisi',
        'total_loan.min' => 'Total pinjaman harus lebih dari 0',
        'tenor_value.required' => 'Tenor wajib diisi',
        'tenor_value.min' => 'Tenor minimal 1',
        'income_type.required' => 'Pola pemasukan wajib dipilih',
        'income_value.required' => 'Jumlah pemasukan wajib diisi',
        'income_value.min' => 'Jumlah pemasukan harus lebih dari 0',
    ];

    public function save() {
        $this->validate();

        $result = $this->calculateInstallment();

        $this->calculation_result = $result;

        if (!$result['is_feasible']) {
            $this->addError('calculation', $result['message']);
            return;
        }

        DebtPlan::create([
            'user_id' => auth()->id(),
            'debt_name' => $this->debt_name,
            'total_loan' => $this->total_loan,
            'tenor_unit' => $this->tenor_unit,
            'tenor_value' => $this->tenor_value,
            'income_type' => $this->income_type,
            'income_value' => $this->income_value
        ]);

        session()->flash('message', 'Rencana cicilan berhasil disimpan');

    }

    private function calculateInstallment()
    {
        return app(DebtPlanCalculator::class)->calculate([
            'total_loan' => $this->total_loan,
            'tenor_value' => $this->tenor_value,
            'tenor_unit' => $this->tenor_unit,
            'income_value' => $this->income_value,
            'income_type' => $this->income_type,
        ]);
    }

    //  Real-time calculation saat user mengisi form (opsional)
        public function updatedTotalLoan()
    {
        $this->calculatePreview();
    }

    public function updatedTenorValue()
    {
        $this->calculatePreview();
    }

    public function updatedIncomeValue()
    {
        $this->calculatePreview();
    }

    private function calculatePreview()
    {
        if ($this->total_loan && $this->tenor_value && $this->income_value && $this->income_type) {
            $this->calculation_result = $this->calculateInstallment();
            $this->daily_saving = $this->calculation_result['daily_saving'];
            $this->ratio_percentage = $this->calculation_result['ratio_percentage'];
            $this->is_feasible = $this->calculation_result['is_feasible'];
            $this->warning_message = $this->calculation_result['message'];
        }
    }

    public function render()
    {
        return view('livewire.debt-plans.modal.create');
    }
}
