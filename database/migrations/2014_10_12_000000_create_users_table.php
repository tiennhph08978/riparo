<?php

use App\Models\User;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 16);
            $table->string('last_name', 16);
            $table->string('first_name_furigana', 24);
            $table->string('last_name_furigana', 24);
            $table->string('email', 64)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 255);
            $table->string('phone_number', 11);
            $table->string('post_code', 7);
            $table->unsignedSmallInteger('city');
            $table->string('street', 32);
            $table->string('address', 32);
            $table->string('token', 64)->nullable();
            $table->text('desc')->nullable();
            $table->unsignedTinyInteger('status')->default(User::STATUS_INACTIVATED);

            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
