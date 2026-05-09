<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sppg_id')->nullable()->constrained()->onDelete('set null');
            $table->string('target_group'); // SD, SMP, SMA, Pesantren, Posyandu Balita, Ibu Hamil
            $table->date('serve_date'); // date when this menu is served
            $table->string('food_name');
            $table->integer('calories')->nullable();
            $table->decimal('protein_g', 5, 2)->nullable();
            $table->decimal('karbo_g', 5, 2)->nullable();
            $table->decimal('fat_g', 5, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
