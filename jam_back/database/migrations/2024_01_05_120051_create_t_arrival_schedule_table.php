<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTArrivalScheduleTable extends Migration
{
    public function up()
    {
        Schema::create('t_arrival_schedule', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('arrival_status_id');
            $table->string('order_number', 50)->nullable();
            $table->string('arrival_schedule_date', 20)->nullable();
            $table->string('arrival_actual_date', 20)->nullable();
            $table->string('comment', 255)->nullable();
            $table->string('canceled_at', 20)->nullable();
            $table->string('canceled_by', 50)->nullable();
            $table->string('created_by', 50);
            $table->timestamps();
            $table->string('updated_by', 50);
            // $table->timestamp('canceled_at')->nullable();
            $table->tinyInteger('is_active')->nullable();
            $table->string('is_active_comment', 255)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('t_arrival_schedule');
    }
}
