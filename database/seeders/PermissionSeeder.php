<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SchemaAudit;
use App\Models\Permission;
use Illuminate\Support\Facades\Log;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener todos los registros de SchemaAudit
        $schemaAudit = SchemaAudit::all();

        $permissions = [];

        // Recorrer cada registro de SchemaAudit y agregar permisos para create, edit, delete
        foreach ($schemaAudit as $audit) {
            $entity = $audit->auditable_type;

            $permissions[] = [
                'name' => $entity . '_index',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $permissions[] = [
                'name' => $entity . '_store',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $permissions[] = [
                'name' => $entity . '_show',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $permissions[] = [
                'name' => $entity . '_update',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $permissions[] = [
                'name' => $entity . '_destroy',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Filtrar los permisos para eliminar duplicados
        $existingPermissions = Permission::pluck('name')->toArray();

        $permissions = array_filter($permissions, function($permission) use ($existingPermissions) {
            return !in_array($permission['name'], $existingPermissions);
        });

        // Insertar los permisos filtrados usando updateOrCreate para evitar duplicados
        try {
            foreach ($permissions as $permission) {
                Permission::updateOrCreate(['name' => $permission['name']], $permission );
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
