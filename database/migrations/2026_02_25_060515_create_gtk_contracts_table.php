<?php

use App\Models\Gtk;
use App\Models\SatuanKerja;
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
        Schema::create('gtk_contracts', function (Blueprint $table) {
            $table->id();

            $table->string('type');

            $table->foreignIdFor(Gtk::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(SatuanKerja::class)->constrained()->cascadeOnDelete();

            $table->string('reference_number'); // Nomor SK
            $table->date('issued_date');                 // Tanggal SK
            $table->date('effective_date');              // TMT (Terhitung Mulai Tanggal)
            $table->date('expired_date')->nullable(); // Tanggal Selesai SK

            //GURU
            $table->string('mapel')->nullable();
            $table->unsignedInteger('mapel_point')->nullable();

            //Tugas Tambahan
            $table->string('secondary_job')->nullable();
            $table->unsignedInteger('secondary_job_point')->nullable();

            $table->string('file')->nullable();
            $table->boolean('is_primary')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gtk_contracts');
    }
};
