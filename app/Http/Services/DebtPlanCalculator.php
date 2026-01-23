<?php

namespace App\Http\Services;

class DebtPlanCalculator {

    public function calculate(array $data)
    {
        $totalDays = $this->convertTenorToDays(
            $data['tenor_value'],
            $data['tenor_unit']
        );

        $dailyInstallment = $data['total_loan'] / $totalDays;

        $dailyIncome = $this->convertIncomeToDailyRate(
            $data['income_value'],
            $data['income_type']
        );

        $ratio = ($dailyInstallment / $dailyIncome) * 100;

        $evaluation = $this->evaluate(
            $dailyInstallment,
            $dailyIncome,
            $ratio,
            $totalDays
        );

        // DEFAULT
        $result = [
            'daily_saving' => round($dailyInstallment),
            'daily_income' => round($dailyIncome),
            'ratio_percentage' => round($ratio, 2),
            'total_days' => $totalDays,
            'is_feasible' => $evaluation['is_feasible'],
            'message' => $evaluation['message'],
            'explanation' => [
                'Pendapatan harian sekitar Rp ' . number_format($dailyIncome, 0, ',', '.'),
                'Cicilan per hari Rp ' . number_format($dailyInstallment, 0, ',', '.'),
                'Batas aman maksimal 35% dari pendapatan',
            ],
            'suggestions' => [],
        ];

        if (!$evaluation['is_feasible']) {
            $result['risk_level'] = $ratio > 100 ? 'critical' : 'high';
            $result['status_label'] = 'Tidak Layak';

            $result['suggestions'] = $this->generateSuggestions(
                $dailyIncome,
                $data['total_loan'],
                $totalDays
            );

            return $result;
        }

        $result['risk_level'] = 'safe';
        $result['status_label'] = 'Layak';

        return $result;
    }


    private function convertTenorToDays($value, $unit) {
        if ($unit === 'year') {
            return $value * 365;
        }elseif ($unit === 'month') {
            return $value * 30.44;
        }
        return $value;
    }

    private function convertIncomeToDailyRate($income, $type) {
        switch ($type) {
            case 'daily':
                return $income;
            case 'weekly':
                return $income / 7;
            case 'yearly':
                return $income / 30.44;
            default:
                return $income;
        }
    }

    private function evaluate($installment, $income, $ratio, $days)
    {
        if ($ratio > 100) {
            return [
                'is_feasible' => false,
                'daily_saving' => round($installment),
                'ratio_percentage' => round($ratio, 2),
                'total_days' => $days,
                'message' => 'Cicilan lebih besar dari pendapatan',
            ];
        }

        if ($ratio > 35) {
            return [
                'is_feasible' => false,
                'daily_saving' => round($installment),
                'ratio_percentage' => round($ratio, 2),
                'total_days' => $days,
                'message' => 'Cicilan melebihi batas aman 35%',
            ];
        }

        return [
            'is_feasible' => true,
            'daily_saving' => round($installment),
            'ratio_percentage' => round($ratio, 2),
            'total_days' => $days,
            'message' => 'Aman',
        ];
    }

    private function generateSuggestions($daily_income, $total_loan, $current_days) {
        $suggestions = [];
        $safe_daily_installment = $daily_income * 0.35;

        // Saran 1: Perpanjang tenor
        $min_days_needed = ceil($total_loan / $safe_daily_installment);
        $min_months_needed = ceil($min_days_needed / 30);
        $min_years_needed = ceil($min_days_needed / 365);

        $suggestions[] = [
            'type' => 'extend_tenor',
            'title' => 'Perpanjang Tenor',
            'description' => 'Perpanjang tenor menjadi minimal ' . $min_months_needed . ' bulan (' .
                        round($min_years_needed, 1) . ' tahun) agar cicilan hanya 35% dari pendapatan.',
            'value' => $min_months_needed . ' bulan'
        ];

                // Saran 2: Kurangi pinjaman
        $max_safe_loan = $safe_daily_installment * $current_days;
        $suggestions[] = [
            'type' => 'reduce_loan',
            'title' => 'Kurangi Jumlah Pinjaman',
            'description' => 'Dengan tenor yang sama, maksimal pinjaman aman adalah Rp ' .
                        number_format($max_safe_loan, 0, ',', '.'),
            'value' => 'Rp ' . number_format($max_safe_loan, 0, ',', '.')
        ];

        // Saran 3: Tingkatkan pendapatan
        $min_income_needed = ($total_loan / $current_days) / 0.35;
        $monthly_income_needed = $min_income_needed * 30;
        $suggestions[] = [
            'type' => 'increase_income',
            'title' => 'Tingkatkan Pendapatan',
            'description' => 'Usahakan pendapatan minimal Rp ' .
                        number_format($monthly_income_needed, 0, ',', '.') . ' per bulan.',
            'value' => 'Rp ' . number_format($monthly_income_needed, 0, ',', '.') . '/bulan'
        ];

        return $suggestions;
    }



}
