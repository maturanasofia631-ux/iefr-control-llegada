<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LateArrival extends Model
{
    protected $fillable = ['student_id', 'fecha', 'hora', 'motivo', 'tiene_excusa', 'observacion'];

    protected $casts = ['fecha' => 'date', 'tiene_excusa' => 'boolean'];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function sanction(): HasMany
    {
        return $this->hasMany(Sanction::class);
    }

    public function requiereSancion(): bool
    {
        if ($this->motivo === 'Salud' && $this->tiene_excusa) return false;
        return true;
    }
}