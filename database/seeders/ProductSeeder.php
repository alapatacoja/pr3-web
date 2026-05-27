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
            // Bocadillos
            [
                'name' => 'Bacon Huevo Patatas', 
                'category' => 'bocata', 
                'price' => 2.80, 
                'flexsim_shape' => '/Tools/FlowItemBin/Bocata/Bocata', 
                'flexsim_spot' => '/Rack1'
            ],
            [
                'name' => 'Tortilla de patata', 
                'category' => 'bocata', 
                'price' => 1.40, 
                'flexsim_shape' => '/Tools/FlowItemBin/Bocata/Bocata', 
                'flexsim_spot' => '/Rack1'
            ],
            [
                'name' => 'Vegetal', 
                'category' => 'bocata', 
                'price' => 2.20, 
                'flexsim_shape' => '/Tools/FlowItemBin/Bocata/Bocata', 
                'flexsim_spot' => '/Rack1'
            ],
            [
                'name' => 'Frankfurt Patatas', 
                'category' => 'bocata', 
                'price' => 1.50, 
                'flexsim_shape' => '/Tools/FlowItemBin/Bocata/Bocata', 
                'flexsim_spot' => '/Rack1'
            ],
            [
                'name' => 'Lomo Queso', 
                'category' => 'bocata', 
                'price' => 2.50, 
                'flexsim_shape' => '/Tools/FlowItemBin/Bocata/Bocata', 
                'flexsim_spot' => '/Rack1'
            ],
            [
                'name' => 'Atún Huevo Tomate', 
                'category' => 'bocata', 
                'price' => 2.20, 
                'flexsim_shape' => '/Tools/FlowItemBin/Bocata/Bocata', 
                'flexsim_spot' => '/Rack1'
            ],
            [
                'name' => 'Salmon con queso crema y cebolla crujiente', 
                'category' => 'bocata_especial', 
                'price' => 3.80, 
                'flexsim_shape' => '/Tools/FlowItemBin/Bocata/Bocata', 
                'flexsim_spot' => '/Rack1'
            ],
            [
                'name' => 'Calamares con mayonesa', 
                'category' => 'bocata_dia', 
                'price' => 2.80, 
                'flexsim_shape' => '/Tools/FlowItemBin/Bocata/Bocata', 
                'flexsim_spot' => '/Rack1'
            ],

            // Bollería
            [
                'name' => 'Croissant', 
                'category' => 'bolleria', 
                'price' => 0.90, 
                'flexsim_shape' => null, 
                'flexsim_spot' => null
            ],
            [
                'name' => 'Napolitana de Cocholate', 
                'category' => 'bolleria', 
                'price' => 1.20, 
                'flexsim_shape' => null, 
                'flexsim_spot' => null
            ],
            [
                'name' => 'Napolitana Mixta', 
                'category' => 'bolleria', 
                'price' => 1.20, 
                'flexsim_shape' => null, 
                'flexsim_spot' => null
            ],
            [
                'name' => 'Donut', 
                'category' => 'bolleria', 
                'price' => 0.80, 
                'flexsim_shape' => null, 
                'flexsim_spot' => null
            ],

            // Cafés
            [
                'name' => 'Café solo', 
                'category' => 'cafe', 
                'price' => 1.00, 
                'flexsim_shape' => '/Tools/FlowItemBin/cafe/cafe', 
                'flexsim_spot' => '/MaqCafe'
            ],
            [
                'name' => 'Café con leche', 
                'category' => 'cafe', 
                'price' => 1.30, 
                'flexsim_shape' => '/Tools/FlowItemBin/cafe/cafe', 
                'flexsim_spot' => '/MaqCafe'
            ],
            [
                'name' => 'Cortado', 
                'category' => 'cafe', 
                'price' => 1.20, 
                'flexsim_shape' => '/Tools/FlowItemBin/cafe/cafe', 
                'flexsim_spot' => '/MaqCafe'
            ],
            [
                'name' => 'Cappuccino', 
                'category' => 'cafe', 
                'price' => 1.80, 
                'flexsim_shape' => '/Tools/FlowItemBin/cafe/cafe', 
                'flexsim_spot' => '/MaqCafe'
            ],

            // Bebidas frías
            [
                'name' => 'Agua', 
                'category' => 'bebida', 
                'price' => 0.60, 
                'flexsim_shape' => '/Tools/FlowItemBin/Agua/Agua', 
                'flexsim_spot' => '/MaqBebida'
            ],
            [
                'name' => 'Refresco', 
                'category' => 'bebida', 
                'price' => 1.20, 
                'flexsim_shape' => '/Tools/FlowItemBin/lata/lata', 
                'flexsim_spot' => '/MaqBebida'
            ],
            [
                'name' => 'Zumo de piña', 
                'category' => 'bebida', 
                'price' => 1.50, 
                'flexsim_shape' => '/Tools/FlowItemBin/ZumoPiña/ZumoPiña', 
                'flexsim_spot' => '/MaqBebida'
            ],
            [
                'name' => 'Zumo de naranja', 
                'category' => 'bebida', 
                'price' => 1.40, 
                'flexsim_shape' => '/Tools/FlowItemBin/Zumo/Zumo', 
                'flexsim_spot' => '/MaqBebida'
            ],

            // Menús
            [
                'name' => 'Menú completo', 
                'category' => 'menu_completo', 
                'price' => 5.90, 
                'flexsim_shape' => null, 
                'flexsim_spot' => null
            ],
            [
                'name' => 'Medio menú', 
                'category' => 'menu_medio', 
                'price' => 4.20, 
                'flexsim_shape' => null, 
                'flexsim_spot' => null
            ],
            [
                'name' => 'Menú vegetariano', 
                'category' => 'menu_vegetariano', 
                'price' => 5.90, 
                'flexsim_shape' => null, 
                'flexsim_spot' => null
            ],
            [
                'name' => 'Menú saludable', 
                'category' => 'menu_saludable', 
                'price' => 5.90, 
                'flexsim_shape' => null, 
                'flexsim_spot' => null
            ],
        ];

        foreach ($products as $p) {
            Product::create(array_merge($p, ['available' => true]));
        }
    }
}