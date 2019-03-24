<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dato = new User();
        $dato->name="Mauro Tello";
        $dato->username="desarrollostello";
        $dato->email="maurotello73@gmail.com";
        $dato->password=bcrypt('mtello1234');
        $dato->estado=1;
        $dato->save();
    }
}
