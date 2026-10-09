<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('acudientes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->string('nombre');
            $table->string('apellido');
            $table->string('telefono');
            $table->string('email')->nullable();
            $table->string('parentesco');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('acudientes'); }
};