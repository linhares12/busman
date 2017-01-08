<?php

namespace App\Models\Utility;

use Illuminate\Database\Eloquent\Model;

class uDate extends Model
{
    public static function addMonthToDate($parcelNumber = 1, $startDate){

        $date = new \DateTime($startDate);

    	$a_y = (int)($date->format('Y') + ($date->format('m') + $parcelNumber)/12.1);
    	$a_m = $date->format('m') + $parcelNumber;

    	if ($a_m > (12*($a_y - $date->format('Y')))) {
    		$a_m = $a_m - (12*($a_y - $date->format('Y')));
    	}

    	$dateToTest = $a_y.'-'.$a_m.'-01';
        $lastday = date('t',strtotime($dateToTest));
        $d = $date->format('d');
        if($d > $lastday){
        	$d = $lastday;
        }

        $nextDate = \DateTime::createFromFormat('d/m/Y H:i:s', $d.'/'.$a_m.'/'.$a_y.' 00:00:00')->format('Y-m-d H:i:s');

    	return $nextDate;
    }
}
