<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    /** @use HasFactory<\Database\Factories\EventFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'event_date_at',
        'sale_start_at',
        'sale_end_at',
        'is_dynamic_price',
        'max_number_allowed',
        'image',
    ];

    protected $casts = [
        'event_date_at' => 'datetime',
        'sale_start_at' => 'datetime',
        'sale_end_at'   => 'datetime',
        'is_dynamic_price' => 'boolean',
    ];

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }
}
