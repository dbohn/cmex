<?php

class UserSeeder extends Seeder {
    public function run()
    {
        DB::table('users')->delete();

        $user = require "users.php";

        foreach($user as $usr)
        {
            DB::table('users')->insert($usr);
        }
    }
}