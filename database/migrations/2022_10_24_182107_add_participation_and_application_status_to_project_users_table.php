<?php

use App\Models\ProjectUser;
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
        Schema::table('project_users', function (Blueprint $table) {
            $table->unsignedTinyInteger('participation_status')->default(ProjectUser::PARTICIPATION_STATUS_CONTACT);
            $table->unsignedTinyInteger('application_status')->default(ProjectUser::APPLICATION_STATUS_2_INTERVIEW);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_users', function (Blueprint $table) {
            $table->dropColumn(['participation_status', 'application_status']);
        });
    }
};
