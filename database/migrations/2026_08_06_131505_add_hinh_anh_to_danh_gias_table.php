<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('danh_gias', function (Blueprint $table) {
            // Thêm cột hinh_anh kiểu JSON để lưu danh sách tên file ảnh
            $table->json('hinh_anh')->nullable()->after('noi_dung');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('danh_gias', function (Blueprint $table) {
            //
        });
    }
};
