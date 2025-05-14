<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //             
            $table->string('paternal_surname')->nullable()->after('name');
            $table->string('maternal_surname')->nullable()->after('paternal_surname');
            $table->string('avatar')->nullable()->after('remember_token'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropColumn('paternal_name');
            $table->dropColumn('maternal_name');
            $table->dropColumn('avatar');
        });
    }
};
