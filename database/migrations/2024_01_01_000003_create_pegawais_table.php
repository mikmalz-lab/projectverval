<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('pegawais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('opd_id')->nullable()->constrained('opds')->onDelete('set null');
            $table->string('nip')->unique()->nullable();
            $table->string('nama_lengkap');
            $table->string('jabatan')->nullable();
            $table->string('golongan')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('status_verval')->default('draft'); // draft, submitted, revision_required_opd, approved_opd, revision_required_bkd, final_approved, final_rejected
            $table->text('catatan_final')->nullable();
            $table->timestamp('finalized_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pegawais');
    }
};
