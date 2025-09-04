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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name');                       // task name
            $table->text('description')->nullable();      // task description
            $table->boolean('is_done')->default(false);   // completion status
            $table->timestamp('deadline')->nullable();    // deadline date
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // linked user
            $table->timestamps();                         // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
