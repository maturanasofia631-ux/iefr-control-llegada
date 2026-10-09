<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sanction extends Model
{
    protected $fillable = ['student_id', 'late_arrival_id', 'tipo', 'motivo', 'requiere_sancion', 'descripcion', 'fecha', 'estado'];
    protected $casts = ['fecha' => 'date'];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function lateArrival(): BelongsTo
    {
        return $this->belongsTo(LateArrival::class);
    }
}