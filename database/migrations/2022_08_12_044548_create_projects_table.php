<?php

use App\Models\Project;
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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('title', 50);
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('city_id');
            $table->string('address', 32);
            $table->unsignedTinyInteger('contract_period_reach');
            $table->unsignedInteger('recruitment_quantity');
            $table->unsignedInteger('recruitment_number');
            $table->string('work_time', 255);
            $table->text('work_desc');
            $table->text('special');
            $table->text('business_development_incorporation');
            $table->text('employment_incorporation');
            $table->string('available_date', 255);
            $table->unsignedTinyInteger('status')->default(Project::STATUS_PENDING);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
};
