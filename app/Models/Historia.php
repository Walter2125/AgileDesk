<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Historia extends Model
{
    public function columna() {
        return $this->belongsTo(Columna::class);
    }
    public function sprint() {
        return $this->belongsTo(Sprint::class);
    }
}
