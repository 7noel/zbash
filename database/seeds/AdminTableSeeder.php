<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\User;
//use App\Modules\Base\Table;
use App\Role;
use App\PermissionGroup;
use App\Permission;

use Faker\Factory as Faker;

class AdminTableSeeder extends Seeder {

    public function run()
    {

        Role::create(['name' => 'ADMINISTRADOR']);
        Role::create(['name' => 'VENDEDOR']);
        Role::create(['name' => 'ALMACEN']);
        Role::create(['name' => 'FACTURADOR']);

        User::create(['name' => 'Noel', 'email' => 'noel.logan@gmail.com', 'password' => '123']);
    }
}