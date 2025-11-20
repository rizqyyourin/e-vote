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
            // Drop the old unique constraint
            $table->dropUnique(['email']);
        });

        // Create a new unique index that ignores soft-deleted records
        // For SQLite, we'll use a raw index that includes the deleted_at condition
        DB::statement(
            'CREATE UNIQUE INDEX users_email_unique ON users(email) WHERE deleted_at IS NULL'
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP INDEX users_email_unique');

        Schema::table('users', function (Blueprint $table) {
            $table->unique('email');
        });
    }
};
