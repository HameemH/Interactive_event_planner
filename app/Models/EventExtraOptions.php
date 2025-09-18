<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventExtraOptions extends Model
{
    use HasFactory;

    protected $table = 'event_extra_options';

    protected $fillable = [
        'event_id',
        'photo_booth',
        'coffee_booth',
        'mehendi_booth',
        'paan_booth',
        'fuchka_stall',
        'sketch_booth',
        'extra_options_cost'
    ];

    protected $casts = [
        'photo_booth' => 'boolean',
        'coffee_booth' => 'boolean',
        'mehendi_booth' => 'boolean',
        'paan_booth' => 'boolean',
        'fuchka_stall' => 'boolean',
        'sketch_booth' => 'boolean',
        'extra_options_cost' => 'decimal:2'
    ];

    /**
     * Get the event that owns these extra options
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}