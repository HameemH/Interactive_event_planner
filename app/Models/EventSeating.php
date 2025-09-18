<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventSeating extends Model
{
    use HasFactory;

    protected $table = 'event_seating';

    protected $fillable = [
        'event_id',
        'attendees',
        'chair_type',
        'table_type',
        'seat_cover',
        'seating_cost'
    ];

    protected $casts = [
        'attendees' => 'integer',
        'seat_cover' => 'boolean',
        'seating_cost' => 'decimal:2'
    ];

    /**
     * Get the event that owns this seating configuration
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}