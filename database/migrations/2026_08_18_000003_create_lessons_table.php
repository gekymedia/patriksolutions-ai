<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description');
            $table->longText('content')->nullable();
            $table->string('content_type')->default('text');
            $table->string('video_url')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->unsignedSmallInteger('duration_minutes')->nullable();
            $table->text('ai_lesson_prompt')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
