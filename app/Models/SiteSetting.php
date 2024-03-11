<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'site_theme_id',
        'site_logo1',
        'primary_color',
        'secondary_color',
        'hero_text',
        'address_1',
        'address_2',
        'address_3',
        'phone_1',
        'phone_2',
        'phone_3',
        'email_1',
        'email_2',
        'email_3',
    ];

    public function siteTheme(){
        return $this->belongsTo(SiteTheme::class,'site_theme_id','id');
    }
}
