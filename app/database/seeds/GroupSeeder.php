<?php

class GroupSeeder extends Seeder
{
    public function run()
    {
        DB::table('groups')->delete();

        $user = require "groups.php";

        foreach ($user as $usr) {
            DB::table('groups')->insert($usr);
        }
    }
}
