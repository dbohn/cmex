<?php

class DatabaseSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        $this->call('ChunkSeeder');

        $this->call('MenuSeeder');

        $this->call('PageSeeder');

        $this->call('UserSeeder');

        $this->call('GroupSeeder');

        // $this->call('UserTableSeeder');
    }
}
