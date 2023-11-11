<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Product::create([
            'name' => 'GeForce RTX 3060',
            'images' => 'products/1.jpg',
            'price' => 3250,
            'brand_id' => 1,
            'category_id' => 1,
            'description' => 'Multiprocesadores NVIDIA Ampere pStreaming: los componentes básicos de la GPU más rápida y eficiente del mundo, el nuevo Ampere SM ofrece el doble de rendimiento que el FP32 y una eficiencia energética mejorada.',
            'warranty' => '1 Año',
            'details' => [],
            'quantity' => '3',
            'visacuotas' => true,
            'featured' => false,
            'condition' => 'Nuevo',
            'shipping' => true,
            'sale' => false,
            'percentage' => 0,
            'sale_price' => 0,
            'normal_price' => 3412.5,
            'sale_normal_price' => 0,
            'show_price' => 3250,
        ]);
        \App\Models\Product::create([
            'name' => 'Case Gaming TUF GT502 ATX Media Torre Vidrio Templado Sin Fuente',
            'images' => 'products/2.jpg',
            'price' => 2005,
            'brand_id' => 7,
            'category_id' => 2,
            'description' => 'TUF Gaming GT502 configura zonas de refrigeración independientes para la CPU y la GPU.',
            'warranty' => '1 Año',
            'details' => [],
            'quantity' => '3',
            'visacuotas' => true,
            'featured' => true,
            'condition' => 'Usado',
            'shipping' => true,
            'sale' => false,
            'percentage' => 0,
            'sale_price' => 0,
            'normal_price' => 2105.25,
            'sale_normal_price' => 0,
            'show_price' => 2005,
        ]);
        \App\Models\Product::create([
            'name' => 'Motherboard Asus A520M-A II AM4 x4DDR4 Micro ATX',
            'images' => 'products/5.jpg',
            'price' => 814,
            'brand_id' => 4,
            'category_id' => 3,
            'description' => 'Socket AMD AM4: Listo para procesadores de escritorio Ryzen™ 5000 Series / 4000 G-Series / 3000 Series.',
            'warranty' => '1 Año',
            'details' => [],
            'quantity' => '3',
            'visacuotas' => true,
            'condition' => 'Usado - como nuevo',
            'shipping' => true,
            'featured' => true,
            'sale' => false,
            'percentage' => 0,
            'sale_price' => 0,
            'normal_price' => 854.7,
            'sale_normal_price' => 0,
            'show_price' => 814,
        ]);
        \App\Models\Product::create([
            'name' => 'Intel Procesador Core i5-12400F a 2.50 GHz 12th Gen LGA1700',
            'images' => 'products/4.jpg',
            'price' => 1827,
            'brand_id' => 3,
            'category_id' => 4,
            'description' => '6 Núcleos + 12 Subprocesos',
            'warranty' => '1 Año',
            'details' => [],
            'quantity' => '3',
            'visacuotas' => true,
            'condition' => 'Nuevo',
            'shipping' => true,
            'featured' => false,
            'sale' => false,
            'percentage' => 0,
            'sale_price' => 0,
            'normal_price' => 1918.35,
            'sale_normal_price' => 0,
            'show_price' => 1827,
        ]);
        \App\Models\Product::create([
            'name' => 'Corsair Memoria RAM DDR5 32GB (2x16GB) 5200 Mhz Negro',
            'images' => 'products/3.jpg',
            'price' => 1005,
            'brand_id' => 6,
            'category_id' => 5,
            'description' => 'En la era de muchos núcleos, la velocidad de procesamiento sin precedentes de DDR5 garantiza que su CPU de gama alta obtenga datos rápidamente y con facilidad.',
            'warranty' => '1 Año',
            'details' => [],
            'quantity' => '3',
            'visacuotas' => true,
            'condition' => 'Nuevo',
            'shipping' => false,
            'featured' => true,
            'sale' => false,
            'percentage' => 0,
            'sale_price' => 0,
            'normal_price' => 1055.25,
            'sale_normal_price' => 0,
            'show_price' => 1005,
        ]);
        \App\Models\Product::create([
            'name' => 'Disipador Gaming Cooler Master ATX RR-2V2L-18PD-R1',
            'images' => 'products/6.jpg',
            'price' => 850,
            'brand_id' => 10,
            'category_id' => 6,
            'description' => 'Enfriador de aire negro para CPU, ventilador MF120 Halo², ARGB de doble bucle, cubierta superior de aluminio, 4 tubos de calor de cobre, 6.063 in (H) para AMD Ryzen AM5/AM4, Intel LGA1700/1200 (RR-S4KK-20PA-R1)',
            'warranty' => '18 meses',
            'details' => [],
            'quantity' => 0,
            'visacuotas' => true,
            'condition' => 'Nuevo',
            'shipping' => false,
            'featured' => true,
            'sale' => true,
            'percentage' => 10,
            'sale_price' => 765,
            'normal_price' => 892.5,
            'sale_normal_price' => 803.25,
            'show_price' => 765,
        ]);
        \App\Models\Product::create([
            'name' => 'Disipador Gaming Cooler Master ATX RR-2V2L-18PD-R1',
            'images' => 'products/6.jpg',
            'price' => 850,
            'brand_id' => 10,
            'category_id' => 6,
            'description' => 'Enfriador de aire negro para CPU, ventilador MF120 Halo², ARGB de doble bucle, cubierta superior de aluminio, 4 tubos de calor de cobre, 6.063 in (H) para AMD Ryzen AM5/AM4, Intel LGA1700/1200 (RR-S4KK-20PA-R1)',
            'warranty' => '18 meses',
            'details' => [],
            'quantity' => 1,
            'visacuotas' => true,
            'condition' => 'Nuevo',
            'shipping' => false,
            'featured' => true,
            'sale' => true,
            'percentage' => 10,
            'sale_price' => 765,
            'normal_price' => 892.5,
            'sale_normal_price' => 803.25,
            'show_price' => 765,
        ]);
        \App\Models\Product::create([
            'name' => 'Fuente de poder AZZA 650w 80 plus bronce RGB',
            'images' => 'products/7.jpg',
            'price' => 1200,
            'brand_id' => 11,
            'category_id' => 7,
            'description' => 'Fuente de Corriente RGB AZZA 650 Watts Reales 80 Plus Bronze PSAZ-650W-RGB Certificada eficiencia hasta 82%,Ventilador Silencioso 120mm,Boton para Intercambiar entre efectos predeterminados y MB SYNC',
            'warranty' => '1 año',
            'details' => [],
            'quantity' => '1',
            'visacuotas' => true,
            'condition' => 'Usado',
            'shipping' => false,
            'featured' => false,
            'sale' => false,
            'percentage' => 0,
            'sale_price' => 0,
            'normal_price' => 1260,
            'sale_normal_price' => 0,
            'show_price' => 1200,
        ]);
        \App\Models\Product::create([
            'name' => 'Unidad Estado Sólido SSD KINGSTON M.2 NV2 2TB',
            'images' => 'products/8.jpg',
            'price' => 825,
            'brand_id' => 12,
            'category_id' => 8,
            'description' => 'El SSD NVMe PCIe 4.0 NV2 es una solución de almacenamiento de nueva generación mejorada basada en un controlador NVME Gen 4x4. NV2 alcanza velocidades de lectura/escritura de hasta 3.500/2.800 MB/s [1], con menor consumo eléctrico y generando menos calor.',
            'warranty' => '1 año',
            'details' => [],
            'quantity' => '2',
            'visacuotas' => true,
            'condition' => 'Usado - como nuevo',
            'shipping' => false,
            'featured' => true,
            'sale' => false,
            'percentage' => 0,
            'sale_price' => 0,
            'normal_price' => 866.25,
            'sale_normal_price' => 0,
            'show_price' => 825,
        ]);
        \App\Models\Product::create([
            'name' => 'Corsair Memoria RAM DDR5 2x16GB 5200MHz VENGEANCE RGB BLANCO',
            'images' => 'products/9.jpg',
            'price' => 425,
            'brand_id' => 6,
            'category_id' => 5,
            'description' => 'Empuje los límites de su sistema como nunca antes con DDR5, desbloqueando frecuencias aún más rápidas, mayores capacidades y mejor rendimiento.',
            'warranty' => '18 meses',
            'details' => [],
            'quantity' => '8',
            'visacuotas' => true,
            'condition' => 'Usado',
            'shipping' => true,
            'featured' => true,
            'sale' => true,
            'percentage' => 10,
            'sale_price' => 382.5,
            'normal_price' => 446.25,
            'sale_normal_price' => 401.63,
            'show_price' => 382.5,
        ]);
        \App\Models\Product::create([
            'name' => 'Motherboard GIGABYTE B450M DS3H V2 AMD Socket AM4 4XDDR4',
            'images' => 'products/10.jpg',
            'price' => 1000,
            'brand_id' => 7,
            'category_id' => 3,
            'description' => 'Motherboard AMD B450 Ultra Durable con solución VRM digital, gestión de ancho de banda y LAN para juegos GIGABYTE, M.2 PCIe Gen3 x4, resistencia anti-azufre, cabezal de tira de LED RGB.',
            'warranty' => '18 meses',
            'details' => [],
            'quantity' => '2',
            'visacuotas' => false,
            'condition' => 'Nuevo',
            'shipping' => false,
            'featured' => false,
            'sale' => true,
            'percentage' => 10,
            'sale_price' => 900,
            'normal_price' => 1050,
            'sale_normal_price' => 945,
            'show_price' => 900,
        ]);
    }
}
