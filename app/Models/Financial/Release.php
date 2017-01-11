<?php

namespace App\Models\Financial;

use Illuminate\Database\Eloquent\Model;
use App\Models\Register\Company;
use App\Models\Utility\uDate;
class Release extends Model
{
    protected $fillable = [
        'description', 'type', 'reference', 'recurrence', 'category', 'service', 'status', 'payday', 'value', 'account'
    ];

    protected $hidden = [
        // nada
    ];

    public function category(){
        return $this->belongsTo('App\Models\Financial\Category', 'category')->get()->first();
    }

    public static function fakeParcelDate($actualMonth, $actualYear, $originalDate){
        $date = \DateTime::createFromFormat('Y-m-d H:i:s', $originalDate.' 00:00:00');

        $testDate = $actualYear.'-'.$actualMonth.'-01';

        $lastday = date('t',strtotime($testDate));

        if($date->format('d') > $lastday){
            $newDate = $actualYear.'-'.$actualMonth.'-'.$lastday;
        }else{
            $newDate = $actualYear.'-'.$actualMonth.'-'.$date->format('d');
        }

        return $newDate;
    }

    public static function lateReleases()
    {
        $accounts = auth()->user()->company()->accounts();
        $late = collect();

        $listLate = [];
        
        foreach ($accounts as $acc) {
            $late = collect(Release::where([['payday', '<', date('Y-m-d')], ['status', '=', 'pending'], ['account', '=', $acc->id]])->get());
        }
        
        if ($late->count() > 0) {
            foreach ($late as $l) {
                
                if ($l->recurrence == '0:inf') {
                    $date1 = new \DateTime(date('Y-m-d'));
                    $date2 = new \DateTime($l->payday);
                    $diff = ($date1->format('Y') - $date2->format('Y'))*12 + ($date1->format('m') - $date2->format('m'));
                    
                    $diff = $diff + 1;
                    
                    for ($i=1; $i <= $diff; $i++) { 
                        $test = Release::where([['reference', '=', $l->reference], ['recurrence', '=', $i  . ':inf']])->get();
                        if ($test->first() == null) {
                            $payday = uDate::addMonthToDate($i-1, $l->payday);

                            $link = '/admin/lancamentos/'.trans('database.'.$l->type).'/'.date('m/Y', strtotime($payday));

                            $listLate[] = ['description' => $l->description, 'payday' => $payday, 'type' => $l->type, 'link' => $link]; 
                        }
                    }

                    
                }else{
                    $link = '/admin/lancamentos/'.trans('database.'.$l->type).'/'.date('m/Y', strtotime($l->payday));
                    $listLate[] = ['description' => $l->description, 'payday' => $l->payday, 'type' => $l->type, 'link' => $link];

                }
            }
        }
        return $listLate;
    }

    public static function todayReleases()
    {
        $today = [];
        $date = self::dateBind(date('m'), date('Y'));
        $receipt = Release::monthReleases($date, 'receipt');
        $expense = Release::monthReleases($date, 'expense');

        foreach ($receipt as $rec) {
            $fakeDate = explode('/', $rec->payday);
            if ($fakeDate[2].'-'.$fakeDate[1].'-'.$fakeDate[0] == date('Y-m-d') && $rec->status != 'payd') {
                $link = '/admin/lancamentos/'.trans('database.'.$rec->type).'/'.date('m/Y', strtotime($rec->payday));
                $today[] = ['description' => $rec->description, 'payday' => $rec->payday, 'type' => $rec->type, 'link' => $link];
            }
        }
        foreach ($expense as $exp) {
            $fakeDate = explode('/', $exp->payday);
            if ($fakeDate[2].'-'.$fakeDate[1].'-'.$fakeDate[0] == date('Y-m-d') && $exp->status != 'payd') {
                $link = '/admin/lancamentos/'.trans('database.'.$exp->type).'/'.date('m/Y', strtotime($exp->payday));
                $today[] = ['description' => $exp->description, 'payday' => $exp->payday, 'type' => $exp->type, 'link' => $link];
            }
        }
        return $today;
    }


