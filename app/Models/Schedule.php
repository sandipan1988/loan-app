<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $primaryKey = 'schedule_id';

    public function loan()
    {
        return $this->belongsTo(Loan::class,'loan_id');
    }

    /**
 * The attributes that should be cast.
 *
 * @var array
 */
protected $casts = [
    'installment_date' => 'date:Y-m-d',
    'paid_date' => 'date:Y-m-d',
];
}
