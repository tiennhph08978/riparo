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
            $table->string('work_content', 255)->after('work_time');
            $table->unsignedTinyInteger('industry_type')->after('title');
            $table->dropColumn('category_id');
            $table->string('recruitment_quantity', 50)->change();
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
            $table->dropColumn(['industry_type', 'work_content']);
            $table->unsignedBigInteger('category_id')->after('title');
            $table->unsignedInteger('recruitment_quantity')->change();
        });
    }
};
