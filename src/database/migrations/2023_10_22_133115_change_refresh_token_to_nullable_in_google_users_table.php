<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('google_users', function (Blueprint $table) {
            $table->text('refresh_token')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // null値を持つrefresh_tokenをデフォルト値や空文字に更新
        DB::table('google_users')->whereNull('refresh_token')->update(['refresh_token' => '']);

        Schema::table('google_users', function (Blueprint $table) {
            $table->text('refresh_token')->nullable(false)->change();
        });
    }
};
