<?php

namespace App\Models\Register;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name'
    ];

    protected $hidden = [
        // nada
    ];

    public function accounts()
    {
    	return $this->hasMany('App\Models\Financial\Account', 'company')->get();
    }
}
