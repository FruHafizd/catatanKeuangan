<?php

namespace App\Livewire\DebtPlans\Modal;

use Livewire\Component;
use App\Models\DebtPlan;
use App\Http\Services\DebtPlanCalculator;

class Create extends Component
{
    // ========================
    // FORM INPUT
    // ========================
    public $debt_name;
    public $total_loan;
    public $tenor_unit = 'month';
    public $tenor_value;
    public $income_type;
    public $income_value;
    public $monthly_expense;

    // ========================
    // STATE
    // ========================
    public $calculation_result = null;
    public $show_result = false;

    // Konfirmasi jika status WARNING
    public $confirm_warning = false;

    // ========================
    // VALIDATION
    // ========================
    protected $rules = [
        'debt_name' => 'required|string|min:3|max:100',
        'total_loan' => 'required|numeric|min:100000|max:10000000000', // Min 100rb, Max 10M
        'tenor_unit' => 'required|in:month,year',
        'tenor_value' => 'required|numeric|min:1|max:360', // Max 30 tahun
        'income_type' => 'required|in:daily,weekly,monthly',
        'income_value' => 'required|numeric|min:50000', // Min 50rb
        'monthly_expense' => 'required|numeric|min:500000', // Min 500rb
    ];

    protected $messages = [
        'debt_name.required' => 'Nama rencana wajib diisi',
        'debt_name.min' => 'Nama rencana minimal 3 karakter',
        'debt_name.max' => 'Nama rencana maksimal 100 karakter',

        'total_loan.required' => 'Total pinjaman wajib diisi',
        'total_loan.min' => 'Total pinjaman minimal Rp 100.000',
        'total_loan.max' => 'Total pinjaman maksimal Rp 10.000.000.000',

        'tenor_value.required' => 'Tenor wajib diisi',
        'tenor_value.min' => 'Tenor minimal 1',
        'tenor_value.max' => 'Tenor maksimal 360 bulan (30 tahun)',

        'income_type.required' => 'Pola pemasukan wajib dipilih',

        'income_value.required' => 'Jumlah pemasukan wajib diisi',
        'income_value.min' => 'Jumlah pemasukan minimal Rp 50.000',

        'monthly_expense.required' => 'Pengeluaran wajib bulanan harus diisi',
        'monthly_expense.min' => 'Pengeluaran bulanan minimal Rp 500.000 (terlalu kecil tidak realistis)',
    ];

    // ========================
    // LIVE VALIDATION
    // ========================
    public function updated($propertyName)
    {
        // Jika user ubah input setelah hasil muncul → reset hasil
        if ($this->show_result) {
            $this->show_result = false;
            $this->calculation_result = null;
            $this->confirm_warning = false;
        }

        $this->validateOnly($propertyName);
    }

    // ========================
    // VALIDASI TAMBAHAN (CUSTOM RULES)
    // ========================
    private function validateBusinessLogic()
    {
        $errors = [];

        // Konversi pendapatan ke bulanan untuk validasi
        $monthlyIncome = match($this->income_type) {
            'daily' => $this->income_value * 30.44,
            'weekly' => $this->income_value * 4.33,
            'monthly' => $this->income_value,
            default => 0,
        };

        // 1. Pengeluaran tidak boleh melebihi 80% pendapatan
        if ($this->monthly_expense >= ($monthlyIncome * 0.8)) {
            $errors['monthly_expense'] = 'Pengeluaran bulanan terlalu tinggi (≥80% pendapatan). Tidak tersisa cukup uang untuk cicilan.';
        }

        // 2. Pendapatan harus lebih besar dari pengeluaran
        if ($monthlyIncome <= $this->monthly_expense) {
            $errors['income_value'] = 'Pendapatan tidak mencukupi pengeluaran bulanan. Perhitungan tidak realistis.';
        }

        // 3. Total pinjaman tidak boleh terlalu kecil dibanding tenor
        $totalMonths = $this->tenor_unit === 'year' ? $this->tenor_value * 12 : $this->tenor_value;
        $monthlyInstallment = $this->total_loan / $totalMonths;

        if ($monthlyInstallment < 10000) {
            $errors['total_loan'] = 'Cicilan per bulan terlalu kecil (< Rp 10.000). Silakan kurangi tenor atau tingkatkan pinjaman.';
        }

        return $errors;
    }

    // ========================
    // HITUNG RENCANA
    // ========================
    public function interimCalculation()
    {
        // Validasi form standard
        $this->validate();

        // Validasi business logic
        $businessErrors = $this->validateBusinessLogic();
        if (!empty($businessErrors)) {
            foreach ($businessErrors as $field => $message) {
                $this->addError($field, $message);
            }
            return;
        }

        // Hitung menggunakan service
        try {
            $this->calculation_result = app(DebtPlanCalculator::class)->calculate([
                'total_loan' => $this->total_loan,
                'tenor_value' => $this->tenor_value,
                'tenor_unit' => $this->tenor_unit,
                'income_value' => $this->income_value,
                'income_type' => $this->income_type,
                'monthly_expense' => $this->monthly_expense,
            ]);

            $this->show_result = true;
            $this->confirm_warning = false;

        } catch (\Exception $e) {
            // Log error
            \Log::error('DebtPlanCalculator Error: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'data' => $this->all(),
            ]);

            $this->addError('calculation', 'Terjadi kesalahan saat menghitung. Silakan coba lagi atau hubungi admin.');
        }
    }

    // ========================
    // KEMBALI KE FORM
    // ========================
    public function backToForm()
    {
        $this->show_result = false;
        $this->calculation_result = null;
        $this->confirm_warning = false;
    }

    // ========================
    // SIMPAN DATA
    // ========================
    public function save()
    {
        // Validasi ulang
        $this->validate();

        if (!$this->calculation_result) {
            $this->addError('calculation', 'Hasil perhitungan tidak ditemukan. Silakan hitung ulang.');
            return;
        }

        // HARD BLOCK: Tidak layak
        if ($this->calculation_result['status'] === 'not_feasible') {
            $this->addError('save', 'Rencana tidak layak dan tidak dapat disimpan.');
            return;
        }

        // WARNING HARUS KONFIRMASI
        if (
            $this->calculation_result['status'] === 'warning' &&
            !$this->confirm_warning
        ) {
            $this->addError('confirm_warning', 'Anda harus mengkonfirmasi pemahaman risiko untuk menyimpan rencana ini.');
            return;
        }

        try {
            // Simpan ke database
            DebtPlan::create([
                'user_id' => auth()->id(),
                'debt_name' => $this->debt_name,
                'total_loan' => $this->total_loan,
                'tenor_unit' => $this->tenor_unit,
                'tenor_value' => $this->tenor_value,
                'income_type' => $this->income_type,
                'income_value' => $this->income_value,
                'monthly_expense' => $this->monthly_expense,

                // Simpan juga hasil perhitungan untuk referensi
                'monthly_installment' => $this->calculation_result['monthly_installment'] ?? null,
                'daily_saving' => $this->calculation_result['daily_saving'] ?? null,
                'status' => $this->calculation_result['status'] ?? null,
            ]);

            // Reset form
            $this->reset();

            // Dispatch success event
            $this->dispatch('debt-plan-created');
            $this->dispatch('close-modal', 'modal-create');

        } catch (\Exception $e) {
            \Log::error('DebtPlan Save Error: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
            ]);

            $this->addError('save', 'Gagal menyimpan rencana cicilan. Silakan coba lagi.');
        }
    }
    
    public function render()
    {
        return view('livewire.debt-plans.modal.create');
    }
}
