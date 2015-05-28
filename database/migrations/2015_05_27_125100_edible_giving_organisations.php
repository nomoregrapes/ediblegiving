<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EdibleGivingOrganisations extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('organisations', function(Blueprint $table)
		{
            $table->increments('id');
			$table->string('name');
			$table->string('slug')->index()->unique();
			$table->string('description')->nullable();
			$table->string('admin_note')->nullable();
            $table->timestamps();
		});

		Schema::table('role_user', function($table)
		{
			$table->integer('organisation_id')->unsigned()->nullable();
            $table->foreign('organisation_id')->references('id')->on('organisations')
                ->onUpdate('cascade')->onDelete('cascade');

			//$table->dropPrimary('role_user_user_id_role_id_primary');
			//$table->primary(['user_id', 'role_id', 'organisation_id']);
		});
		DB::unprepared('ALTER TABLE `role_user` DROP PRIMARY KEY, ADD UNIQUE (`user_id`, `role_id`, `organisation_id`);');

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::unprepared('ALTER TABLE `role_user` DROP PRIMARY KEY');
		Schema::table('role_user', function($table)
		{
            //$table->dropPrimary('role_user_id_primary');
            $table->primary(['user_id', 'role_id']);
			$table->dropColumn('organisation_id');
		});

		Schema::drop('organisations');
	}

}
