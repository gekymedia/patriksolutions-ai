<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            // Minimum membership tier required to access the full course.
            // free  = any signed-in user (Free Account)
            // pro   = AI Member ($19) or higher
            // elite = AI Pro ($49)
            $table->string('required_plan')->default('free')->after('is_published');
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn('required_plan');
        });
    }
};
