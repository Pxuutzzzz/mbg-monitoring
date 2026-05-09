<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinancialRecord extends Model
{
    protected $table = 'financial_records';
    protected $fillable = ['date', 'bahan_cost', 'transport_cost', 'total', 'sppg_id', 'breakdown'];

    protected $casts = [
        'breakdown' => 'array',
    ];

    public function sppg() { return $this->belongsTo(Sppg::class); }

    // Get related delivery by sppg_id and date (same day, same mitra)
    public function getDeliveryAttribute()
    {
        return \App\Models\Delivery::where('sppg_id', $this->sppg_id)
                    ->whereDate('created_at', $this->date)
                    ->first();
    }
}
