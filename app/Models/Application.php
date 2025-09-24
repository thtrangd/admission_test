<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'user_id',
        'program',
        'status',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function registrations() {
        return $this->hasMany(Registration::class);
    }

    public function statusLogs() {
        return $this->hasMany(ApplicationStatusLog::class);
    }
}
