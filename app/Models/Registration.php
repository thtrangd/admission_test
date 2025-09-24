<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $fillable = [
        'application_id',
        'course_name',
        'registered_at',
    ];

    public function application() {
        return $this->belongsTo(Application::class);
    }
}
