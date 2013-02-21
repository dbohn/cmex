<?php

class MenuSeeder extends Seeder {
    public function run()
    {
        DB::table('menu')->delete();

        $menu = require "menu.php";

        foreach($menu as $men)
        {
            DB::table('menu')->insert($men);
        }
    }
}