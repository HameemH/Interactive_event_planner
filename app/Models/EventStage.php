<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventStage extends Model
{
    use HasFactory;

    protected $table = 'event_stage';

    protected $fillable = [
        'event_id',
        'stage_type',
        'stage_image_link',
        'surrounding_decoration',
        'decoration_image_link',
        'stage_cost'
    ];

    protected $casts = [
        'surrounding_decoration' => 'boolean',
        'stage_cost' => 'decimal:2'
    ];

    /**
     * Get the event that owns this stage configuration
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}