<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\NeoOrganization;
use App\Models\NeoTenant;
use App\Models\NeoStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('neo_classes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(NeoTenant::class)->constrained(); 
            $table->foreignIdFor(NeoOrganization::class)->constrained(); 
            $table->foreignIdFor(NeoStatus::class)->constrained(); 
            $table->integer('lms_class');
            $table->unsignedBigInteger('parent_id');
            $table->string('name');
            $table->string('access_code')->nullable(true);;
            $table->integer('creator_id');
            $table->string('createdat');
            $table->string('language');
            $table->string('subject');
            $table->integer('used_seats');
            $table->string('style');
            $table->string('start_at')->nullable(true);
            $table->string('finish_at')->nullable(true);
            $table->string('time_zone');
            $table->string('section_code')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('neo_classes');
    }
};
