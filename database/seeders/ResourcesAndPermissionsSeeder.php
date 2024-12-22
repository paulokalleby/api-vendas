<?php

namespace Database\Seeders;

use App\Models\Resource;
use Illuminate\Database\Seeder;

class ResourcesAndPermissionsSeeder extends Seeder
{
    public function run()
    {

        /**Orders */
        $resource = Resource::create(['name' => 'Pedidos']);

        $resource->permissions()->create([
            'name' => 'Listar',
            'slug' => 'orders.index'
        ]);

        $resource->permissions()->create([
            'name' => 'Ver',
            'slug' => 'orders.show'
        ]);

        $resource->permissions()->create([
            'name' => 'Criar',
            'slug' => 'orders.store'
        ]);

        $resource->permissions()->create([
            'name' => 'Editar',
            'slug' => 'orders.update'
        ]);

        $resource->permissions()->create([
            'name' => 'Excluir',
            'slug' => 'orders.destroy'
        ]);

        /**Customers */
        $resource = Resource::create(['name' => 'Clientes']);

        $resource->permissions()->create([
            'name' => 'Listar',
            'slug' => 'customers.index'
        ]);

        $resource->permissions()->create([
            'name' => 'Ver',
            'slug' => 'customers.show'
        ]);

        $resource->permissions()->create([
            'name' => 'Criar',
            'slug' => 'customers.store'
        ]);

        $resource->permissions()->create([
            'name' => 'Editar',
            'slug' => 'customers.update'
        ]);

        $resource->permissions()->create([
            'name' => 'Excluir',
            'slug' => 'customers.destroy'
        ]);

        /**Catgories */
        $resource = Resource::create(['name' => 'Categorias']);

        $resource->permissions()->create([
            'name' => 'Listar',
            'slug' => 'categories.index'
        ]);

        $resource->permissions()->create([
            'name' => 'Ver',
            'slug' => 'categories.show'
        ]);

        $resource->permissions()->create([
            'name' => 'Criar',
            'slug' => 'categories.store'
        ]);

        $resource->permissions()->create([
            'name' => 'Editar',
            'slug' => 'categories.update'
        ]);

        $resource->permissions()->create([
            'name' => 'Excluir',
            'slug' => 'categories.destroy'
        ]);

        /**Products */
        $resource = Resource::create(['name' => 'Produtos']);

        $resource->permissions()->create([
            'name' => 'Listar',
            'slug' => 'products.index'
        ]);

        $resource->permissions()->create([
            'name' => 'Ver',
            'slug' => 'products.show'
        ]);

        $resource->permissions()->create([
            'name' => 'Criar',
            'slug' => 'products.store'
        ]);

        $resource->permissions()->create([
            'name' => 'Editar',
            'slug' => 'products.update'
        ]);

        $resource->permissions()->create([
            'name' => 'Excluir',
            'slug' => 'products.destroy'
        ]);

        /**Roles */
        $resource = Resource::create(['name' => 'Papéis']);

        $resource->permissions()->create([
            'name' => 'Listar',
            'slug' => 'roles.index'
        ]);

        $resource->permissions()->create([
            'name' => 'Ver',
            'slug' => 'roles.show'
        ]);

        $resource->permissions()->create([
            'name' => 'Criar',
            'slug' => 'roles.store'
        ]);

        $resource->permissions()->create([
            'name' => 'Editar',
            'slug' => 'roles.update'
        ]);

        $resource->permissions()->create([
            'name' => 'Excluir',
            'slug' => 'roles.destroy'
        ]);

        $resource->permissions()->create([
            'name' => 'Permissões',
            'slug' => 'roles.permissions'
        ]);

        /**Users */
        $resource = Resource::create(['name' => 'Usuários']);

        $resource->permissions()->create([
            'name' => 'Listar',
            'slug' => 'users.index'
        ]);

        $resource->permissions()->create([
            'name' => 'Ver',
            'slug' => 'users.show'
        ]);

        $resource->permissions()->create([
            'name' => 'Criar',
            'slug' => 'users.store'
        ]);

        $resource->permissions()->create([
            'name' => 'Editar',
            'slug' => 'users.update'
        ]);

        $resource->permissions()->create([
            'name' => 'Excluir',
            'slug' => 'users.destroy'
        ]);

        /**Manager */
        $resource = Resource::create(['name' => 'Gestão']);

        $resource->permissions()->create([
            'name' => 'Relatórios',
            'slug' => 'reports'
        ]);

        $resource->permissions()->create([
            'name' => 'Configurações',
            'slug' => 'settings'
        ]);
    }
}
