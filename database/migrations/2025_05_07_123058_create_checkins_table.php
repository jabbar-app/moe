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
        Schema::create('checkins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attendance_list_id')->constrained()->onDelete('cascade');
            $table->string('participant_name');
            $table->string('team_name')->nullable();
            $table->timestamp('checkin_time'); // Waktu pasti saat user check-in
            $table->string('status_at_checkin'); // e.g., "Tepat Waktu", "Terlambat"
            $table->string('selfie_image_path'); // Path ke file foto selfie
            $table->string('displayed_emoticon'); // Emoticon yang ditampilkan saat user selfie
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkins');
    }
};
