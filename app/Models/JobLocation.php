<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class JobLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'city',
        'state',
        'created_by',
        'company_id'
    ];

    public function createdBy(){
        return $this->belongsTo(User::class,'created_by','id');
    }

    public function location(){
        return $this->belongsTo(JobLocation::class,'job_location_id','id');
    }

    public static function getLocations (){
        return  JobLocation::select('id','city')->where('company_id',app('company_id'))->get();
    }
}
