<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Acudiente extends Model
{
    protected $fillable = ['student_id', 'nombre', 'apellido', 'telefono', 'email', 'parentesco'];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}