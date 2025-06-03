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
        Schema::create('neo_class_students', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(NeoClass::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(NeoPerson::class)->constrained()->onDelete('cascade');
            $table->string('enrolled_at'); // 
            $table->string('enroll_type'); // 
            $table->integer('enrolled_by_id'); // 
            $table->boolean('started')->nullable(true);; // 
            $table->string('started_at')->nullable(true);; // 
            $table->boolean('completed')->nullable(true);; // I
            $table->boolean('unenrolled')->nullable(true);; 
            $table->boolean('deactivated')->nullable(true);; 
            $table->boolean('transferred')->nullable(true);; 
            $table->boolean('class_archived')->nullable(true);; 
            $table->boolean('user_archived')->nullable(true);;
            $table->decimal('percent', total: 10, places: 2)->nullable(true);;
            $table->decimal('grade',total: 10, places: 2 )->nullable(true);;
            $table->string('override_percent')->nullable(true);;
            $table->string('override_comment')->nullable(true);; 
            $table->string('override_by_id')->nullable(true);; 
            $table->string('override_at')->nullable(true);; 
            $table->integer('time_spent')->nullable(true);; 
            $table->string('last_visited_at')->nullable(true);; 
            $table->string('order_item_id')->nullable(true); //
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('neo_class_students');
    }
};
