<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    use HasFactory;

    public function events() {
        return $this->belongsToMany(Event::class, 'domain_event', 'domain_id', 'event_id')->withTimestamps();
    }

    public function latestEvents() {
        return $this->events()->orderBy('created_at', 'desc');
    }
}
