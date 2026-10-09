<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Excuse extends Model
{
    protected $fillable = ['late_arrival_id', 'tipo', 'descripcion', 'archivo', 'aprobada'];
    protected $casts = ['aprobada' => 'boolean'];

    public function lateArrival(): BelongsTo
    {
        return $this->belongsTo(LateArrival::class);
    }
}