<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTableSeeder::class);
        $this->call(JenisProdukTableSeeder::class);
        $this->call(SatuanPenjualanTableSeeder::class);
        $this->call(SatuanPembelianTableSeeder::class);
        $this->call(VendorTableSeeder::class);
        $this->call(ProdukTableSeeder::class);
        $this->call(RakTableSeeder::class);
        $this->call(PersediaanTableSeeder::class);
        $this->call(PenjualanTableSeeder::class);

        $this->command->info('Sukses Semua, Ntap Cuy!!!');
    }
}
