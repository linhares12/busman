<?php

namespace App\Models\Financial;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name', 'color', 'type', 'company'
    ];

    protected $hidden = [
        //
    ];
    
    public static function allCategories(){
    	return Self::where('name', '!=', 'account_transfer')
                ->where('company', '=', auth()->user()->company)
                ->orderBy('name', 'asc')
                ->get();
    }

    public static function receipt(){
    	return Self::where('type', '=', 'receipt')
                ->where('name', '!=', 'account_transfer')
                ->where('company', '=', auth()->user()->company)
                ->orderBy('name', 'asc')
                ->get();
    }

    public static function expense(){
    	return Self::where('type', '=', 'expense')
                ->where('name', '!=', 'account_transfer')
                ->where('company', '=', auth()->user()->company)
                ->orderBy('name', 'asc')
                ->get();
    }
    
    public static function categoryList($type){

        switch ($type) {
            case 'receipt':
                $category = Category::receipt();
                break;
            case 'expense':
                $category = Category::expense();
                break;

            default:
                return back()->withErrors(['Tipo de categoria inválida']);
                break;
        }

        $categories = [];

        foreach ($category as $cat) {
            $categories[$cat->id] = $cat->name; // Prepare array to selectbox
        }

        return $categories;
    }
}
