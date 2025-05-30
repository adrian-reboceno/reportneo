<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\NeoPerson;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('neo_class_attendance_session_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('session_id');
            $table->foreign('session_id', 'fk_session_user')
            ->references('id')
            ->on('neo_class_attendance_sessions')
            ->onDelete('cascade');
            $table->foreignIdFor(NeoPerson::class)->constrained()->onDelete('cascade');
            $table->string('status'); // Status can be 'present', 'absent', 'late', etc.
            $table->string('arrived_late')->nullable(true); // Nullable, in case the user was not late
            $table->string('left_early')->nullable(true); // Nullable, in case the user was not late
            $table->string('excused')->nullable(true); // Nullable, in case the user was not late
            $table->string('note')->nullable(true); // Nullable, for any additional notes
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('neo_class_attendance_session_users');
    }
};
