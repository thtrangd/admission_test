<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationStatusLog extends Model
{
    protected $fillable = [
        'application_id',
        'status',
        'changed_at',
    ];

    public function application() {
        return $this->belongsTo(Application::class);
    }
}
