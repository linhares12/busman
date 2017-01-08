<?php

namespace App\Http\Controllers\Modules\Financial;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Financial\Release;
use App\Models\Financial\Account;
use App\Models\Financial\Category;
use App\Models\Register\Company;
use App\User;
use Validator;

class AccountController extends Controller
{
    public function index($month = null, $year = null){
    	$date = Release::dateBind($month, $year);

        $accounts = Account::userAccounts();

        $accArray = [];
        foreach ($accounts as $acc){
            $accArray[$acc->id] = $acc->name;
        }

        $accSelect = [];
    	$monthExpense = Release::monthReleases($date, 'expense');
    	$monthReceipts = Release::monthReleases($date, 'receipt');
    	$totalBalabce = 0;
    	$totalProjection = 0;

    	for ($i=0; $i < count($accounts); $i++){
    		$sumExp = [];
    		$sumRec = [];
    		foreach ($monthExpense as $expense) {
    			if ($expense->account == $accounts[$i]['id'] && $expense->status != 'payd') {
    				$sumExp[] = $expense->value;
    			}
    		}
    		foreach ($monthReceipts as $receipt) {
    			if ($receipt->account == $accounts[$i]['id'] && $receipt->status != 'payd') {
    				$sumRec[] = $receipt->value;
    			}
    		}

    		$accounts[$i]['projection'] = $accounts[$i]['amount'] + array_sum($sumRec) - array_sum($sumExp);
    		$totalBalabce = $totalBalabce + $accounts[$i]['amount'];
    		$totalProjection = $totalProjection + $accounts[$i]['projection'];

            $accSelect[$accounts[$i]['id']] = $accounts[$i]['name'];
    	}

    	return view('modules.financial.account.overview')
    			->with('title', 'Contas')
                        ->with('totalProjection', $totalProjection)
    			->with('totalBalabce', $totalBalabce)
    			->with('accSelect', $accSelect)
                        ->with('accArray', $accArray)
    			->with('accounts', $accounts);
    }

    public function store(Request $request){
        $v = Validator::make($request->all(), [
    			'name' => 'required'
    		]);

    	if ($v->fails()) {
    		return back()->withErrors($v);
    	}
        $opening_balance = str_replace(',', '.', str_replace('.', '', $request->opening_balance));
        if ($opening_balance == ""){
            $opening_balance = "0";
        }

    	Account::create([
                            'name' => $request->name,
                            'company' => auth()->user()->company,
                            'amount' => $opening_balance
                        ]);

    	return back();
    }

    public function destroy(Request $request){
        $v = Validator::make($request->all(), [
                'id' => 'required',
            ]);

        if ($v->fails()) {
            return back()->withErrors($v);
        }
        $account = Account::findOrFail($request->id);
        $uCompany = auth()->user()->company;
        $aCompany = $account->company();
        if($uCompany != $aCompany->id){
            return back()->withErrors(['Acesso negado.']);
        }

        Release::where('account', '=', $request->id)->delete();

        $account->delete();

        return back();
    }

    public function update(Request $request){
         $v = Validator::make($request->all(), [
                'id' => 'required',
                'name' => 'required',
            ]);

        if ($v->fails()) {
            return back()->withErrors($v);
        }
        
        $account = Account::findOrFail($request->id);
        $uCompany = auth()->user()->company;
        $aCompany = $account->company();
        
        if($uCompany != $aCompany->id){
            return back()->withErrors(['Acesso negado.']);
        }
        
        $account->update(['name' => $request->name]);

        return back();
    }

    public function transfer(Request $request){
        $v = Validator::make($request->all(), [
                'outgoing_account' => 'required',
                'incoming_account' => 'required',
                'value' => 'required',
            ]);

        if ($v->fails()) {
            return back()->withErrors($v);
        }

        $account = Account::findOrFail($request->outgoing_account);
        $uCompany = auth()->user()->company;
        $aCompany = $account->company();
        if($uCompany != $aCompany->id){
            return back()->withErrors(['Acesso negado.']);
        }

        $description = 'TRF_from'. Account::findOrFail($request->outgoing_account)->name.'_to_'. Account::findOrFail($request->incoming_account)->name;

        $value = str_replace(',', '.', str_replace('.', '', $request->value));

        $ref = 'acount_transfer_'.Release::refGenerator();

        Release::create([
                'description' => $description,
                'type' => 'transfer_out',
                'reference' => $ref,
                'recurrence' => '1:1',
                'status' => 'payd',
                'category' => 1,
                'payday' => date('Y-m-d'),
                'value' => $value,
                'account' => $request->outgoing_account
            ]);

        Release::create([
                'description' => $description,
                'type' => 'transfer_in',
                'reference' => $ref,
                'recurrence' => '1:1',
                'status' => 'payd',
                'category' => 2,
                'payday' => date('Y-m-d'),
                'value' => $value,
                'account' => $request->incoming_account
            ]);

        return back();
    }
}