    public static function historic($date, $type){
        $historic = []; // Prepare bar chart seed
        $accounts = auth()->user()->company()->accounts();

        for ($i=11; $i >= 0 ; $i--) { // Prepare bar chart data
            $start = uDate::addMonthToDate(-$i, $date['firstDay']->format('Y-m-d'));

            $end = date('Y-m-t',strtotime($start));

            $exclude = [];

            $sum = 0;

            foreach ($accounts as $acc) {

                $select = Release::where([['payday', '>=', $start], ['payday', '<=', $end], ['type', '=', $type], ['account', '=', $acc->id], ['recurrence', '!=', '0:inf']])->select('reference')->get();

                foreach ($select->toArray() as $f) {
                    $exclude[] = ['reference', '!=', $f['reference']];
                }
                
                $fix = Release::where([['recurrence', '=', '0:inf'], ['payday', '<=', $end], ['type', '=', $type], ['account', '=', $acc->id]])->where($exclude)->sum('value');
                
                $sum += Release::where([['payday', '>=', $start], ['payday', '<=', $end], ['type', '=', $type], ['recurrence', '!=', '0:inf'], ['account', '=', $acc->id]])->sum('value') + $fix;

            }
            $historic[] = ['month' => date('M', strtotime($start)), 'value' => $sum];
            
        }

        return $historic;
    }

    public static function refGenerator(){
        do{
            $ref = auth()->user()->id.'_'.md5(uniqid(rand(), true));
            $check = Release::where('reference', '=', $ref)->get();
        }while(!$check);

        return $ref;
    }

    public static function dateBind($month, $year){
        if (is_numeric($month)) {
            if ($month < 1 || $month > 12) {
                $month = date('m');
            }
        }else{
            $month = date('m');
        }

        if (is_numeric($year)) {
            if(strlen($year) != 4){
                $year = date('Y');
            }
        }else{
            $year = date('Y');
        }

        $firstDay = new \DateTime(date($year.'-'.$month.'-01'));
        $lastDay = new \DateTime(date('Y-m-t',strtotime($firstDay->format('Y-m-d'))));

        $collection = ['firstDay' => $firstDay, 'lastDay' => $lastDay, 'month' => $month, 'year' => $year];

        return $collection;
    }

    public static function checkDate($date){
        $checkdate = explode('/', $date);

        if (strlen($checkdate[0]) != 2 || strlen($checkdate[1]) != 2 || strlen($checkdate[2]) != 4) {
            return true;
        }

        return false;
    }

    public static function createRelease(Array $data){
        if (isset($data['status']) && $data['status'] == 'on') {
            $data['status'] = 'payd';
        } else {
            $data['status'] = 'pending';
        }

        $data['payday'] = \DateTime::createFromFormat('d/m/Y H:i:s', $data['payday']. ' 00:00:00');

        $data['value'] = str_replace(',', '.', str_replace('.', '', $data['value']));

        $data['type'] = Category::findOrFail($data['category'])->type;

        $data['reference'] = Release::refGenerator();

        if ($data['repeat'] == 'unique') {

            $data['payday'] = $data['payday']->format('Y-m-d H:i:s');

            $data['recurrence'] = '1:1';

            $data['description'] = trim($data['description']);

            Release::create($data);

            return true;

        } elseif ($data['repeat'] == 'installment') {

            $data['value'] = $data['value'] / $data['installment_qty'];

            $startDate = $data['payday']->format('Y-m-d');

            for ($i = 1; $i <= $data['installment_qty']; $i++) {

                $data['recurrence'] = $i . ':' . $data['installment_qty'];

                $data['payday'] = uDate::addMonthToDate(($i - 1), $startDate);

                $data['description'] = trim($data['description']);

                Release::create($data);

                $data['status'] = 'pending';
            }

            return true;

        } else {

            $data['recurrence'] = '0:inf';

            $data['payday'] = $data['payday']->format('Y-m-d H:i:s');

            $data['description'] = trim($data['description']);
            
            $temp = $data;

            $temp['status'] = 'pending';

            Release::create($temp);

            if ($data['status'] == 'payd') {

                $data['recurrence'] = '1:inf';

                Release::create($data);
            }

            return true;
        }

        return false;
    }

