<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $fillable = ['status', 'lat', 'lng', 'portions', 'portions_besar', 'portions_kecil', 'sppg_id'];

    public function sppg() { return $this->belongsTo(Sppg::class); }
    public function nutrition() { return $this->hasOne(Nutrition::class); }
}
