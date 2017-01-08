<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Requests;

use App\User;
use App\Models\Finacial\Address;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'status', 'password', 'company'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function cpfFormat($cpf)
    {
        $cpf =  preg_replace('/\D/', '', $cpf);
        if($cpf != ''){
            $newCPF = substr($cpf , 0, 3).".".substr($cpf , 3, 3).".".substr($cpf , 6, 3)."-".substr($cpf , 9, 2);
        }else{
            $newCPF = '';
        }
        

        return $newCPF;
    }

    public function address()
    {
        return $this->belongsTo('App\Models\Register\Address', 'address')->get();
    }

    public function company()
    {
        return $this->belongsTo('App\Models\Register\Company', 'company')->get()->first();
    }
    
    

    public static function findCustomers(Request $request)
    {

        $result = \DB::table('addresses')
            ->join('users', 'addresses.id', '=', 'users.address')
            ->where('addresses.zip_code', 'LIKE', '%'.$request->zip_code.'%')
            ->where('addresses.street', 'LIKE', '%'.$request->street.'%')
            ->where('addresses.street_number', 'LIKE', '%'.$request->street_number.'%')
            ->where('addresses.complement', 'LIKE', '%'.$request->complement.'%')
            ->where('addresses.district', 'LIKE', '%'.$request->district.'%')
            ->where('addresses.city', 'LIKE', '%'.$request->city.'%')
            ->where('addresses.state', 'LIKE', '%'.$request->state.'%')
            ->where('users.first_name', 'LIKE', '%'.$request->first_name.'%')
            ->where('users.last_name', 'LIKE', '%'.$request->last_name.'%')
            ->where('users.cpf', 'LIKE', '%'.$request->cpf.'%')
            ->where('users.email', 'LIKE', '%'.$request->email.'%')
            ->where('users.status', 'LIKE', '%'.$request->status.'%')
            ->where('users.phone_1', 'LIKE', '%'.$request->phone_1.'%')
            ->where('users.phone_2', 'LIKE', '%'.$request->phone_2.'%')
            ->select('users.*', 'addresses.street', 'addresses.street_number', 'addresses.zip_code', 'addresses.complement', 'addresses.district', 'addresses.city', 'addresses.state')
            ->get()->toArray();

        return $result;
    }
}
