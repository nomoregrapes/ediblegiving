<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		$this->call('OrganisationTableSeeder');
		$this->call('UserTableSeeder');
	}

}

class OrganisationTableSeeder extends Seeder {
	public function run()
	{
		//DB::table('organisations')->delete();
		$id = DB::table('organisations')->insertGetId(
			['name' => 'Super cafes',
			'slug' => 'testing-super-cafes',
			'description' => 'Locations of super cafes',
			'admin_note' => 'Test'
			]);
		$id = DB::table('organisations')->insertGetId(
			['name' => 'Homeless shelters',
			'slug' => 'testing-homeless',
			'description' => 'Homeless shelters that accept food donations.',
			'admin_note' => 'Test'
			]);
	}
}

class UserTableSeeder extends Seeder {
	public function run()
	{
		 DB::table('users')->insertGetId([
		 	'username' => 'albert',
		 	'email' => 'albert@bar.com',
		 ]);
		 DB::table('users')->insertGetId([
		 	'username' => 'bob',
		 	'email' => 'bob@bar.com',
		 ]);
		 DB::table('users')->insertGetId([
		 	'username' => 'charles',
		 	'email' => 'charles@bar.com',
		 ]);
		 DB::table('users')->insertGetId([
		 	'username' => 'donald',
		 	'email' => 'donald@bar.com',
		 ]);
		 DB::table('users')->insertGetId([
		 	'username' => 'egbert',
		 	'email' => 'egbert@bar.com',
		 ]);
		 DB::table('users')->insertGetId([
		 	'username' => 'fred',
		 	'email' => 'fred@bar.com',
		 ]);
	}
}
