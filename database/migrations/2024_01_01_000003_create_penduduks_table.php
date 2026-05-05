<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
 
return new class extends Migration {
    public function up(): void
    {
        Schema::create('penduduks', function (Blueprint $table) {
            $table->id();
            $table->char('nik', 16)->unique();
            $table->string('name', 100);
            $table->text('address');
            $table->timestamps();
        });
    }
 
    public function down(): void
    {
        Schema::dropIfExists('penduduks');
    }
};

