<?php

namespace App\Console\Commands;

use App\Models\RecurringTransaction;
use App\Models\Transaction;
use Carbon\Carbon;
use DB;
use Illuminate\Console\Command;

class GenerateRecurringTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recurring:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate transactions from reccuring rules';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();

        $recurrings = RecurringTransaction::query()->where('is_active', true)->whereDate('start_date', '<=', $today)->where(function ($q) use ($today)
        {
            $q->whereNull('end_date')->orWhereDate('end_date', '>=', $today);    
        })->get();

        foreach ($recurrings as $recurring) {
            if (!$this->shouldGenerate($recurring, $today)) {
                continue;
            }

            DB::transaction(function () use ($recurring, $today) {

                $exists = Transaction::where('recurring_transaction_id', $recurring->id)->whereDate('date', $today)->exists();

                if ($exists) {
                    return;
                }

                $recurring->update([
                    'last_generated_at' => $today,
                ]);

                Transaction::create([
                    'user_id' => $recurring->user_id,
                    'name' => $recurring->name,
                    'type' => $recurring->type,
                    'amount' => $recurring->amount,
                    'date' => $today,
                    'recurring_transaction_id' => $recurring->id,
                ]);
            });
        }

        return self::SUCCESS;
    }


    private function shouldGenerate($recurring, Carbon $today) {
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
