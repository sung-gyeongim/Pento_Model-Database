<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserProfilesTable extends Migration
{
    /**
     * Run the migrations.
     * Writer           :   Sung GyeongIm
     * Table Name       :   user_profiles
     * Table Explain    :   create user's information manage table
     */
    public function up()
    {
        /*
         CREATE TABLE `user_profiles`
        (
          `user_no` int(10) unsigned NOT NULL COMMENT 'user number',
          `user_point` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'user point',
          `user_grade` int(10) unsigned NOT NULL DEFAULT '1' COMMENT 'user level',
          `user_photo` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'basic_user_photograph.jpg' COMMENT 'user photo file name',
          `user_nickname` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user nickname',
          `user_intro` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'please write your introduce' COMMENT 'user introduce',
          PRIMARY KEY (`user_no`,`user_photo`),
          UNIQUE KEY `user_profiles_user_nickname_unique` (`user_nickname`),
          CONSTRAINT `user_profiles_user_no_foreign` FOREIGN KEY (`user_no`) REFERENCES `user_info` (`user_no`) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
        */

        Schema::create('user_profiles', function (Blueprint $table)
        {
            // columns
            $table->integer('user_no')->unsigned()->comment('user number');
            $table->integer('user_point')->unsigned()->default(0)->comment('user point');
            $table->integer('user_grade')->unsigned()->default(1)->comment('user level');
            $table->string('user_photo',255)->default('basic_user_photograph.jpg')->comment('user photo file name');
            $table->string('user_nickname', 32)->comment('user nickname');
            $table->string('user_intro', 200)->default('please write your introduce')->comment('user introduce');


            // foreign key
            // 회원 테이블의 회원번호 참조
            $table->foreign('user_no')
                ->references('user_no')->on('user_info')
                ->onDelete('cascade')
                ->onUpdate('cascade');


            // primary key
            // 회원번호, 회원 닉네임, 회원 사진 인덱스

            $table->primary(array('user_no', 'user_photo'));
            // unique key
            $table->unique('user_nickname');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {   // DROP TABLE IF EXISTS `user_profiles`;
        Schema::dropIfExists('user_profiles');
    }
}