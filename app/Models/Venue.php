<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    protected $table = 'venues';
    protected $fillable = [
        'name', 'size', 'address', 'booked_dates'
    ];
    protected $casts = [
        'booked_dates' => 'array',
    ];
}