    public static function monthReleases($dateBind, $type){
        $newReleases = [];

        $accounts = auth()->user()->company()->accounts();

        $releases = collect();

        foreach($accounts as $acc){

            $result = Release::where([
                        ['payday', '>=', $dateBind['firstDay']->format('Y-m-d')],
                        ['payday', '<=', $dateBind['lastDay']->format('Y-m-d')],
                        ['type', '=', $type],
                        ['account', '=', $acc->id]
                    ])->orWhere([
                        ['recurrence', '=', '0:inf'],
                        ['payday', '<=', $dateBind['lastDay']->format('Y-m-d')],
                        ['type', '=', $type],
                        ['account', '=', $acc->id]
                    ])->get();

            $releases = $releases->merge($result);
        }

        if ($releases) {

            for ($i = 0; $i < count($releases); $i++) {
                $releases[$i]->categoryName = $releases[$i]->category()->name;
                $releases[$i]->categoryColor = $releases[$i]->category()->color;
                $releases[$i]->accountName = Account::findOrFail($releases[$i]->account)->name;

                if ($releases[$i]->recurrence == '0:inf') {
                    $seedPayday = new \DateTime($releases[$i]->payday);
                    $diff = ($dateBind['year'] - $seedPayday->format('Y')) * 12 + ($dateBind['month'] - $seedPayday->format('m'));

                    $fakeRecurrence = ($diff + 1) . ':inf';

                    $test = Release::where([['recurrence', '=', $fakeRecurrence], ['recurrence', '!=', '0:inf'], ['reference', '=', $releases[$i]->reference], ['type', '=', $type]])->get();

                    if ($test->count() == 0) { // Gera parcela fixa virtual (Não existe no banco)

                        $releases[$i]->repeatNumber = ':inf';
                        $releases[$i]->recurrence = str_replace(':inf', ' / <i class="ion-ios-infinite"></i>', $fakeRecurrence);
                        $releases[$i]->payday = date('d/m/Y', strtotime(Release::fakeParcelDate($dateBind['month'], $dateBind['year'], $releases[$i]->payday)));

                        $newReleases[$i] = $releases[$i];
                    }

                }elseif(strpos($releases[$i]->recurrence, ':inf')){ // Forma parcela fixa existente no banco

                    $releases[$i]->repeatNumber = ':inf';
                    $releases[$i]->payday = date('d/m/Y', strtotime($releases[$i]->payday));
                    $releases[$i]->recurrence = str_replace(':inf', ' / <i class="ion-ios-infinite"></i>', $releases[$i]->recurrence);

                    $newReleases[$i] = $releases[$i];
                }else{

                    $releases[$i]->repeatNumber = Release::where('reference', '=', $releases[$i]->reference)->count();
                    $releases[$i]->recurrence = str_replace(':', ' / ', $releases[$i]->recurrence);
                    $releases[$i]->payday = date('d/m/Y', strtotime($releases[$i]->payday));

                    $newReleases[$i] = $releases[$i];
                }
            }
        }

        return $newReleases;
    }

    public static function updateAll(Array $data){
        $release = Release::findOrFail($data['id']);
        $uCompany = auth()->user()->company;
        $rCompany = Account::findOrFail($release->account)->company();
        if($uCompany != $rCompany->id){
            return back()->withErrors(['Acesso negado.']);
        }
        $data['description'] = trim($data['description']);
        $data['payday'] = \DateTime::createFromFormat('d/m/Y H:i:s', $data['payday'] . ' 00:00:00');
        $data['original_date'] = \DateTime::createFromFormat('d/m/Y H:i:s', $data['original_date'] . ' 00:00:00');

        $data['value'] = str_replace(',', '.', str_replace('.', '', $data['value']));

        if (isset($data['status']) && $data['status'] == 'on') {
            $data['status'] = 'payd';
        } else {
            $data['status'] = 'pending';
        }

        

        unset($data['status']);

        $newDay = date('d', strtotime($data['payday']->format('Y-m-d H:i:s')));

        $all = Release::where('reference', '=', $release->reference)->get();

        foreach ($all as $a) {
            
            $store = $data;

            $lastday = date('t', strtotime($a->payday));

            $registerDay = $newDay;
            if ($registerDay > $lastday) {
                $registerDay = $lastday;
            }

            $store['payday'] = date('Y-m-', strtotime($a->payday)) . $registerDay . ' 00:00:00';

            $a->update($store);

        }
    }

