<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE peminjamans
            DROP CONSTRAINT IF EXISTS peminjamans_status_check
        ");

        DB::statement("
            ALTER TABLE peminjamans
            ALTER COLUMN status TYPE VARCHAR(255)
        ");

        DB::statement("
            ALTER TABLE peminjamans
            ADD CONSTRAINT peminjamans_status_check
            CHECK (status IN (
                'menunggu',
                'disetujui',
                'ditolak',
                'dikembalikan'
            ))
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE peminjamans
            DROP CONSTRAINT IF EXISTS peminjamans_status_check
        ");

        DB::statement("
            ALTER TABLE peminjamans
            ADD CONSTRAINT peminjamans_status_check
            CHECK (status IN (
                'menunggu',
                'disetujui',
                'ditolak'
            ))
        ");
    }
};
