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
        Schema::table('perlombaans', function (Blueprint $table) {
            $table->foreignId('created_by')->nullable()->after('id')->constrained('users')->nullOnDelete();
            $table->string('slug')->nullable()->unique()->after('nama_lomba');
            $table->enum('status', ['draft', 'published', 'registration_open', 'ongoing', 'judging', 'finished'])->default('draft')->after('deskripsi');
            $table->timestamp('registration_start_at')->nullable()->after('status');
            $table->timestamp('registration_end_at')->nullable()->after('registration_start_at');
            $table->timestamp('submission_deadline_at')->nullable()->after('registration_end_at');
            $table->timestamp('announcement_at')->nullable()->after('submission_deadline_at');
            $table->unsignedInteger('max_participants')->nullable()->after('announcement_at');
        });

        Schema::table('kriterias', function (Blueprint $table) {
            $table->text('deskripsi')->nullable()->after('nama_kriteria');
            $table->unsignedSmallInteger('urutan')->default(1)->after('bobot');
        });

        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->enum('status', ['registered', 'submitted', 'reviewed', 'disqualified'])->default('registered')->after('perlombaan_id');
            $table->string('submission_title')->nullable()->after('status');
            $table->text('submission_notes')->nullable()->after('submission_title');
            $table->timestamp('submitted_at')->nullable()->after('file_hasil');
            $table->decimal('final_score', 8, 2)->nullable()->after('submitted_at');
            $table->unique(['user_id', 'perlombaan_id']);
        });

        Schema::table('penilaians', function (Blueprint $table) {
            $table->text('catatan')->nullable()->after('skor');
            $table->unique(['pendaftaran_id', 'user_id', 'kriteria_id'], 'penilaians_unique_juri_score');
        });

        Schema::create('juri_perlombaan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('perlombaan_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['user_id', 'perlombaan_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('juri_perlombaan');

        Schema::table('penilaians', function (Blueprint $table) {
            $table->dropUnique('penilaians_unique_juri_score');
            $table->dropColumn('catatan');
        });

        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->dropUnique(['user_id', 'perlombaan_id']);
            $table->dropColumn([
                'status',
                'submission_title',
                'submission_notes',
                'submitted_at',
                'final_score',
            ]);
        });

        Schema::table('kriterias', function (Blueprint $table) {
            $table->dropColumn(['deskripsi', 'urutan']);
        });

        Schema::table('perlombaans', function (Blueprint $table) {
            $table->dropConstrainedForeignId('created_by');
            $table->dropColumn([
                'slug',
                'status',
                'registration_start_at',
                'registration_end_at',
                'submission_deadline_at',
                'announcement_at',
                'max_participants',
            ]);
        });
    }
};