    public static function updateOnly(Array $data){
        $release = Release::findOrFail($data['id']);
        
        $uCompany = auth()->user()->company;
        $rCompany = Account::findOrFail($release->account)->company();
        if($uCompany != $rCompany->id){
            return back()->withErrors(['Acesso negado.']);
        }
        $data['description'] = trim($data['description']);
        $data['payday'] = \DateTime::createFromFormat('d/m/Y H:i:s', $data['payday'] . ' 00:00:00');
        $data['original_date'] = \DateTime::createFromFormat('d/m/Y H:i:s', $data['original_date'] . ' 00:00:00');

        $data['value'] = str_replace(',', '.', str_replace('.', '', $data['value']));

        if (isset($data['status']) && $data['status'] == 'on') {
            $data['status'] = 'payd';
        } else {
            $data['status'] = 'pending';
        }

        if ($release->recurrence == '0:inf') {

                $date1 = new \DateTime($data['original_date']->format('Y-m-d'));
                $date2 = new \DateTime($release->payday);
                $diff = ($date1->format('Y') - $date2->format('Y'))*12 + ($date1->format('m') - $date2->format('m'));
                $fakeRecurrence = ($diff + 1) . ':inf';

                unset($data['id']);
                $data['recurrence'] = $fakeRecurrence ;
                $data['reference'] = $release->reference;
                $data['type'] = $release->type;
                $data['payday'] = $data['payday']->format('Y-m-d');

                Release::create($data);

                return back()->with('success', 'Lançamento editado com sucesso.');
            }

            $data['payday'] = $data['payday']->format('Y-m-d H:i:s');
            $release->update($data);
    }

    public static function updateFuture(Array $data){
        $release = Release::findOrFail($data['id']);
        $uCompany = auth()->user()->company;
        $rCompany = Account::findOrFail($release->account)->company();
        if($uCompany != $rCompany->id){
            return back()->withErrors(['Acesso negado.']);
        }
        $data['description'] = trim($data['description']);
        $data['payday'] = \DateTime::createFromFormat('d/m/Y H:i:s', $data['payday'] . ' 00:00:00');
        $data['original_date'] = \DateTime::createFromFormat('d/m/Y H:i:s', $data['original_date'] . ' 00:00:00');

        $data['value'] = str_replace(',', '.', str_replace('.', '', $data['value']));

        if (isset($data['status']) && $data['status'] == 'on') {
            $data['status'] = 'payd';
        } else {
            $data['status'] = 'pending';
        }

        $newDay = date('d', strtotime($data['payday']->format('Y-m-d H:i:s')));

            if ($release->recurrence == '0:inf') {

                unset($data['status']);

                $date1 = new \DateTime($data['original_date']->format('Y-m-t'));
                $date2 = new \DateTime($release->payday);
                $diff = ($date1->format('Y') - $date2->format('Y'))*12 + ($date1->format('m') - $date2->format('m'));
                $fakeRecurrence = ($diff + 1) . ':inf';

                // Gravando os lançamentos anteriores fisicamente no banco
                for ($i=1; $i <= $diff; $i++) {
                    $prev = Release::where([['reference','=', $release->reference], ['recurrence', '=', $i.':inf']])->get();

                    if ($prev->count() == 0) {
                        $burn = $release->toArray();
                        unset($burn['id']);
                        $burn['recurrence'] = $i.':inf';
                        $burn['payday'] = uDate::addMonthToDate(($i-1), date('Y-m-d', strtotime($release->payday)));

                        Release::create($burn);
                    }
                }

                // Procura lançamentos futuros que já estão no banco fisicamente
                $future = Release::where('reference', '=', $release->reference)->where('payday', '>=', $data['original_date']->format('Y-m-d'))->get();

                // Atualiza lançamentos futuros já existentes
                foreach ($future as $fut) {

                    $store = $data;

                    $lastday = date('t', strtotime($fut->payday));

                    $registerDay = $newDay;

                    if($registerDay > $lastday){

                        $registerDay = $lastday;
                    }

                    $store['payday'] = date('Y-m-', strtotime($fut->payday)) . $registerDay . ' 00:00:00';

                    $fut->update($store);

                }

                // Por fim, atualiza a semente
                $lastday = date('t', strtotime($release->payday));
                if($newDay > $lastday){
                    $newDay = $lastday;
                }
                $data['payday'] = date('Y-m-', strtotime($release->payday)) . $newDay . ' 00:00:00';
                $release->update($data);

            }elseif(strpos($release->recurrence, ':inf') && $release->recurrence != '0:inf'){

                $rec = str_replace(':inf', '', $release->recurrence);

                $seed = Release::where([['reference','=', $release->reference], ['recurrence', '=', '0:inf']])->get();

                // Gravando os lançamentos anteriores fisicamente no banco
                for ($i=1; $i < $rec; $i++) {
                    $prev = Release::where([['reference','=', $release->reference], ['recurrence', '=', $i.':inf']])->get();

                    if ($prev->count() == 0) {

                        $burn = $seed->toArray();

                        unset($burn['id']);

                        $burn['recurrence'] = $i.':inf';

                        $burn['payday'] = uDate::addMonthToDate(($i-1), date('Y-m-d', strtotime($seed->payday)));

                        Release::create($burn);

                    }
                }

                // Procura lançamentos futuros que já estão no banco fisicamente
                $future = Release::where('reference', '=', $release->reference)->where('payday', '>=', $data['original_date']->format('Y-m-d'))->get();

                // Atualiza lançamentos futuros já existentes
                foreach ($future as $fut) {

                    $store = $data;

                    $lastday = date('t', strtotime($fut->payday));
                    $registerDay = $newDay;
                    if ($registerDay > $lastday) {

                        $registerDay = $lastday;
                    }

                    $store['payday'] = date('Y-m-', strtotime($fut->payday)) . $registerDay . ' 00:00:00';

                    $fut->update($store);
                }

                $data['payday'] = date('Y-m-', strtotime($release->payday)) . $newDay . ' 00:00:00';
                $release->update($data);

            }else{
                $future = Release::where('reference', '=', $release->reference)->where('payday', '>=', $release->payday)->get();

                foreach ($future as $fut) {

                    $store = $data;

                    $lastday = date('t', strtotime($fut->payday));

                    $registerDay = $newDay;
                    if ($registerDay > $lastday) {

                        $registerDay = $lastday;
                    }

                    $store['payday'] = date('Y-m-', strtotime($fut->payday)) . $registerDay . ' 00:00:00';

                    $fut->update($store);
                }
            }
    }

