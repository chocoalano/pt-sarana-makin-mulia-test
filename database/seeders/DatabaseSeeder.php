<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'permission-list',
            'permission-create',
            'permission-edit',
            'permission-delete',
            'barang-list',
            'barang-create',
            'barang-edit',
            'barang-delete',
            'permintaan_barang-list',
            'permintaan_barang-create',
            'permintaan_barang-edit',
            'permintaan_barang-delete',
         ];
    
         foreach ($permissions as $permission) {
              Permission::create(['name' => $permission]);
         }
 
         $user = User::create([
             'nik' => $this->generateUniqueCode(), 
             'name' => 'Administrator', 
             'email' => 'admin@example.com',
             'password' => bcrypt('123456')
         ]);
         $role = Role::create(['name' => 'Administrator']);
         $permissions = Permission::pluck('id','id')->all();
         $role->syncPermissions($permissions);
         $user->assignRole([$role->id]);


         $barang=[];
         for ($i=0; $i < 10; $i++) { 
             $numbers = Barang::selectRaw('LPAD(CONVERT(COUNT("id") + '.$i.', char(8)) , 8,"0") as numbers')->first();
             array_push($barang, [
                'kode'=>'ATK' . $numbers->numbers,
                'name'=>Str::random(10),
                'lokasi'=>Str::random(10),
                'stok'=>random_int(10, 99),
                'satuan'=>'pak',
             ]);
         }
         Barang::insert($barang);
    }

    public function generateUniqueCode()
    {
        do {
            $code = random_int(100, 999).'.'.random_int(100, 999).'.'.random_int(10000, 99999);
        } while (Barang::where("kode", "=", $code)->first());
        return $code;
    }
}
