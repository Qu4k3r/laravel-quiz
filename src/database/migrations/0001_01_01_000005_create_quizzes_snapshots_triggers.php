<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (App::environment('testing')) {
            DB::unprepared('
            CREATE TRIGGER trigger_no_updates
            BEFORE UPDATE ON quizzes_snapshots
            BEGIN
                SELECT RAISE(FAIL, "Não é permitido fazer mudanças nesta tabela");
            END;
        ');

            DB::unprepared('
            CREATE TRIGGER trigger_no_delete
            BEFORE DELETE ON quizzes_snapshots
            BEGIN
                SELECT RAISE(FAIL, "Não é permitido fazer mudanças nesta tabela");
            END;
        ');
            return;
        }

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
        if (App::environment('testing')) {
            DB::unprepared('DROP TRIGGER IF EXISTS trigger_no_updates');

            DB::unprepared('DROP TRIGGER IF EXISTS trigger_no_delete');
            return;
        }

        DB::unprepared('DROP TRIGGER IF EXISTS trigger_no_updates ON quizzes_snapshots');
        DB::unprepared('DROP FUNCTION IF EXISTS no_updates()');
    }
};
