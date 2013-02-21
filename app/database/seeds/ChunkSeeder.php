<?php

class ChunkSeeder extends Seeder {
    public function run()
    {
        DB::table('chunks')->delete();

        $chunks = require "chunks.php";

        foreach($chunks as $chunk)
        {
            DB::table('chunks')->insert($chunk);
        }
    }
}