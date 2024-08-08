<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'date_of_birth',
        'date_became_member',
        'address',
    ];


    protected $casts = [
        'date_of_birth' => 'date',
        'date_became_member' => 'date',
    ];
}
?>