<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    $products = [
            // Bocadillos
            ['name' => 'Bacon Huevo Patatas',         'category' => 'bocata',           'price' => 2.50],
            ['name' => 'Tortilla de patata',          'category' => 'bocata',           'price' => 3.00],
            ['name' => 'Vegetal',                     'category' => 'bocata',           'price' => 2.80],
            ['name' => 'Frankfurt Patatas',         'category' => 'bocata',           'price' => 1.50],
            ['name' => 'Lomo Queso',          'category' => 'bocata',           'price' => 3.00],
            ['name' => 'Atún Huevo Tomate',           'category' => 'bocata',           'price' => 2.80],
            ['name' => 'Salmon con queso crema y cebolla crujiente',       'category' => 'bocata_especial',  'price' => 3.80],
            ['name' => 'Calamares con mayonesa',        'category' => 'bocata_dia',       'price' => 2.80],

            // Bollería
            ['name' => 'Croissant',             'category' => 'bolleria',         'price' => 1.20],
            ['name' => 'Napolitana de Cocholate',            'category' => 'bolleria',         'price' => 1.20],
            ['name' => 'Napolitana Mixta',            'category' => 'bolleria',         'price' => 1.20],
            ['name' => 'Donut',                 'category' => 'bolleria',         'price' => 0.80],

            // Cafés
            ['name' => 'Café solo',             'category' => 'cafe',             'price' => 1.00],
            ['name' => 'Café con leche',        'category' => 'cafe',             'price' => 1.30],
            ['name' => 'Cortado',               'category' => 'cafe',             'price' => 1.20],
            ['name' => 'Cappuccino',            'category' => 'cafe',             'price' => 1.80],

            // Bebidas frías
            ['name' => 'Agua',                  'category' => 'bebida',           'price' => 0.80],
            ['name' => 'Refresco',              'category' => 'bebida',           'price' => 1.20],
            ['name' => 'Zumo de piña',          'category' => 'bebida',           'price' => 2.00],
            ['name' => 'Zumo de naranja',          'category' => 'bebida',           'price' => 2.00],

            // Menús
            ['name' => 'Menú completo',         'category' => 'menu_completo',    'price' => 5.90],
            ['name' => 'Medio menú',            'category' => 'menu_medio',       'price' => 4.20],
            ['name' => 'Menú vegetariano',      'category' => 'menu_vegetariano', 'price' => 5.90],
            ['name' => 'Menú saludable',        'category' => 'menu_saludable',   'price' => 5.90],
        ];

        foreach ($products as $p) {
            \App\Models\Product::create(array_merge($p, ['available' => true]));
        }
    }
}
