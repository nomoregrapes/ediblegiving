<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tag_key', function(Blueprint $table)
		{
			$table->increments('id')->unsigned()->unique();
			$table->string('key')->unique();
			$table->string('label')->nullable();
			$table->string('value_type')->default('text');
			$table->text('description')->nullable();
			$table->boolean('visible')->default(1);		//visible = shown to users as info of the location, not just used for filtering
			$table->boolean('exported')->default(1);	//exported = included in exports, not system-use only
			$table->boolean('restricted')->default(0);	//restricted = only EG admin can add/edit the value
		});
		DB::table('tag_key')->insert(array(
			array('key' => 'name', 'label' => 'Name', 'value_type' => 'text', 'description' => 'The name of the lcoation', 'visible'=>1, 'exported'=>1, 'restricted'=>0),
			array('key' => 'activity_office', 'label' => 'Office', 'value_type' => 'boolean', 'description' => 'The location is used as an admin office', 'visible'=>0, 'exported'=>1, 'restricted'=>0),
			array('key' => 'activity_donation', 'label' => 'Donation point', 'value_type' => 'boolean', 'description' => 'Donations be made at this location', 'visible'=>0, 'exported'=>1, 'restricted'=>0),
			array('key' => 'activity_volunteering', 'label' => 'Volunteering location', 'value_type' => 'boolean', 'description' => 'People can volunteer at this location', 'visible'=>0, 'exported'=>1, 'restricted'=>0),
			array('key' => 'activity_distribution', 'label' => 'Distribution point', 'value_type' => 'boolean', 'description' => 'Food is disributed out at this point', 'visible'=>0, 'exported'=>1, 'restricted'=>0),
			array('key' => 'food_type_unopened', 'label' => 'Unopened food accepted', 'value_type' => 'boolean', 'description' => 'Unopened food is accepted', 'visible'=>1, 'exported'=>1, 'restricted'=>0),
			array('key' => 'food_type_fresh', 'label' => 'Fresh food accepted', 'value_type' => 'boolean', 'description' => 'Fresh food is accepted', 'visible'=>1, 'exported'=>1, 'restricted'=>0),
			array('key' => 'food_type_meat', 'label' => 'Meat accepted', 'value_type' => 'boolean', 'description' => 'Food containing meat is accepted', 'visible'=>1, 'exported'=>1, 'restricted'=>0),
			array('key' => 'postal_address', 'label' => 'Postal address', 'value_type' => 'text', 'description' => 'The postal address of the location', 'visible'=>1, 'exported'=>1, 'restricted'=>0),
			array('key' => 'telephone', 'label' => 'Telephone number', 'value_type' => 'telephone', 'description' => 'A telephone number to contact staff about this location', 'visible'=>1, 'exported'=>1, 'restricted'=>0),
			array('key' => 'website', 'label' => 'Website', 'value_type' => 'website', 'description' => 'A website address to find out more about this location', 'visible'=>1, 'exported'=>1, 'restricted'=>0),
			array('key' => 'opening_times', 'label' => 'Opening times', 'value_type' => 'text', 'description' => 'When this location is open', 'visible'=>1, 'exported'=>1, 'restricted'=>0),
			array('key' => 'source', 'label' => 'Data source', 'value_type' => 'text', 'description' => 'Source of the information about this location', 'visible'=>0, 'exported'=>1, 'restricted'=>0),
		));

		Schema::create('organisation_tag_defaults', function(Blueprint $table)
		{
			$table->increments('id')->unsigned()->unique();
			$table->integer('organisation_id')->unsigned();
			$table->string('key');
			$table->string('value');
			$table->timestamps();
			$table->foreign('organisation_id')
				->references('id')->on('organisations')
				->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('organisation_tag_defaults');
		Schema::drop('tag_key');
	}

}
