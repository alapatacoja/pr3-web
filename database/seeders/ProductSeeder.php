<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
    // Bocadillos — IDs 1-8 (según orden en tabla Pedido de FlexSim)
    ['name' => 'Bacon Huevo Patatas',                      'category' => 'bocata',          'price' => 2.80, 'id_item' => 1,  'flexsim_shape' => '/Tools/FlowItemBin/Bocata/Bocata', 'flexsim_spot' => '/Rack1'],
    ['name' => 'Tortilla de patata',                       'category' => 'bocata',          'price' => 1.40, 'id_item' => 2,  'flexsim_shape' => '/Tools/FlowItemBin/Bocata/Bocata', 'flexsim_spot' => '/Rack1'],
    ['name' => 'Vegetal',                                  'category' => 'bocata',          'price' => 2.20, 'id_item' => 3,  'flexsim_shape' => '/Tools/FlowItemBin/Bocata/Bocata', 'flexsim_spot' => '/Rack1'],
    ['name' => 'Frankfurt Patatas',                        'category' => 'bocata',          'price' => 1.50, 'id_item' => 4,  'flexsim_shape' => '/Tools/FlowItemBin/Bocata/Bocata', 'flexsim_spot' => '/Rack1'],
    ['name' => 'Lomo Queso',                               'category' => 'bocata',          'price' => 2.50, 'id_item' => 5,  'flexsim_shape' => '/Tools/FlowItemBin/Bocata/Bocata', 'flexsim_spot' => '/Rack1'],
    ['name' => 'Atún Huevo Tomate',                        'category' => 'bocata',          'price' => 2.20, 'id_item' => 6,  'flexsim_shape' => '/Tools/FlowItemBin/Bocata/Bocata', 'flexsim_spot' => '/Rack1'],
    ['name' => 'Salmon con queso crema y cebolla crujiente','category' => 'bocata_especial', 'price' => 3.80, 'id_item' => 7,  'flexsim_shape' => '/Tools/FlowItemBin/Bocata/Bocata', 'flexsim_spot' => '/Rack1'],
    ['name' => 'Calamares con mayonesa',                   'category' => 'bocata_dia',      'price' => 2.80, 'id_item' => 8,  'flexsim_shape' => '/Tools/FlowItemBin/Bocata/Bocata', 'flexsim_spot' => '/Rack1'],

    // Bollería — IDs 9-12
    ['name' => 'Croissant',                'category' => 'bolleria', 'price' => 0.90, 'id_item' => 9,  'flexsim_shape' => '/Tools/FlowItemBin/Bocata/Bocata', 'flexsim_spot' => '/Rack1'],
    ['name' => 'Napolitana de Cocholate',  'category' => 'bolleria', 'price' => 1.20, 'id_item' => 10, 'flexsim_shape' => '/Tools/FlowItemBin/Bocata/Bocata', 'flexsim_spot' => '/Rack1'],
    ['name' => 'Napolitana Mixta',         'category' => 'bolleria', 'price' => 1.20, 'id_item' => 11, 'flexsim_shape' => '/Tools/FlowItemBin/Bocata/Bocata', 'flexsim_spot' => '/Rack1'],
    ['name' => 'Donut',                    'category' => 'bolleria', 'price' => 0.80, 'id_item' => 12, 'flexsim_shape' => '/Tools/FlowItemBin/Bocata/Bocata', 'flexsim_spot' => '/Rack1'],

    // Cafés — IDs 13-16
    ['name' => 'Café solo',      'category' => 'cafe', 'price' => 1.00, 'id_item' => 13, 'flexsim_shape' => '/Tools/FlowItemBin/cafe/cafe', 'flexsim_spot' => '/MaqCafe'],
    ['name' => 'Café con leche', 'category' => 'cafe', 'price' => 1.30, 'id_item' => 14, 'flexsim_shape' => '/Tools/FlowItemBin/cafe/cafe', 'flexsim_spot' => '/MaqCafe'],
    ['name' => 'Cortado',        'category' => 'cafe', 'price' => 1.20, 'id_item' => 15, 'flexsim_shape' => '/Tools/FlowItemBin/cafe/cafe', 'flexsim_spot' => '/MaqCafe'],
    ['name' => 'Cappuccino',     'category' => 'cafe', 'price' => 1.80, 'id_item' => 16, 'flexsim_shape' => '/Tools/FlowItemBin/cafe/cafe', 'flexsim_spot' => '/MaqCafe'],

    // Bebidas — IDs 17-20
    ['name' => 'Agua',           'category' => 'bebida', 'price' => 0.60, 'id_item' => 17, 'flexsim_shape' => '/Tools/FlowItemBin/Agua/Agua',        'flexsim_spot' => '/MaqBebida'],
    ['name' => 'Refresco',       'category' => 'bebida', 'price' => 1.20, 'id_item' => 18, 'flexsim_shape' => '/Tools/FlowItemBin/lata/lata',         'flexsim_spot' => '/MaqBebida'],
    ['name' => 'Zumo de piña',   'category' => 'bebida', 'price' => 1.50, 'id_item' => 19, 'flexsim_shape' => '/Tools/FlowItemBin/ZumoPiña/ZumoPiña', 'flexsim_spot' => '/MaqBebida'],
    ['name' => 'Zumo de naranja','category' => 'bebida', 'price' => 1.40, 'id_item' => 20, 'flexsim_shape' => '/Tools/FlowItemBin/Zumo/Zumo',         'flexsim_spot' => '/MaqBebida'],

    // Menús — IDs 1-4 (tabla Menu separada en FlexSim)
    ['name' => 'Menú completo',    'category' => 'menu_completo',    'price' => 5.90, 'id_item' => 1, 'flexsim_shape' => '/Tools/FlowItemBin/Menu/Menu',          'flexsim_spot' => null],
    ['name' => 'Medio menú',       'category' => 'menu_medio',       'price' => 4.20, 'id_item' => 2, 'flexsim_shape' => '/Tools/FlowItemBin/medioMenu/medioMenu', 'flexsim_spot' => null],
    ['name' => 'Menú vegetariano', 'category' => 'menu_vegetariano', 'price' => 5.90, 'id_item' => 3, 'flexsim_shape' => '/Tools/FlowItemBin/eg/MenuVeg',          'flexsim_spot' => null],
    ['name' => 'Menú saludable',   'category' => 'menu_saludable',   'price' => 5.90, 'id_item' => 4, 'flexsim_shape' => '/Tools/FlowItemBin/eg/MenuVeg',          'flexsim_spot' => null],
];

foreach ($products as $p) {
    Product::create(array_merge($p, ['available' => true]));
}


    }
}