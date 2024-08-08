<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $primaryKey = 'loan_id';



 /**
 * The attributes that should be cast.
 *
 * @var array
 */
protected $casts = [
    'loan_start_date' => 'date:Y-m-d',
];

public function schedules()
{
    return $this->hasMany(Schedule::class);
}

}
