<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use SoftDeletes;

    protected $fillable = ['nombre', 'grado', 'grupo', 'codigo', 'observaciones'];

    public function lateArrivals(): HasMany
    {
        return $this->hasMany(LateArrival::class);
    }

    public function acudientes(): HasMany
    {
        return $this->hasMany(Acudiente::class);
    }

    public function sanctions(): HasMany
    {
        return $this->hasMany(Sanction::class);
    }
}