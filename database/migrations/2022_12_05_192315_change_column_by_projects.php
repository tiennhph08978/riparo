<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->text('work_desc')->nullable()->change();
            $table->text('special')->nullable()->change();
            $table->text('business_development_incorporation')->nullable()->change();
            $table->text('employment_incorporation')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->text('work_desc')->change();
            $table->text('special')->change();
            $table->text('business_development_incorporation')->change();
            $table->text('employment_incorporation')->change();
        });
    }
};
