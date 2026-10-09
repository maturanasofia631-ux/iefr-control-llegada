<?php
namespace Database\Seeders;

use App\Models\MoonshineUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RolesAndUsersSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('moonshine_user_roles')->updateOrInsert(['id' => 2], ['name' => 'Coordinador']);
        DB::table('moonshine_user_roles')->updateOrInsert(['id' => 3], ['name' => 'Docente']);
        DB::table('moonshine_user_roles')->updateOrInsert(['id' => 4], ['name' => 'Acudiente']);

        MoonshineUser::query()->updateOrCreate(
            ['email' => 'coordinador@iefr.edu.co'],
            ['name' => 'Coordinador IEFR', 'password' => Hash::make('Coord1234+'), 'moonshine_user_role_id' => 2]
        );

        MoonshineUser::query()->updateOrCreate(
            ['email' => 'docente@iefr.edu.co'],
            ['name' => 'Docente IEFR', 'password' => Hash::make('Docente1234+'), 'moonshine_user_role_id' => 3]
        );
    }
}