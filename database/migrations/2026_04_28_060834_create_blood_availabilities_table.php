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
    Schema::create('blood_availabilities', function (Blueprint $table) {
        $table->id();

        // link to hospital
        $table->foreignId('hospital_id')->constrained()->onDelete('cascade');

        // blood details
        $table->string('blood_type'); // e.g. A+, O-
        $table->integer('quantity');

        // status for matching
        $table->enum('status', ['available', 'reserved', 'unavailable'])->default('available');

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blood_availabilities');
    }
};
