<?php

use Illuminate\Database\Seeder;

class JenisProdukTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Load the file
        $path = base_path() . '/database/jenis_produk.json';
        $file = File::get($path);
        $data = json_decode($file, true);

        // Insert into the database
        DB::table('jenis_produks')->insert($data);

        $this->command->info('JenisProdukTableSeeder sukses!!!');
    }
}
