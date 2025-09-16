<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('series', function (Blueprint $table) {
            $table->id();
            $table->string('title');                        
            $table->foreignId('director_id')               
                  ->constrained('directors')
                  ->cascadeOnUpdate()->restrictOnDelete();
            $table->date('release_date')->nullable();      
            $table->text('description')->nullable();       
            $table->string('image')->nullable();           
            $table->foreignId('type_id')                  
                  ->constrained('types')
                  ->cascadeOnUpdate()->restrictOnDelete();
            $table->unsignedSmallInteger('length')->nullable(); 
            $table->timestamps();

            $table->index(['title','release_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('series');
    }
};
