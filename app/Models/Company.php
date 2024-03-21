<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    
    CONST ACTIVE    = 'active';
    CONST INACTIVE  = 'inactive';
}
