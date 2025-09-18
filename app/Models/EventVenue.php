<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventVenue extends Model
{
    use HasFactory;

    protected $table = 'event_venue';

    protected $fillable = [
        'event_id',
        'venue_name',
        'venue_address',
        'venue_size',
        'venue_cost'
    ];

    protected $casts = [
        'venue_size' => 'decimal:2',
        'venue_cost' => 'decimal:2'
    ];

    /**
     * Get the event that owns this venue configuration
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Get the venue details
     */
    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }
}