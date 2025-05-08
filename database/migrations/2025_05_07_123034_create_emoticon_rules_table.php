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
        Schema::create('emoticon_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attendance_list_id')->constrained()->onDelete('cascade');
            $table->string('status_name'); // e.g., "Sangat Awal", "Tepat Waktu"
            // Offset dalam menit relatif terhadap 'target_ontime_time' di attendance_lists
            // Misal: Sangat Awal: start_offset = -60 (60 menit sebelum target), end_offset = -30 (30 menit sebelum target)
            // Tepat Waktu: start_offset = -5, end_offset = 10
            $table->integer('time_window_start_offset_minutes');
            $table->integer('time_window_end_offset_minutes');
            $table->json('emoticons'); // Menyimpan array emoticon, e.g., ["😊", "😎"]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emoticon_rules');
    }
};
