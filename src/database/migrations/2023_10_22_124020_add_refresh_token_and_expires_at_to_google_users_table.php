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
        Schema::table('google_users', function (Blueprint $table) {
            $table->string('refresh_token')->after('token'); // tokenカラムの直後に追加
            $table->timestamp('expires_at')->nullable(); // 有効期限。nullを許容。
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('google_users', function (Blueprint $table) {
            $table->dropColumn('refresh_token');
            $table->dropColumn('expires_at');
        });
    }
};
