<?php

use Illuminate\Database\Seeder;

class PenjualanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Load the file
        $path = base_path() . '/database/penjualan.json';
        $file = File::get($path);
        $data = json_decode($file, true);

        // Insert into the database
        DB::table('penjualans')->insert($data);

        // Load the file
        $path = base_path() . '/database/detail_penjualan.json';
        $file = File::get($path);
        $data = json_decode($file, true);

        // Insert into the database
        DB::table('detail_penjualans')->insert($data);

        $this->command->info('PenjualanTableSeeder sukses!!!');
    }
}
