<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommunicationLog extends Model
{
    protected $fillable = [
        'application_id',
        'message',
        'sent_at',
    ];

    public function application() {
        return $this->belongsTo(Application::class);
    }
}