    public static function deleteAll($request){
        $release = Release::findOrFail($request->id);
        $uCompany = auth()->user()->company;
        $rCompany = Account::findOrFail($release->account)->company();
        
        if($uCompany != $rCompany->id){
            return back()->withErrors(['Acesso negado.']);
        }
        
        $all = Release::where([['reference', '=', $release->reference]])->get();

        if ($all->count() > 0) {
            foreach ($all as $a) {
                $a->delete();
            }
        }
    }

    public static function deleteOnly($request){
        $release = Release::findOrFail($request->id);
        $uCompany = auth()->user()->company;
        $rCompany = Account::findOrFail($release->account)->company();
        
        if($uCompany != $rCompany->id){
            return back()->withErrors(['Acesso negado.']);
        }
        

        $date = explode('/', $request->date);

        if($release->recurrence == '1:1'){
            $release->delete();
        }elseif($release->recurrence == '0:inf'){
            $date1 = new \DateTime($date[2].'-'.$date[1].'-'.$date[0]);
            $date2 = new \DateTime($release->payday);
            $diff = ($date1->format('Y') - $date2->format('Y'))*12 + ($date1->format('m') - $date2->format('m'));
            $fakeRecurrence = ($diff + 1) . ':inf';

            $rec = str_replace(':inf', '', $fakeRecurrence);

            $data = $release->toArray();
            unset($data['id']);
            $data['payday'] = uDate::addMonthToDate($rec - 1 , date('Y-m-d', strtotime($release->payday)));
            $data['recurrence'] = $fakeRecurrence;
            $data['status'] = 'payd';
            $data['value'] = 0.0;

            Release::create($data);
        }else{
            $release->update(['value' => 0.0, 'status' => 'payd']);
        }
    }

