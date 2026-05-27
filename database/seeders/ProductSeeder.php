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
    ['name' => 'Bocata mixto',       'category' => 'bocata',          'price' => 2.50, 'flexsim_shape' => '/Tools/FlowItemBin/Bocata/Bocata',       'flexsim_spot' => '/Rack1'],
    ['name' => 'Bocata jamón',       'category' => 'bocata',          'price' => 3.00, 'flexsim_shape' => '/Tools/FlowItemBin/Bocata/Bocata',       'flexsim_spot' => '/Rack1'],
    ['name' => 'Bocata atún',        'category' => 'bocata',          'price' => 2.80, 'flexsim_shape' => '/Tools/FlowItemBin/Bocata/Bocata',       'flexsim_spot' => '/Rack1'],
    ['name' => 'Bocata especial',    'category' => 'bocata_especial', 'price' => 4.50, 'flexsim_shape' => '/Tools/FlowItemBin/Bocata/Bocata',       'flexsim_spot' => '/Rack1'],
    ['name' => 'Bocata del día',     'category' => 'bocata_dia',      'price' => 3.50, 'flexsim_shape' => '/Tools/FlowItemBin/Bocata/Bocata',       'flexsim_spot' => '/Rack1'],

    // Bollería — añade tu shape cuando la tengas
    ['name' => 'Croissant',          'category' => 'bolleria',        'price' => 1.20, 'flexsim_shape' => null, 'flexsim_spot' => null],
    ['name' => 'Napolitana',         'category' => 'bolleria',        'price' => 1.50, 'flexsim_shape' => null, 'flexsim_spot' => null],
    ['name' => 'Donut',              'category' => 'bolleria',        'price' => 1.00, 'flexsim_shape' => null, 'flexsim_spot' => null],

    // Cafés
    ['name' => 'Café solo',          'category' => 'cafe',            'price' => 1.00, 'flexsim_shape' => '/Tools/FlowItemBin/cafe/cafe',           'flexsim_spot' => '/MaqCafe'],
    ['name' => 'Café con leche',     'category' => 'cafe',            'price' => 1.30, 'flexsim_shape' => '/Tools/FlowItemBin/cafe/cafe',           'flexsim_spot' => '/MaqCafe'],
    ['name' => 'Cortado',            'category' => 'cafe',            'price' => 1.20, 'flexsim_shape' => '/Tools/FlowItemBin/cafe/cafe',           'flexsim_spot' => '/MaqCafe'],
    ['name' => 'Cappuccino',         'category' => 'cafe',            'price' => 1.80, 'flexsim_shape' => '/Tools/FlowItemBin/cafe/cafe',           'flexsim_spot' => '/MaqCafe'],

    // Bebidas
    ['name' => 'Agua',               'category' => 'bebida',          'price' => 0.80, 'flexsim_shape' => '/Tools/FlowItemBin/Agua/Agua',           'flexsim_spot' => '/MaqBebida'],
    ['name' => 'Refresco',           'category' => 'bebida',          'price' => 1.50, 'flexsim_shape' => '/Tools/FlowItemBin/lata/lata',           'flexsim_spot' => '/MaqBebida'],
    ['name' => 'Zumo natural',       'category' => 'bebida',          'price' => 2.00, 'flexsim_shape' => '/Tools/FlowItemBin/Zumo/Zumo',           'flexsim_spot' => '/MaqBebida'],
    ['name' => 'Zumo piña',          'category' => 'bebida',          'price' => 2.00, 'flexsim_shape' => '/Tools/FlowItemBin/ZumoPiña/ZumoPiña',   'flexsim_spot' => '/MaqBebida'],

    // Menús (sin shape/spot, los gestiona el AGV)
    ['name' => 'Menú completo',      'category' => 'menu_completo',    'price' => 6.50, 'flexsim_shape' => null, 'flexsim_spot' => null],
    ['name' => 'Medio menú',         'category' => 'menu_medio',       'price' => 4.00, 'flexsim_shape' => null, 'flexsim_spot' => null],
    ['name' => 'Menú vegetariano',   'category' => 'menu_vegetariano', 'price' => 6.00, 'flexsim_shape' => null, 'flexsim_spot' => null],
    ['name' => 'Menú saludable',     'category' => 'menu_saludable',   'price' => 6.50, 'flexsim_shape' => null, 'flexsim_spot' => null],
];

foreach ($products as $p) {
    \App\Models\Product::create(array_merge($p, ['available' => true]));
}

    }
}
