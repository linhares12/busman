<?php

namespace App\Http\Controllers\Modules\Financial;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Financial\Release;
class BalanceController extends Controller
{
    public function index($month = null, $year = null){
        $date = Release::dateBind($month, $year); // Prepare target date

        $historicReceipt = Release::historic($date, 'receipt');
        $historicExpense = Release::historic($date, 'expense');

        $profit = [];
        for ($i=0; $i < count($historicReceipt); $i++) {
            $profit[$i] = ['month' => $historicReceipt[$i]['month'], 'value' => $historicReceipt[$i]['value'] - $historicExpense[$i]['value']];
        }


        $monthExpense = Release::monthReleases($date, 'expense');

        $expenses = [];

        foreach ($monthExpense as $key => $value) {

            $value = $value->getOriginal();
            $day = (int)date('d', strtotime($value['payday']));

            if (isset($expenses[$day])) {
                $expenses[$day] = $expenses[$day] + $value['value'];
            }else{
                $expenses[$day] = $value['value'];
            }

        }

        $monthReceipts = Release::monthReleases($date, 'receipt');

        $receipts = [];

        foreach ($monthReceipts as $key => $value) {

            $value = $value->getOriginal();
            $day = (int)date('d', strtotime($value['payday']));
            if (isset($receipts[$day])) {
                $receipts[$day] = $receipts[$day] + $value['value'];
            }else{
                $receipts[$day] = $value['value'];
            }
        }

        return view('modules.financial.balance.balance')
                ->with('historicReceipt', $historicReceipt)
                ->with('historicExpense', $historicExpense)
                ->with('monthReceipts', $receipts)
                ->with('monthExpense', $expenses)
                ->with('profit', $profit)
                ->with('title', 'Balanço')
                ->with('date', $date);
    }
}
