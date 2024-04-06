<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoProfiling extends Model
{
    use HasFactory;
    const INTERNAL = 'internal';
    const EXTERNAL = 'external';

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function location(){
        return $this->belongsTo(JobLocation::class,'job_location_id','id');
    }
}
