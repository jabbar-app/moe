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
        Schema::create('attendance_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Admin yang membuat
            $table->string('event_name');
            $table->text('description')->nullable();
            $table->date('event_date');
            $table->time('event_start_time'); // Jam acara dimulai
            $table->time('checkin_open_time'); // Kapan check-in mulai dibuka
            $table->time('target_ontime_time'); // Batas waktu ideal untuk dianggap "Tepat Waktu"
            $table->time('checkin_close_time'); // Kapan check-in ditutup
            $table->string('unique_link_token')->unique()->nullable(); // Token untuk link & QR
            $table->enum('status', ['pending', 'active', 'finished', 'cancelled'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_lists');
    }
};
