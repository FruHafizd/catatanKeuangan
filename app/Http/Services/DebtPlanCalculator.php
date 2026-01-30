<?php

namespace App\Http\Services;

class DebtPlanCalculator
{
    // Konstanta untuk standar keuangan
    const SAFE_DEBT_RATIO = 30;        // Rasio cicilan aman (%)
    const WARNING_DEBT_RATIO = 35;     // Rasio cicilan peringatan (%)
    const MAXIMUM_DEBT_RATIO = 40;     // Rasio cicilan maksimal (%)
    const MINIMUM_BUFFER = 500000;     // Buffer minimal per bulan (Rp)
    const DAYS_PER_MONTH = 30.44;      // Rata-rata hari per bulan
    const WEEKS_PER_MONTH = 4.33;      // Rata-rata minggu per bulan

    public function calculate(array $data): array
    {
        // 1. Normalisasi ke BULANAN
        $monthlyIncome = $this->convertIncomeToMonthly(
            $data['income_value'],
            $data['income_type']
        );

        $totalMonths = $this->convertTenorToMonths(
            $data['tenor_value'],
            $data['tenor_unit']
        );

        $monthlyInstallment = $data['total_loan'] / $totalMonths;
        $monthlyExpense = $data['monthly_expense'];

        // 2. Hitung nilai turunan
        $dailyIncome = $monthlyIncome / self::DAYS_PER_MONTH;
        $dailyInstallment = $monthlyInstallment / self::DAYS_PER_MONTH;
        $remainingMoney = $monthlyIncome - $monthlyExpense - $monthlyInstallment;
        $ratio = ($monthlyInstallment / $monthlyIncome) * 100;

        // 3. Hitung DAILY SAVING (Tabungan harian yang harus disisihkan)
        $totalDays = $totalMonths * self::DAYS_PER_MONTH;
        $dailySaving = $data['total_loan'] / $totalDays;

        // 4. Evaluasi KELAYAKAN
        $evaluation = $this->evaluate(
            $monthlyIncome,
            $monthlyExpense,
            $monthlyInstallment,
            $remainingMoney
        );

        // 5. Result FINAL
        $result = [
            'status' => $evaluation['status'],
            'message' => $evaluation['message'],
            'is_feasible' => $evaluation['status'] === 'feasible',

            // Data bulanan
            'monthly_installment' => round($monthlyInstallment),
            'monthly_income' => round($monthlyIncome),
            'monthly_expense' => round($monthlyExpense),
            'remaining_money' => round($remainingMoney),
            'ratio_percentage' => round($ratio, 2),

            // Data harian (PENTING untuk UI)
            'daily_installment' => round($dailyInstallment),
            'daily_income' => round($dailyIncome),
            'daily_saving' => round($dailySaving),
            'total_days' => round($totalDays),

            'explanation' => [
                'Pendapatan bulanan sekitar Rp ' . number_format($monthlyIncome, 0, ',', '.'),
                'Cicilan per bulan Rp ' . number_format($monthlyInstallment, 0, ',', '.') . ' (' . round($ratio, 1) . '% dari pendapatan)',
                'Sisa uang setelah cicilan Rp ' . number_format($remainingMoney, 0, ',', '.'),
                'Anda perlu menyisihkan Rp ' . number_format($dailySaving, 0, ',', '.') . ' per hari selama ' . round($totalDays) . ' hari',
                'Batas aman cicilan maksimal ' . self::SAFE_DEBT_RATIO . '% dari pendapatan',
            ],

            'suggestions' => [],
        ];

        // 6. Saran hanya jika WARNING / NOT FEASIBLE
        if ($evaluation['status'] !== 'feasible') {
            $result['suggestions'] = $this->generateSuggestions(
                $monthlyIncome,
                $data['total_loan'],
                $totalMonths
            );
        }

        return $result;
    }

    /* =========================
        CONVERTERS
    ========================== */

    private function convertIncomeToMonthly(float $income, string $type): float
    {
        return match ($type) {
            'daily' => $income * self::DAYS_PER_MONTH,
            'weekly' => $income * self::WEEKS_PER_MONTH,
            'monthly' => $income,
            default => $income,
        };
    }

    private function convertTenorToMonths(int $value, string $unit): int
    {
        return $unit === 'year' ? $value * 12 : $value;
    }

    /* =========================
        CORE DECISION ENGINE (DIPERBAIKI)
    ========================== */

