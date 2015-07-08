<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::unprepared('DROP INDEX users_email_unique ON users;');

		Schema::table('users', function($table)
		{
			$table->string('name_first');
			$table->string('name_full');
			$table->string('avatar_url');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::unprepared('CREATE UNIQUE INDEX `email` ON users;');
		Schema::table('users', function($table)
		{
			$table->dropColumn('name_first');
			$table->dropColumn('name_full');
			$table->dropColumn('avatar_url');
		});
	}

}
