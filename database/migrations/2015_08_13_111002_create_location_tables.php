<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('location', function(Blueprint $table)
		{
			$table->increments('id')->unsigned()->unique();
			$table->float('lat');
			$table->float('lon');
			$table->integer('organisation_id')->unsigned();
			$table->boolean('visible')->default(1);		//visible = shown to users
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('organisation_id')
				->references('id')->on('organisations')
				->onDelete('cascade');
		});
		Schema::create('location_tag', function(Blueprint $table)
		{
			$table->integer('location_id')->unsigned();
			$table->string('key');
			$table->string('value');
			$table->enum('populated_by', ['defaults', 'feed', 'manual']);
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('location_id')
				->references('id')->on('location')
				->onDelete('cascade');
			$table->foreign('key')
				->references('key')->on('tag_key')
				->onDelete('restrict');
			$table->primary(['location_id', 'key']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('location_tag');
		Schema::drop('location');
	}

}