    private function evaluate(
        float $monthlyIncome,
        float $monthlyExpense,
        float $monthlyInstallment,
        float $remainingMoney
    ): array {
        $ratio = ($monthlyInstallment / $monthlyIncome) * 100;

        // HARD BLOCK #1: Sisa uang tidak cukup
        if ($remainingMoney <= 0) {
            return [
                'status' => 'not_feasible',
                'message' => 'Sisa uang tidak mencukupi kebutuhan hidup. Cicilan akan melebihi pendapatan bersih Anda.',
            ];
        }

        // HARD BLOCK #2: Sisa uang < buffer minimal (dana darurat)
        if ($remainingMoney < self::MINIMUM_BUFFER) {
            return [
                'status' => 'not_feasible',
                'message' => 'Sisa uang terlalu sedikit (< Rp ' . number_format(self::MINIMUM_BUFFER, 0, ',', '.') . '). Tidak ada ruang untuk kebutuhan tak terduga.',
            ];
        }

        // HARD BLOCK #3: Rasio melebihi 40%
        if ($ratio > self::MAXIMUM_DEBT_RATIO) {
            return [
                'status' => 'not_feasible',
                'message' => 'Rasio cicilan ' . round($ratio, 1) . '% terlalu tinggi (maksimal ' . self::MAXIMUM_DEBT_RATIO . '%). Beban hutang tidak aman.',
            ];
        }

        // WARNING: Rasio 30-40%
        if ($ratio >= self::SAFE_DEBT_RATIO) {
            return [
                'status' => 'warning',
                'message' => 'Rasio cicilan ' . round($ratio, 1) . '% cukup tinggi. Kondisi keuangan akan ketat dan berisiko jika ada pengeluaran mendadak.',
            ];
        }

        // FEASIBLE: Rasio < 30%
        return [
            'status' => 'feasible',
            'message' => 'Rencana cicilan dalam batas aman. Rasio cicilan ' . round($ratio, 1) . '% masih memberikan ruang finansial yang cukup.',
        ];
    }

    /* =========================
        SUGGESTIONS (DIPERBAIKI)
    ========================== */

    private function generateSuggestions(
        float $monthlyIncome,
        float $totalLoan,
        int $currentMonths
    ): array {
        $safeInstallment = $monthlyIncome * (self::SAFE_DEBT_RATIO / 100);
        $suggestions = [];

        // SARAN #1: Perpanjang tenor
        $minMonths = ceil($totalLoan / $safeInstallment);
        if ($minMonths > $currentMonths) {
            $additionalMonths = $minMonths - $currentMonths;
            $suggestions[] = [
                'type' => 'extend_tenor',
                'title' => 'Perpanjang Tenor Cicilan',
                'description' =>
                    'Perpanjang tenor menjadi minimal ' . $minMonths . ' bulan (+' . $additionalMonths . ' bulan) agar cicilan turun menjadi sekitar ' . self::SAFE_DEBT_RATIO . '% dari pendapatan.',
                'value' => $minMonths . ' bulan',
                'warning' => '⚠️ Perhatian: Tenor lebih panjang berarti total bunga yang dibayar akan lebih besar.',
            ];
        }

        // SARAN #2: Kurangi pinjaman
        $maxSafeLoan = $safeInstallment * $currentMonths;
        $reductionNeeded = $totalLoan - $maxSafeLoan;

        if ($reductionNeeded > 0) {
            $suggestions[] = [
                'type' => 'reduce_loan',
                'title' => 'Kurangi Jumlah Pinjaman',
                'description' =>
                    'Dengan tenor saat ini (' . $currentMonths . ' bulan), jumlah pinjaman aman maksimal adalah Rp ' .
                    number_format($maxSafeLoan, 0, ',', '.') . '. Anda perlu mengurangi Rp ' .
                    number_format($reductionNeeded, 0, ',', '.'),
                'value' => 'Rp ' . number_format($maxSafeLoan, 0, ',', '.'),
                'warning' => '💡 Pertimbangkan untuk mencari tambahan uang muka atau menunda pembelian.',
            ];
        }

        // SARAN #3: Tingkatkan pendapatan
        $requiredIncome = ($totalLoan / $currentMonths) / (self::SAFE_DEBT_RATIO / 100);
        $incomeGap = $requiredIncome - $monthlyIncome;

        if ($incomeGap > 0) {
            $suggestions[] = [
                'type' => 'increase_income',
                'title' => 'Tingkatkan Pendapatan',
                'description' =>
                    'Untuk tenor saat ini tetap aman, Anda memerlukan pendapatan bulanan minimal Rp ' .
                    number_format($requiredIncome, 0, ',', '.') . ' (tambahan Rp ' .
                    number_format($incomeGap, 0, ',', '.') . ' per bulan).',
                'value' => 'Rp ' . number_format($requiredIncome, 0, ',', '.') . '/bulan',
                'warning' => '💡 Pertimbangkan pekerjaan sampingan atau sumber penghasilan tambahan.',
            ];
        }

        return $suggestions;
    }
}
