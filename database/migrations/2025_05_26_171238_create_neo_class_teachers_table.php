<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\NeoClass;
use App\Models\NeoPerson;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('neo_class_teachers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(NeoClass::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(NeoPerson::class)->constrained()->onDelete('cascade');
            $table->string('coteacher'); 
            $table->string('last_visited_at')->nullable(true); // Date when the teacher joined the class
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('neo_class_teachers');
    }
};
