<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventCatering extends Model
{
    use HasFactory;

    protected $table = 'event_catering';

    protected $fillable = [
        'event_id',
        'catering_required',
        'per_person_cost',
        'total_guests',
        'total_catering_cost'
    ];

    protected $casts = [
        'catering_required' => 'boolean',
        'per_person_cost' => 'decimal:2',
        'total_guests' => 'integer',
        'total_catering_cost' => 'decimal:2'
    ];

    /**
     * Get the event that owns this catering configuration
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}