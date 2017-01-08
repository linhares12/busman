<?php

namespace App\Models\Financial;

use Illuminate\Database\Eloquent\Model;
use App\Models\Register\Company;

class Account extends Model
{
    protected $fillable = [
        'name', 'company', 'amount'
    ];

    protected $hidden = [
        // nada
    ];

    public static function accountsList(){
        $accounts =  Company::findOrFail(auth()->user()->company)->accounts();

        $accArray = [];
        foreach ($accounts as $acc) {
            $accArray[$acc->id] = $acc->name;
        }

        return $accArray;
    }
    
    public static function userAccounts(){
        return auth()->user()->company()->accounts();
    }
    
    public function company(){
        return $this->belongsTo('App\Models\Register\Company', 'company')->get()->first();
    }
}
