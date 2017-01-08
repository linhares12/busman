<?php

namespace App\Http\Controllers\Modules\Financial;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use App\Models\Financial\Release;
use App\Models\Financial\Category;
use App\Models\Utility\uDate;
use App\User;
use App\Models\Register\Company;
use App\Models\Financial\Account;

class ReleaseController extends Controller
{
    public function index($type = null, $month = null, $year = null){
       
        if ($type == 'despesas') {
            $type = 'expense';
            $categories = Category::categoryList($type);
            $title = 'Despesas';
        }else{
            $type = 'receipt';
            $categories = Category::categoryList($type);
            $title = 'Receitas';
        }

        $accounts = Account::accountsList();

        $date = Release::dateBind($month, $year);

        $historic = Release::historic($date, $type);

        $releases = Release::monthReleases($date, $type);

        $PieData = Release::pieChartData($releases);

        return view('modules.financial.release.view')
                        ->with('categories', $categories)
                        ->with('date', $date['firstDay'])
                        ->with('releases', $releases)
                        ->with('historic', $historic)
                        ->with('accounts', $accounts)
                        ->with('PieData', $PieData)
                        ->with('title', $title)
                        ->with('type', $type);
    }

    public function update(Request $request){
        $v = Validator::make($request->all(), [
                'repeat' => 'required|repeatRelease',
                'description' => 'required|max:255',
                'category' => 'required',
                'account' => 'required',
                'payday' => 'required',
                'value' => 'required',
                'id' => 'required'
            ]);

        if ($v->fails()) {
            return back()->withErrors($v);
        }

        if(!isset($request->original_date)){
            return back()->withErrors(['Falha na obtenção da tada original']);
        }

        if($request->repeat == 'only'){
            Release::updateOnly($request->all());
        }elseif($request->repeat == 'future'){
            Release::updateFuture($request->all());
        }else{
            Release::updateAll($request->all());
        }

        return back();
    }

    public function destroy(Request $request){
        $v = Validator::make($request->all(), [
                'date' => 'required|date_format:"d/m/Y"',
                'repeat' => 'required|repeatRelease',
                'id' => 'required'
        ]);

        if($v->fails()){
            return back()->withErrors($v);
        }

        if(Release::checkDate($request->date)){
            return back()->withErrors(['Formato de data inválido']);
        }

        if($request->repeat == 'only'){
            Release::deleteOnly($request);
        }elseif($request->repeat == 'future'){
            Release::deleteFuture($request);
        }else{
            Release::deleteAll($request);
        }

        return back();
    }

    public function efective(Request $request){
        $v = Validator::make($request->all(), [
                'date' => 'required|date_format:"d/m/Y"',
                'original_date' => 'required|date_format:"d/m/Y"',
                'description' => 'required',
                'value' => 'required',
                'id' => 'required',
            ]);

        if ($v->fails()) {
            return back()->withErrors($v);
        }

        if (Release::checkDate($request->date)) {
            return back()->withErrors(['Formato de data inválido']);
        }

        Release::efective($request->all());

        return back();
    }

    public function store(Request $request){
        $v = Validator::make($request->all(), [
                    'payday' => 'required|date_format:"d/m/Y"',
                    'value' => 'required',
                    'category' => 'required',
                    'account' => 'required',
                    'description' => 'required|max:255',
                    'repeat' => 'required|releaseRecurrence',
                    'installment_qty' => 'numeric',
        ]);

        if ($v->fails()) {
            return back()->withErrors($v);
        }

        if (Release::checkDate($request->payday)) {
            return back()->withErrors(['Formato de data inválido']);
        }

        if ($request->repeat == 'installment' && $request->installment_qty < 2) {
            return back()->withErrors(['Em lançamentos parcelados, a quantidade de parcelas deve ser maior que 1']);
        }

        $create = Release::createRelease($request->all());

        if($create == false){
            back()->withErrors(['Erro ao realizar lançamento.']);
        }

        return back();
    }
}
