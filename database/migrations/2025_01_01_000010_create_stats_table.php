<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('stats', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->integer('value');
            $table->string('suffix')->default('+');
            $table->string('icon')->default('🌿');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('stats'); }
};
