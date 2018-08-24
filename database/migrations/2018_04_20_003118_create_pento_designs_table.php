<?php


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePentoDesignsTable extends Migration
{
    /**
     * Run the migrations.
     * Writer           :   Sung GyeongIm
     * Table Name       :   pento_designs
     * Table Explain    :   create pentomino design's information manage table
     */

    public function up()
    {
        /*
         CREATE TABLE `pento_designs`
        (
          `design_no` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'design table primary key',
          `user_no` int(10) unsigned NOT NULL COMMENT 'design number',
          `reward_point` int(10) unsigned NOT NULL COMMENT 'reward point',
          `identifier` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT 'game mode identifier',
          `design_title` varchar(40) COLLATE utf8_unicode_ci NOT NULL COMMENT 'design title',
          `design_explain` varchar(200) COLLATE utf8_unicode_ci NOT NULL COMMENT 'design explain',
          `coordinate_value` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'coordinate value',
          `design_image` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'design image file name',
          `registered_date` timestamp NULL DEFAULT NULL COMMENT 'register date',
          `updated_date` timestamp NULL DEFAULT NULL COMMENT 'last modify date',
          PRIMARY KEY (`design_no`),
          UNIQUE KEY `pento_designs_coordinate_value_unique` (`coordinate_value`),
          UNIQUE KEY `pento_designs_design_image_unique` (`design_image`),
          KEY `pento_designs_user_no_identifier_index` (`user_no`,`identifier`),
          CONSTRAINT `pento_designs_user_no_foreign` FOREIGN KEY (`user_no`) REFERENCES `user_info` (`user_no`) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
         */

        Schema::create('pento_designs', function (Blueprint $table)
        {
            //columns
            $table->increments('design_no')->unsigned()->comment('design table primary key');
            $table->integer('user_no')->unsigned()->comment('design number');
            $table->integer('reward_point')->unsigned()->comment('reward point');
            $table->string('identifier', 20)->comment('game mode identifier');
            $table->string('design_title', 40)->comment('design title');
            $table->string('design_explain', 200)->comment('design explain');
            $table->string('coordinate_value',255)->comment('coordinate value');
            $table->string('design_image', 255)->comment('design image file name');
            $table->timestamp('registered_date')->nullable()->comment('register date');
            $table->timestamp('updated_date')->nullable()->comment('last modify date');

            // foreign Key
            $table->foreign('user_no')
                ->references('user_no')->on('user_info')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            // unique key
            $table->unique('coordinate_value');
            $table->unique('design_image');

            // index key
            $table->index(array('user_no', 'identifier'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        // DROP TABLE IF EXISTS `collections`;
        Schema::dropIfExists('collections');
        // DROP TABLE IF EXISTS `pento_records`;
        Schema::dropIfExists('pento_records');
        // DROP TABLE IF EXISTS `pento_designs`;
        Schema::dropIfExists('pento_designs');

    }
}