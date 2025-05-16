<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\NeoTenant;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('neo_organizations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(NeoTenant::class)->constrained();
            $table->integer('lms_organization');
            $table->string('name_organization');            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('neo_organizations');
    }
};
