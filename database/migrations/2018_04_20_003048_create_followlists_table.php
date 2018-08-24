<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFollowlistsTable extends Migration
{
    /**
     * Run the migrations.
     * Writer           :   Sung GyeongIm
     * Table Name       :   followlists
     * Table Explain    :   create user follow relation information manage table
     */
    public function up()
    {
       /*
       CREATE TABLE `followlists`
       (
          `follow_user_no` int(10) unsigned NOT NULL COMMENT 'follow user number',
          `follower_user_no` int(10) unsigned NOT NULL COMMENT 'follower user number',
          `registered_date` timestamp NULL DEFAULT NULL COMMENT 'register date',
          PRIMARY KEY (`follow_user_no`,`follower_user_no`),
          KEY `followlists_follower_user_no_foreign` (`follower_user_no`),
          CONSTRAINT `followlists_follow_user_no_foreign` FOREIGN KEY (`follow_user_no`) REFERENCES `user_info` (`user_no`) ON DELETE CASCADE ON UPDATE CASCADE,
          CONSTRAINT `followlists_follower_user_no_foreign` FOREIGN KEY (`follower_user_no`) REFERENCES `user_info` (`user_no`) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
       */

        Schema::create('followlists', function (Blueprint $table)
        {
            // colums
            $table->integer('follow_user_no')->unsigned()->comment('follow user number');
            $table->integer('follower_user_no')->unsigned()->comment('follower user number');
            $table->timestamp('registered_date')->nullable ()->comment('register date');

            // foreign keys
            // 회원테이블의 회원번호 참조
            // 없는 회원번호가 들어가면 안되기 때문에 외래키 제약조건
            $table->foreign('follow_user_no')
                ->references('user_no')->on('user_info')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('follower_user_no')
                ->references('user_no')->on('user_info')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            // 인덱스 설정
            $table->primary(array('follow_user_no', 'follower_user_no'));

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // DROP TABLE IF EXISTS `followlists`;
        Schema::dropIfExists('followlists');
    }
}