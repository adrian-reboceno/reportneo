<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\NeoPerson;
use App\Models\NeoProfile;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('neo_person_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(NeoPerson::class)->constrained(); 
            $table->foreignIdFor(NeoProfile::class)->constrained(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('neo_person_profiles');
    }
};
