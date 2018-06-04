<?php

use Illuminate\Database\Seeder;

class SatuanPenjualanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Load the file
        $path = base_path() . '/database/satuan_penjualan.json';
        $file = File::get($path);
        $data = json_decode($file, true);

        // Insert into the database
        DB::table('satuan_penjualans')->insert($data);

        $this->command->info('SatuanPenjualanTableSeeder sukses!!!');
    }
}
