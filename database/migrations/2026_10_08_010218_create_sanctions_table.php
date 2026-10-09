<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sanctions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('late_arrival_id')->nullable()->constrained('late_arrivals')->onDelete('cascade');
            $table->string('tipo');
            $table->string('motivo')->nullable();
            $table->boolean('requiere_sancion')->default(true);
            $table->text('descripcion')->nullable();
            $table->date('fecha');
            $table->string('estado')->default('activa');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('sanctions'); }
};