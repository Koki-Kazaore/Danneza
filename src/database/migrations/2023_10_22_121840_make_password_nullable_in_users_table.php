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
        Schema::table('users', function (Blueprint $table) {
            $table->string('password')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // null値を持つpasswordをデフォルト値や空文字に更新
        DB::table('users')->whereNull('password')->update(['password' => '']); 

        Schema::table('users', function (Blueprint $table) {
            // passwordカラムをNOT NULLに戻す
            $table->string('password')->nullable(false)->change();
        });
    }
};
