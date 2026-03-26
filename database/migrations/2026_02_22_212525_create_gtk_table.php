<?php

use App\Models\Ref\TugasTambahan;
use App\Models\SatuanKerja;
use App\Models\User;
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
        Schema::create('gtk', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(User::class)->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(SatuanKerja::class)->nullable()->constrained()->nullOnDelete();

            $table->string('type'); // Guru / TU

            $table->string('nik')->nullable();
            $table->string('name');
            $table->enum('gender', ['L', 'P'])->nullable();
            $table->string('kawin')->nullable();

            $table->string('rt')->nullable();
            $table->string('rw')->nullable();
            $table->string('dusun')->nullable();
            $table->string('desa')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kabupaten')->nullable();
            $table->string('provinsi')->nullable();

            $table->string('duk')->nullable();
            $table->string('nuptk')->nullable();
            $table->string('nigy')->nullable();

            $table->string('birth_place')->nullable();
            $table->date('birth_date')->nullable();

            $table->date('tmt_yayasan')->nullable();
            $table->date('tmt_satker')->nullable();

            $table->string('photo')->nullable();
            
            //GURU
            $table->string('mapel')->nullable();
            $table->unsignedInteger('mapel_point')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gtk');
    }
};
