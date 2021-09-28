<?php

use Illuminate\Database\Seeder;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $user = User::updateOrCreate([
        'name' => 'Elvin Lari',
        'username' => 'elvlar',
        'email' => 'elvintitus1@gmail.com',
        'phone' => '254712437262',
        'client_id' => '1',
        'password' => '$2y$10$OJuE.k4gEdLqSx68qjohwOcDVcEuV.Vqn.TkzROO6wz0N2V.VwLhe',
        'timezone' => 'Africa/Nairobi',
        'created_at' => '2020-06-28 21:15:48',
        'updated_at' => '2020-06-28 21:15:48',
      ]);

      // $user = User::where('email','elvintitus1@gmail.com')->first();

      $role = Role::create(['name' => 'super-admin']);
       Role::create(['name' => 'user']);
      $permissions = Permission::pluck('id','id')->all();
      $role->syncPermissions($permissions);
      $user->assignRole([$role->id]);
    }
}
