<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\NeoTenant;
use App\Models\Status;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('neo_apis', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(NeoTenant::class)->constrained();   
            $table->foreignIdFor(Status::class)->constrained();   
            $table->string('hostapi');
            $table->string('apikey');
            $table->string('version');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('neo_apis');
    }
};
