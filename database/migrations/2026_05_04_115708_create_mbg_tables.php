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
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('public'); // driver, admin, public
        });

        Schema::create('sppgs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location');
            $table->timestamps();
        });

        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default('pending'); // pending, transit, delivered
            $table->decimal('lat', 10, 8)->nullable();
            $table->decimal('lng', 11, 8)->nullable();
            $table->integer('portions');
            $table->foreignId('sppg_id')->constrained('sppgs');
            $table->timestamps();
        });

        Schema::create('financial_records', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->decimal('bahan_cost', 15, 2);
            $table->decimal('transport_cost', 15, 2);
            $table->decimal('total', 15, 2);
            $table->foreignId('sppg_id')->constrained('sppgs');
            $table->timestamps();
        });

        Schema::create('nutritions', function (Blueprint $table) {
            $table->id();
            $table->integer('calories');
            $table->integer('protein_g');
            $table->integer('karbo_g');
            $table->foreignId('delivery_id')->constrained('deliveries');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nutritions');
        Schema::dropIfExists('financial_records');
        Schema::dropIfExists('deliveries');
        Schema::dropIfExists('sppgs');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
