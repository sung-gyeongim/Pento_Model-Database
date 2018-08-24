<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserInfoTable extends Migration
{
    /**
     * Run the migrations.
     * Writer           : Sung GyeongIm
     * Table Name       : user_info
     * Table Explain    : create user's id, password information manage Table
     */
    public function up()
    {
        /*
        CREATE TABLE `user_info`
        (
          `user_no` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'user table primary key',
          `user_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user ID',
          `user_pw` varchar(200) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user password',
          `registered_date` timestamp NULL DEFAULT NULL COMMENT 'join register date',
          `updated_date` timestamp NULL DEFAULT NULL COMMENT 'last modified date',
          PRIMARY KEY (`user_no`),
          UNIQUE KEY `user_info_user_id_unique` (`user_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
        */

        Schema::create('user_info', function (Blueprint $table)
        {
            // columns
            $table->increments('user_no')->comment('user table primary key');
            $table->string('user_id',20)->comment('user ID');
            $table->string('user_pw', 200)->comment('user password');
            // 암호화를 하면 길이가 188자이기때문에 넉넉하게 200으로 설정
            $table->timestamp('registered_date')->nullable()->comment('join register date');
            $table->timestamp('updated_date')->nullable()->comment('last modified date');

            //unique key
            // 회원 아이디 중복 X
            $table->unique('user_id');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // drop table if exist `user_profiles`;
        Schema::dropIfExists('user_profiles');
        // drop table if exist `user_profiles`;
        Schema::dropIfExists('followlists');
        // drop table if exist `user_profiles`;
        Schema::dropIfExists('pento_designs');
        // drop table if exist `user_profiles`;
        Schema::dropIfExists('imitated_pentos');
        // drop table if exist `user_profiles`;
        Schema::dropIfExists('collections');
        // drop table if exist `user_profiles`;
        Schema::dropIfExists('pento_records');
        // drop table if exist `user_profiles`;
        Schema::dropIfExists('buylists');
        // drop table if exist `user_profiles`;
        Schema::dropIfExists('recommends');
        // drop table if exist `user_info`;
        Schema::dropIfExists('user_info');
    }
}