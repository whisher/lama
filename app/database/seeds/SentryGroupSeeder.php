<?php

class SentryGroupSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('groups')->delete();

		Sentry::getGroupProvider()->create(array(
                    'name'        => 'Users',
                    'permissions' => array(
                        'users.store' => 1,
                        'users.show' => 1,
                        'users.account' => 1,
                        'users.password' => 1,
                    )));

		Sentry::getGroupProvider()->create(array(
                    'name'        => 'Admins',
                    'permissions' => array(
                        'users' => 1
                    )));
	}

}