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

        $adminUser = DB::table('users')->where('email', 'admin@admin.com')->first();
        $group = DB::table('groups')->where('name', 'Administrator')->first();
        DB::table('users_groups')->insert(array('user_id' => $adminUser->id, 'group_id' => $group->id));
    }
}
