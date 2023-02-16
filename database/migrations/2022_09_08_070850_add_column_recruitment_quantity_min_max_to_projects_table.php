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
            $table->dropColumn('industry_type');
            $table->dropColumn('recruitment_quantity');
            $table->dropColumn('contract_period_reach');
            $table->dropColumn('available_date');
            $table->unsignedInteger('recruitment_quantity_min');
            $table->unsignedInteger('recruitment_quantity_max');
            $table->unsignedBigInteger('m_contact_period_id');
            $table->foreign('m_contact_period_id')->references('id')->on('m_contract_period')
                ->onDelete('cascade');
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
            $table->dropForeign(['m_contact_period_id']);
        });
        Schema::table('projects', function (Blueprint $table) {
            $table->unsignedTinyInteger('industry_type')->after('title');
            $table->unsignedInteger('recruitment_quantity');
            $table->unsignedTinyInteger('contract_period_reach');
            $table->dropColumn('m_contact_period_id');
            $table->dropColumn('recruitment_quantity_min');
            $table->dropColumn('recruitment_quantity_max');
            $table->string('available_date', 255);
        });
    }
};
