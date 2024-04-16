<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared("
            CREATE OR REPLACE FUNCTION no_updates() RETURNS TRIGGER AS $$
            BEGIN
                RAISE EXCEPTION 'Não é permitido fazer mudanças nesta tabela';
            END;
            $$ LANGUAGE plpgsql;
        ");

        DB::unprepared("
            CREATE TRIGGER trigger_no_updates
            BEFORE UPDATE OR DELETE ON quizzes_snapshots
            FOR EACH ROW
            EXECUTE FUNCTION no_updates();
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trigger_no_updates ON quizzes_snapshots');
        DB::unprepared('DROP FUNCTION IF EXISTS no_updates()');
    }
};
