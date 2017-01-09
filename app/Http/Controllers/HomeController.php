<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Financial\Release;
use App\Models\Financial\Category;
use App\Models\Financial\Account;
use App\Models\Register\Company;
use App\Models\Utility\uDate;

class HomeController extends Controller
{



    public function index()
    {
    	$date = Release::dateBind(date('m'), date('Y'));

    	$lateReleases = Release::lateReleases();
    	$todayReleases = Release::todayReleases();

    	$receipt = Release::monthReleases($date, 'receipt');
    	$recPayd = 0;
    	$recTotal = 0;
    	$recPorcentage = 100;
    	foreach ($receipt as $rec) {
    		if ($rec->status == 'payd') {
    			$recPayd = $recPayd + $rec->value;
    		}

    		$recTotal = $recTotal + $rec->value;
    	}
    	if ($recTotal != 0) {
    		$recPorcentage = ($recPayd * 100) / $recTotal;
    	}

    	$expense = Release::monthReleases($date, 'expense');
    	$expPayd = 0;
    	$expTotal = 0;
    	$expPorcentage = 100;
    	foreach ($expense as $exp) {
    		if ($exp->status == 'payd') {
    			$expPayd = $expPayd + $exp->value;
    		}

    		$expTotal = $expTotal + $exp->value;
    	}
    	if ($expTotal != 0) {
    		$expPorcentage = ($expPayd * 100) / $expTotal;
    	}
    	

    	$accounts = auth()->user()->company()->accounts();

    	$amount = 0;
    	foreach ($accounts as $acc) {
    		$amount = $amount + $acc->amount;
    	}

    	

    	$projection = $amount + ($recTotal - $recPayd) - ($expTotal - $expPayd);

    	$amPercentage = 100;
    	if ($projection > 0) {
    		$amPercentage = ($amount * 100) / $projection;
    	}

        return view('dashboard')->with('title', 'Home')
        						->with('lateReleases', $lateReleases)
        						->with('todayReleases', $todayReleases)
        						->with('expPayd', $expPayd)
        						->with('recPayd', $recPayd)
        						->with('expPorcentage', $expPorcentage)
        						->with('recPorcentage', $recPorcentage)
        						->with('amount', $amount)
        						->with('amPercentage', $amPercentage)
        						->with('projection', $projection)
        						->with('menu', '');
    }
}
