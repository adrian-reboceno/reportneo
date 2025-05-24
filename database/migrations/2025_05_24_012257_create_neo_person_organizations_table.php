<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\NeoPerson;
use App\Models\NeoOrganization;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('neo_person_organizations', function (Blueprint $table) {
            $table->id();            
            $table->foreignIdFor(NeoOrganization::class)->constrained(); 
            $table->foreignIdFor(NeoPerson::class)->constrained(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('neo_person_organizations');
    }
};
