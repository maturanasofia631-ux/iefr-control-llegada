<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('excuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('late_arrival_id')->constrained('late_arrivals')->onDelete('cascade');
            $table->string('tipo');
            $table->text('descripcion')->nullable();
            $table->string('archivo')->nullable();
            $table->boolean('aprobada')->default(false);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('excuses'); }
};