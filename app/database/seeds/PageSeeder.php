<?php

class PageSeeder extends Seeder {
    public function run()
    {
        DB::table('page')->delete();

        $page = require "page.php";

        foreach($page as $pag)
        {
            DB::table('page')->insert($pag);
        }
    }
}