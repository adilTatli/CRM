<?php

namespace App\Traits\Billing;

use App\Models\Part;
use App\Models\ReceivedPayment;
use App\Models\TaskBilling;
use Illuminate\Support\Facades\DB;

trait BillingTrait
{
    public function recalculateTaskBilling(int $taskId)
    {
        $billing = TaskBilling::firstOrNew(['task_id' => $taskId]);

        $newPartsRetails = Part::where('task_id', $taskId)->sum(DB::raw('retail_price * qnt'));
        $newPartsCost = Part::where('task_id', $taskId)->sum(DB::raw('dealer_price * qnt'));

        // Получить текущие значения
        $laborCost = $billing->labor_cost ?? 0;
        $otherCost = $billing->other_cost ?? 0;
        $taxRate = $billing->tax_rate ?? 0;

        // Рассчитать налоги
        $taxAmount = ($newPartsRetails * $taxRate / 100);

        // Рассчитать общую стоимость
        $totalCost = $laborCost + $newPartsRetails + $taxAmount + $otherCost;
        $billing->total_cost = $totalCost;

        // Рассчитать непогашенную сумму
        $totalPayments = ReceivedPayment::where('task_id', $taskId)->sum('payment');
        $billing->unpaid_amount = $totalCost - $totalPayments;

        $billing->parts_retails = $newPartsRetails;
        $billing->parts_cost = $newPartsCost;
        $billing->save();
    }
}
