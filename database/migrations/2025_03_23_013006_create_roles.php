<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
      $role1 = Role::create(['name' => 'admin']);
      $role2 = Role::create(['name' => 'cliente']);

      DB::table('model_has_roles')->insert([
        'role_id' => '1',
        'model_type' => 'App\Models\User',
        'model_id' => '1'
    ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
    }
};
