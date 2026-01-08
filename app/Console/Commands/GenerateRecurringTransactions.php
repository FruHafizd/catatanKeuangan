<?php

namespace App\Console\Commands;

use App\Models\RecurringTransaction;
use App\Models\Transaction;
use Carbon\Carbon;
use DB;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GenerateRecurringTransactions extends Command
{
    protected $signature = 'recurring:generate';
    protected $description = 'Generate transactions from recurring rules';

    public function handle()
    {
        Log::info('Recurring command START', [
            'time' => now()->toDateTimeString(),
        ]);

        $today = Carbon::today();

        $recurrings = RecurringTransaction::query()
            ->where('is_active', true)
            ->whereDate('start_date', '<=', $today)
            ->where(function ($q) use ($today) {
                $q->whereNull('end_date')
                  ->orWhereDate('end_date', '>=', $today);    
            })
            ->get();

        foreach ($recurrings as $recurring) {
            // ✅ Cek apakah sudah generate hari ini
            if ($recurring->last_generated_at && $recurring->last_generated_at->isSameDay($today)) {
                Log::info('Skipping - already generated today', [
                    'recurring_id' => $recurring->id,
                    'last_generated' => $recurring->last_generated_at->toDateString(),
                ]);
                continue;
            }

            if (!$this->shouldGenerate($recurring, $today)) {
                continue;
            }

            DB::transaction(function () use ($recurring, $today) {
                // Double check untuk keamanan
                $exists = Transaction::where('recurring_transaction_id', $recurring->id)
                    ->whereDate('date', $today)
                    ->exists();

                if ($exists) {
                    Log::info('Transaction already exists', [
                        'recurring_id' => $recurring->id,
                    ]);
                    return;
                }

                Transaction::create([
                    'user_id' => $recurring->user_id,
                    'name' => $recurring->name,
                    'type' => $recurring->type,
                    'amount' => $recurring->amount,
                    'date' => $today,
                    'recurring_transaction_id' => $recurring->id,
                ]);

                $recurring->update([
                    'last_generated_at' => $today,
                ]);

                Log::info('Recurring transaction generated', [
                    'recurring_id' => $recurring->id,
                    'date' => $today->toDateString(),
                ]);
            });
        }

        return self::SUCCESS;
    }

    private function shouldGenerate($recurring, Carbon $today) 
    {
        return match ($recurring->frequency) {
            'daily'   => true,
            'weekly'  => $recurring->start_date->dayOfWeek === $today->dayOfWeek,
            'monthly' => $recurring->start_date->day === $today->day,
            'yearly'  => $recurring->start_date->day === $today->day
                        && $recurring->start_date->month === $today->month,
            default => false,
        };
    }
}