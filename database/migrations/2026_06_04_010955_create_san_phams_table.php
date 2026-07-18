<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('san_phams', function (Blueprint $table) {
            $table->id();
            $table->string('ten_sp', 50);
            $table->string('xuat_xu', 50)->nullable();
            $table->string('chat_lieu', 50)->nullable();
            $table->decimal('gia', 18, 0)->nullable();
            $table->string('hinh_anh', 100)->nullable();
            $table->string('mo_ta', 200)->nullable();

            // Khóa ngoại liên kết với bảng danh_mucs
            $table->unsignedBigInteger('danh_muc_id');
            $table->foreign('danh_muc_id')->references('id')->on('danh_mucs')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('san_phams');
    }
};
