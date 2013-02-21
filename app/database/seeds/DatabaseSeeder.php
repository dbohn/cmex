<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
        $this->call('ChunkSeeder');

        $this->call('MenuSeeder');

        $this->call('PageSeeder');

        $this->call('UserSeeder');
	}

}