    public static function deleteFuture($request){
        $release = Release::findOrFail($request->id);
        $uCompany = auth()->user()->company;
        $rCompany = Account::findOrFail($release->account)->company();
        
        if($uCompany != $rCompany->id){
            return back()->withErrors(['Acesso negado.']);
        }
        
        $date = explode('/', $request->date);
        if($release->recurrence == '0:inf'){
            $date1 = new \DateTime($date[2].'-'.$date[1].'-'.$date[0]);
            $date2 = new \DateTime($release->payday);
            $diff = ($date1->format('Y') - $date2->format('Y'))*12 + ($date1->format('m') - $date2->format('m'));
            $fakeRecurrence = ($diff + 1) . ':inf';

            $future = Release::where([['reference', '=', $release->reference], ['payday', '>=', $date[2].'-'.$date[1].'-'.$date[0]]])->get();

            if ($future->count() > 0) {
                foreach ($future as $fut) {
                    $fut->delete();
                }
            }

            $rec = str_replace(':inf', '', $fakeRecurrence);

            for ($i=1; $i < $rec; $i++) {
                $test = Release::where([['reference', '=', $release->reference], ['recurrence', '=', $i.':inf']])->get();

                if ($test->count() > 0 ) {
                    $test->first()->update(['recurrence' => $i.':'.($rec - 1)]);
                }else{
                    $data = $release->toArray();
                    unset($data['id']);
                    $data['payday'] = uDate::addMonthToDate($i-1, date('Y-m-d', strtotime($release->payday)));
                    $data['recurrence'] = $i.':'.($rec - 1);
                    $data['status'] = 'pending';

                    Release::create($data);
                }
            }

            $release->delete();
        }elseif(strpos($release->recurrence, ':inf')){
            $rec = str_replace(':inf', '', $release->recurrence);

            $first = Release::where([['recurrence', '=', '0:inf'], ['reference', '=', $release->reference]])->get();

            for ($i=1; $i < $rec; $i++) {
                $rel = Release::where([['reference', '=', $release->reference], ['recurrence', '=', $i.':inf']])->get();
                if($rel->count() > 0){
                    $rel->first()->update(['recurrence' => $i.':'.($rec - 1)]);
                }else{
                    $data = $release->toArray();
                    unset($data['id']);
                    $data['payday'] = uDate::addMonthToDate($i, $first->payday);
                    $data['recurrence'] = $i.':'.($rec - 1);
                    $data['status'] = 'pending';

                    Release::create($data);
                }
            }
            $first->delete();

            $future = Release::where([['reference', '=', $release->reference], ['payday', '>=', $release->payday]])->get();

            foreach($future as $fut){
                $fut->delete();
            }
        }else{
            $future = Release::where([['reference', '=', $release->reference], ['payday', '>=', $release->payday]])->get();

            if ($future) {
                foreach ($future as $fut) {
                    $fut->delete();
                }
            }

            $all = Release::where([['reference', '=', $release->reference]])->get();

            if ($all->count() > 0) {
                foreach ($all as $a) {
                    $parcel = explode(':', $a->recurrence);
                    $a->update(['recurrence' => $parcel[0].':'. $all->count()]);
                }
            }
        }
    }

    public static function efective(Array $data){

        $data['payday'] = \DateTime::createFromFormat('d/m/Y H:i:s', $data['date'] . ' 00:00:00');
        $data['original_date'] = \DateTime::createFromFormat('d/m/Y H:i:s', $data['original_date'] . ' 00:00:00');

        $data['value'] = str_replace(',', '.', str_replace('.', '', $data['value']));

        $data['status'] = 'payd';

        $release = Release::findOrFail($data['id']);
        $uCompany = auth()->user()->company;
        $rCompany = Account::findOrFail($release->account)->company();
        
        if($uCompany != $rCompany->id){
            return back()->withErrors(['Acesso negado.']);
        }

        if ($release->recurrence == '0:inf') {
            $date1 = new \DateTime($data['original_date']->format('Y-m-d'));
            $date2 = new \DateTime($release->payday);
            $diff = ($date1->format('Y') - $date2->format('Y'))*12 + ($date1->format('m') - $date2->format('m'));
            $fakeRecurrence = ($diff + 1) . ':inf';


            $data['type'] = $release->type;
            $data['reference'] = $release->reference;
            $data['category'] = $release->category;
            $data['recurrence'] = $fakeRecurrence;
            $data['account'] = $release->account;
            $data['payday'] = $data['payday']->format('Y-m-d'). ' 00:00:00';

            Release::create($data);
        }else{
            if ($release->status == 'payd') {
                $data['status'] = 'pending';
            }
            $data['payday'] = $data['payday']->format('Y-m-d'). ' 00:00:00';
            $release->update($data);
        }
    }
    
    public static function pieChartData($releases){
        $PieData = [];
        foreach ($releases as $rel) {
            if (isset($PieData[$rel->category])) {
                $PieData[$rel->category]['value'] = $PieData[$rel->category]['value'] + $rel->value;
            } else {
                $PieData[$rel->category] = ['name' => $rel->categoryName, 'color' => $rel->categoryColor, 'value' => $rel->value];
            }
        }
        
        return $PieData;
    }
    
    
}
