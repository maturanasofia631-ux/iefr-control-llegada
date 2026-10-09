<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('late_arrivals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->date('fecha');
            $table->time('hora');
            $table->string('motivo');
            $table->boolean('tiene_excusa')->default(false);
            $table->text('observacion')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('late_arrivals'); }
};