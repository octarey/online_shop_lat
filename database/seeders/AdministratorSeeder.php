<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $administrator = new \App\Models\User;
        $administrator->username = "administrator";
        $administrator->name = "Site Administrator";
        $administrator->email = "administrator@ashashop.test";
        $administrator->roles = json_encode(['ADMIN']);
        $administrator->password = \Hash::make("larashop");
        $administrator->avatar ="unknown";
        $administrator->address ="majang tengah, Dampit , Malang";

        $administrator->save();

        $this->command->info("User Admin berhasil diinsert");
    }
}
