<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimeclockRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timeclock_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_user_id');
            $table->date('date');
            $table->time('clock_in')->nullable();
            $table->time('clock_out')->nullable();
            $table->time('break_start')->nullable();
            $table->time('break_end')->nullable();
            $table->text('notes')->nullable();
            $table->decimal('total_hours', 5, 2)->nullable();
            $table->timestamps();

            $table->foreign('admin_user_id')->references('id')->on('admin_users')->onDelete('cascade');
            $table->unique(['admin_user_id', 'date']); // Um registro por usuário por dia
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('timeclock_records');
    }
}
