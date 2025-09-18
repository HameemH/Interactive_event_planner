<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventPhotography extends Model
{
    use HasFactory;

    protected $table = 'event_photography';

    protected $fillable = [
        'event_id',
        'photography_required',
        'package_type',
        'customizable',
        'num_photographers',
        'num_hours',
        'indoor',
        'outdoor',
        'cinematography',
        'photography_cost'
    ];

    protected $casts = [
        'photography_required' => 'boolean',
        'customizable' => 'boolean',
        'num_photographers' => 'integer',
        'num_hours' => 'integer',
        'indoor' => 'boolean',
        'outdoor' => 'boolean',
        'cinematography' => 'boolean',
        'photography_cost' => 'decimal:2'
    ];

    /**
     * Get the event that owns this photography configuration
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}