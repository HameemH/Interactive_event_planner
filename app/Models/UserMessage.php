<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMessage extends Model
{
    use HasFactory;

    protected $table = 'user_messages';

    protected $fillable = [
        'event_id',
        'venue_message',
        'seating_message',
        'stage_message',
        'catering_message',
        'photography_message',
        'extra_options_message',
    ];

    /**
     * Get the event that this message belongs to
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Get all messages for a user
     */
    public function getAllMessages()
    {
        return [
            'venue' => $this->venue_message,
            'seating' => $this->seating_message,
            'stage' => $this->stage_message,
            'catering' => $this->catering_message,
            'photography' => $this->photography_message,
            'extra_options' => $this->extra_options_message,
        ];
    }

    /**
     * Check if user has messages for specific module
     */
    public function hasMessageFor($module)
    {
        $field = $module . '_message';
        return !empty($this->$field);
    }
}