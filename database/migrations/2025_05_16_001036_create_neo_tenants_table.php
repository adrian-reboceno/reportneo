<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Status;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('neo_tenants', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Status::class)->constrained(); 
            $table->integer('idportal');
            $table->string('school_name');
            $table->string('url');
            $table->string('privatekey');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('neo_tenants');
    }
};
