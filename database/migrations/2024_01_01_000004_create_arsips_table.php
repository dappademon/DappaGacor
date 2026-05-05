<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
 
return new class extends Migration {
    public function up(): void
    {
        Schema::create('arsips', function (Blueprint $table) {
            $table->id();
            $table->string('archive_number', 50)->unique();
            $table->string('title', 150);
            $table->foreignId('category_id')->constrained('kategoris')
                  ->onDelete('restrict');
            $table->foreignId('resident_id')->nullable()
                  ->constrained('penduduks')->onDelete('set null');
            $table->foreignId('user_id')->constrained('users')
                  ->onDelete('restrict');
            $table->date('document_date');
            $table->string('sender_receiver', 100)->nullable();
            $table->string('file_path', 255);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }
 
    public function down(): void
    {
        Schema::dropIfExists('arsips');
    }
};
