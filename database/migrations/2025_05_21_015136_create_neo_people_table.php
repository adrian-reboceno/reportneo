<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\NeoTenant;
use App\Models\NeoStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('neo_people', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(NeoTenant::class)->constrained(); 
            $table->foreignIdFor(NeoStatus::class)->constrained(); 
            $table->integer('lms_id');
            $table->string('sisid')->nullable(true);
            $table->string('first_name');
            $table->string('last_name');
            $table->string('studentID')->nullable(true);
            $table->string('teacherID')->nullable(true);
            $table->string('email');
            $table->string('educational_program')->nullable(true);
            $table->string('joined_at');
            $table->string('first_login_at');
            $table->string('last_login_at');
            $table->string('last_login_ip');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('neo_people');
    }
};
