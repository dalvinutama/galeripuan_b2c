<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('messages', 'is_delivered')) {
            Schema::table('messages', function (Blueprint $table) {
                $table->boolean('is_delivered')->default(false)->after('is_read');
            });
            DB::table('messages')->whereNull('is_delivered')->update(['is_delivered' => false]);
        }

        if (!Schema::hasColumn('admins', 'last_activity')) {
            Schema::table('admins', function (Blueprint $table) {
                $table->timestamp('last_activity')->nullable()->after('updated_at');
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('messages', 'is_delivered')) {
            Schema::table('messages', function (Blueprint $table) {
                $table->dropColumn('is_delivered');
            });
        }
        if (Schema::hasColumn('admins', 'last_activity')) {
            Schema::table('admins', function (Blueprint $table) {
                $table->dropColumn('last_activity');
            });
        }
    }
};
