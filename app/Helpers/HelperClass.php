<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;
use App\Models\Member;
use App\Models\Schedule;
use Carbon\Carbon;

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

    public static function checkUserByEmail(string $member_email) : bool {
        $member = Member::where('email', $member_email)->count();
        if($member){
            return true;
        }
        return false;
    }

    public static function checkUserByPhone(string $phone) : bool{
        $member = Member::where('phone', $phone)->count();
        if($member){
            return true;
        }
        return false;
    }

    public static function memberNameandPhone($member_id) {
        $member = Member::where('member_id',$member_id)->first();
        if($member){
            return [$member->name,$member->phone];
        }
        return false;
    }

    public static function rupee_format($num) {
        $explrestunits = "" ;
        if(strlen($num)>3){
            $lastthree = substr($num, strlen($num)-3, strlen($num));
            $restunits = substr($num, 0, strlen($num)-3); // extracts the last three digits
            $restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
            $expunit = str_split($restunits, 2);
            for($i=0; $i<sizeof($expunit); $i++){
                // creates each of the 2's group and adds a comma to the end
                if($i==0)
                {
                    $explrestunits .= (int)$expunit[$i].","; // if is first value , convert into integer
                }else{
                    $explrestunits .= $expunit[$i].",";
                }
            }
            $thecash = $explrestunits.$lastthree;
        } else {
            $thecash = $num;
        }
        return $thecash; // writes the final format where $currency is the currency symbol.
    }

    public static function getDay($date){
        $day = Carbon::parse($date)->shortEnglishDayOfWeek;
        return $day;

    }

    public static function getPaid($loan_id){
        $paid_amt = Schedule::where('loan_id', $loan_id)->where('is_paid', 'YES')->sum('installment_amount');
        return self::rupee_format($paid_amt);

    }

    public static function getDue($loan_amt,$paid_amt){
        return self::rupee_format($loan_amt - $paid_amt);

    }
}
