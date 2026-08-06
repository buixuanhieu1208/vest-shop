<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('danh_gias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('san_pham_id');
            $table->unsignedTinyInteger('so_sao'); // 1 - 5
            $table->text('noi_dung')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('san_pham_id')->references('id')->on('san_phams')->onDelete('cascade');

            // Mỗi người chỉ đánh giá 1 lần cho 1 sản phẩm (đánh giá lại sẽ cập nhật đè)
            $table->unique(['user_id', 'san_pham_id']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('danh_gias');
    }
};