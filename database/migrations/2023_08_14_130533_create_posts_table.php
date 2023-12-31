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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->text('content')->nullable();
            $table->smallInteger('status')->comment('0: Private, 1: Public');
            $table->string('image', 50)->nullable();
            $table->foreignId('category_id')->constrained('categories');
            $table->foreignId('created_by_id')->constrained('admins');
            $table->foreignId('modified_by_id')->constrained('admins');
            $table->date('posted_at')->default(today());
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
