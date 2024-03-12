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
        Schema::table('users', function (Blueprint $table) {
            $table->tinyInteger('status')->default(1)->after('visible_password');
            $table->tinyInteger('password_created_by_admin')->default(0)->after('status');
            $table->tinyInteger('is_email_varify')->default(0)->after('password_created_by_admin');
            $table->text('profile_pic')->nullable()->after('password_created_by_admin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('password_created_by_admin');
            $table->dropColumn('is_email_varify');
            $table->dropColumn('profile_pic');
        });
    }
};
