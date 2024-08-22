<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;

class HelperClass
{
    public static function getLoanType(string $string)
    {

        switch ($string) {
            case '1':
                return 'Daily';
                break;
            case '2':
                return 'Weekly';
                break;
            case '3':
                return 'Monthly';
                break;
            default:
                return 'Unknown Loan Type';
                break;
        }
        return "" ;
    }
}
