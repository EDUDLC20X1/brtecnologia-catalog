<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class SimpleProductSeeder extends Seeder
{
    /**
     * Crear 3 productos por cada categoría principal.
     * Categorías: Laptops, Teléfonos, Tablets, Accesorios, Monitores, Teclados
     */
    public function run(): void
    {
        // Limpiar productos existentes
        \DB::statement('TRUNCATE TABLE product_images CASCADE');
        \DB::statement('TRUNCATE TABLE products CASCADE');
        \DB::statement('TRUNCATE TABLE categories CASCADE');

        $this->command->info('🗑️ Tablas limpiadas');

        // Crear las 6 categorías principales
        $categories = [
            'Laptops' => ['icon' => 'bi-laptop', 'description' => 'Laptops y portátiles de última generación'],
            'Teléfonos' => ['icon' => 'bi-phone', 'description' => 'Smartphones y teléfonos celulares'],
            'Tablets' => ['icon' => 'bi-tablet', 'description' => 'Tablets Android, iPad y accesorios'],
            'Accesorios' => ['icon' => 'bi-headphones', 'description' => 'Accesorios para dispositivos electrónicos'],
            'Monitores' => ['icon' => 'bi-display', 'description' => 'Monitores LED, gaming y profesionales'],
            'Teclados' => ['icon' => 'bi-keyboard', 'description' => 'Teclados USB, inalámbricos y gaming'],
        ];

        foreach ($categories as $name => $data) {
            Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'icon' => $data['icon'],
                'description' => $data['description'],
                'is_active' => true,
            ]);
        }

        $this->command->info('✅ 6 Categorías principales creadas');

        // Productos por categoría (3 productos cada una)
        $products = [
            // LAPTOPS (3 productos)
            [
                'category' => 'Laptops',
                'sku_code' => 'LAP-001',
                'name' => 'Laptop HP Pavilion 15',
                'description' => 'Laptop HP Pavilion 15 con procesador Intel Core i5, 8GB RAM, 512GB SSD, pantalla Full HD de 15.6 pulgadas. Ideal para trabajo y entretenimiento.',
                'technical_specs' => json_encode([
                    'Procesador' => 'Intel Core i5-1235U',
                    'RAM' => '8GB DDR4',
                    'Almacenamiento' => '512GB SSD NVMe',
                    'Pantalla' => '15.6" Full HD IPS',
                    'Sistema Operativo' => 'Windows 11 Home',
                    'Batería' => 'Hasta 8 horas',
                ]),
                'stock_available' => 15,
                'price_base' => 699.99,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'category' => 'Laptops',
                'sku_code' => 'LAP-002',
                'name' => 'MacBook Air M2',
                'description' => 'MacBook Air con chip M2 de Apple, 8GB de memoria unificada, 256GB SSD. Diseño ultradelgado y ligero con pantalla Liquid Retina de 13.6".',
                'technical_specs' => json_encode([
                    'Chip' => 'Apple M2',
                    'Memoria' => '8GB unificada',
                    'Almacenamiento' => '256GB SSD',
                    'Pantalla' => '13.6" Liquid Retina',
                    'Sistema Operativo' => 'macOS Ventura',
                    'Batería' => 'Hasta 18 horas',
                ]),
                'stock_available' => 10,
                'price_base' => 1199.99,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'category' => 'Laptops',
                'sku_code' => 'LAP-003',
                'name' => 'Lenovo IdeaPad Gaming 3',
                'description' => 'Laptop gaming Lenovo IdeaPad con AMD Ryzen 5, NVIDIA GTX 1650, 16GB RAM, 512GB SSD. Pantalla 15.6" 120Hz para gaming fluido.',
                'technical_specs' => json_encode([
                    'Procesador' => 'AMD Ryzen 5 5600H',
                    'GPU' => 'NVIDIA GTX 1650 4GB',
                    'RAM' => '16GB DDR4',
                    'Almacenamiento' => '512GB SSD NVMe',
                    'Pantalla' => '15.6" FHD 120Hz',
                    'Sistema Operativo' => 'Windows 11 Home',
                ]),
                'stock_available' => 8,
                'price_base' => 849.99,
                'is_active' => true,
                'is_featured' => false,
            ],

            // TELÉFONOS (3 productos)
            [
                'category' => 'Teléfonos',
                'sku_code' => 'TEL-001',
                'name' => 'iPhone 15 Pro',
                'description' => 'iPhone 15 Pro con chip A17 Pro, cámara de 48MP, pantalla Super Retina XDR de 6.1". Titanio de calidad aeroespacial.',
                'technical_specs' => json_encode([
                    'Chip' => 'A17 Pro',
                    'Pantalla' => '6.1" Super Retina XDR',
                    'Cámara Principal' => '48MP',
                    'Almacenamiento' => '256GB',
                    'Batería' => 'Hasta 23 horas de video',
                    'Material' => 'Titanio',
                ]),
                'stock_available' => 20,
                'price_base' => 1199.00,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'category' => 'Teléfonos',
                'sku_code' => 'TEL-002',
                'name' => 'Samsung Galaxy S24 Ultra',
                'description' => 'Samsung Galaxy S24 Ultra con IA Galaxy, S Pen integrado, cámara de 200MP, pantalla Dynamic AMOLED 2X de 6.8".',
                'technical_specs' => json_encode([
                    'Procesador' => 'Snapdragon 8 Gen 3',
                    'Pantalla' => '6.8" Dynamic AMOLED 2X',
                    'Cámara Principal' => '200MP',
                    'RAM' => '12GB',
                    'Almacenamiento' => '512GB',
                    'Batería' => '5000mAh',
                ]),
                'stock_available' => 15,
                'price_base' => 1299.99,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'category' => 'Teléfonos',
                'sku_code' => 'TEL-003',
                'name' => 'Xiaomi Redmi Note 13 Pro',
                'description' => 'Xiaomi Redmi Note 13 Pro con cámara de 200MP, carga rápida 67W, pantalla AMOLED de 6.67". Excelente relación calidad-precio.',
                'technical_specs' => json_encode([
                    'Procesador' => 'MediaTek Dimensity 7200',
                    'Pantalla' => '6.67" AMOLED 120Hz',
                    'Cámara Principal' => '200MP',
                    'RAM' => '8GB',
                    'Almacenamiento' => '256GB',
                    'Batería' => '5100mAh, carga 67W',
                ]),
                'stock_available' => 25,
                'price_base' => 349.99,
                'is_active' => true,
                'is_featured' => false,
            ],

            // TABLETS (3 productos)
            [
                'category' => 'Tablets',
                'sku_code' => 'TAB-001',
                'name' => 'iPad Pro 12.9"',
                'description' => 'iPad Pro 12.9" con chip M2, pantalla Liquid Retina XDR, compatible con Apple Pencil 2 y Magic Keyboard.',
                'technical_specs' => json_encode([
                    'Chip' => 'Apple M2',
                    'Pantalla' => '12.9" Liquid Retina XDR',
                    'Almacenamiento' => '256GB',
                    'Cámara' => '12MP + 10MP Ultra Wide',
                    'Conectividad' => 'WiFi 6E',
                    'Face ID' => 'Sí',
                ]),
                'stock_available' => 8,
                'price_base' => 1099.00,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'category' => 'Tablets',
                'sku_code' => 'TAB-002',
                'name' => 'Samsung Galaxy Tab S9+',
                'description' => 'Samsung Galaxy Tab S9+ con pantalla AMOLED de 12.4", S Pen incluido, resistencia al agua IP68.',
                'technical_specs' => json_encode([
                    'Procesador' => 'Snapdragon 8 Gen 2',
                    'Pantalla' => '12.4" Dynamic AMOLED 2X',
                    'RAM' => '12GB',
                    'Almacenamiento' => '256GB',
                    'Batería' => '10090mAh',
                    'S Pen' => 'Incluido',
                ]),
                'stock_available' => 12,
                'price_base' => 999.99,
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'category' => 'Tablets',
                'sku_code' => 'TAB-003',
                'name' => 'Lenovo Tab P12 Pro',
                'description' => 'Lenovo Tab P12 Pro con pantalla OLED de 12.6", Snapdragon 870, 8GB RAM, ideal para productividad y entretenimiento.',
                'technical_specs' => json_encode([
                    'Procesador' => 'Snapdragon 870',
                    'Pantalla' => '12.6" OLED 2K',
                    'RAM' => '8GB',
                    'Almacenamiento' => '256GB',
                    'Batería' => '10200mAh',
                    'Audio' => 'JBL quad speakers',
                ]),
                'stock_available' => 10,
                'price_base' => 649.99,
                'is_active' => true,
                'is_featured' => false,
            ],

            // ACCESORIOS (3 productos)
            [
                'category' => 'Accesorios',
                'sku_code' => 'ACC-001',
                'name' => 'AirPods Pro 2da Gen',
                'description' => 'Apple AirPods Pro de 2da generación con cancelación activa de ruido, audio espacial y estuche de carga MagSafe.',
                'technical_specs' => json_encode([
                    'Cancelación de Ruido' => 'Activa',
                    'Audio Espacial' => 'Personalizado',
                    'Resistencia' => 'IPX4',
                    'Batería' => 'Hasta 6 horas (30h con estuche)',
                    'Carga' => 'MagSafe, Lightning, Qi',
                    'Chip' => 'H2',
                ]),
                'stock_available' => 30,
                'price_base' => 249.00,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'category' => 'Accesorios',
                'sku_code' => 'ACC-002',
                'name' => 'Mouse Logitech MX Master 3S',
                'description' => 'Mouse inalámbrico Logitech MX Master 3S con sensor de 8000 DPI, scroll electromagnético, compatible con múltiples dispositivos.',
                'technical_specs' => json_encode([
                    'Sensor' => '8000 DPI',
                    'Conexión' => 'Bluetooth + USB Receiver',
                    'Batería' => 'Recargable, 70 días',
                    'Dispositivos' => 'Hasta 3 simultáneos',
                    'Carga Rápida' => '1 min = 3 horas',
                    'Compatibilidad' => 'Windows, macOS, Linux',
                ]),
                'stock_available' => 25,
                'price_base' => 99.99,
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'category' => 'Accesorios',
                'sku_code' => 'ACC-003',
                'name' => 'Cargador Anker 65W GaN',
                'description' => 'Cargador USB-C Anker 65W con tecnología GaN II, 3 puertos, compatible con laptops, tablets y smartphones.',
                'technical_specs' => json_encode([
                    'Potencia' => '65W máximo',
                    'Puertos' => '2x USB-C + 1x USB-A',
                    'Tecnología' => 'GaN II',
                    'Protecciones' => 'Sobrecarga, sobrecalentamiento',
                    'Compatibilidad' => 'Universal (PD 3.0)',
                    'Tamaño' => 'Compacto (45% más pequeño)',
                ]),
                'stock_available' => 40,
                'price_base' => 54.99,
                'is_active' => true,
                'is_featured' => false,
            ],

            // MONITORES (3 productos)
            [
                'category' => 'Monitores',
                'sku_code' => 'MON-001',
                'name' => 'Monitor LG UltraGear 27"',
                'description' => 'Monitor gaming LG UltraGear de 27" QHD, 165Hz, 1ms, G-Sync Compatible, panel IPS para colores vibrantes.',
                'technical_specs' => json_encode([
                    'Tamaño' => '27 pulgadas',
                    'Resolución' => '2560x1440 (QHD)',
                    'Tasa Refresco' => '165Hz',
                    'Tiempo Respuesta' => '1ms GTG',
                    'Panel' => 'IPS',
                    'HDR' => 'HDR10',
                ]),
                'stock_available' => 12,
                'price_base' => 349.99,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'category' => 'Monitores',
                'sku_code' => 'MON-002',
                'name' => 'Monitor Samsung Odyssey G5 32"',
                'description' => 'Monitor curvo gaming Samsung Odyssey G5 de 32" QHD, 165Hz, curvatura 1000R para inmersión total.',
                'technical_specs' => json_encode([
                    'Tamaño' => '32 pulgadas',
                    'Resolución' => '2560x1440 (QHD)',
                    'Curvatura' => '1000R',
                    'Tasa Refresco' => '165Hz',
                    'Tiempo Respuesta' => '1ms',
                    'Panel' => 'VA',
                ]),
                'stock_available' => 8,
                'price_base' => 399.99,
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'category' => 'Monitores',
                'sku_code' => 'MON-003',
                'name' => 'Monitor Dell UltraSharp 27" 4K',
                'description' => 'Monitor profesional Dell UltraSharp U2723QE de 27" 4K, USB-C hub integrado, 100% sRGB, ideal para creativos.',
                'technical_specs' => json_encode([
                    'Tamaño' => '27 pulgadas',
                    'Resolución' => '3840x2160 (4K)',
                    'Panel' => 'IPS Black',
                    'Cobertura Color' => '100% sRGB, 98% DCI-P3',
                    'Conectividad' => 'USB-C 90W, HDMI, DP',
                    'Hub USB' => 'Integrado',
                ]),
                'stock_available' => 6,
                'price_base' => 649.99,
                'is_active' => true,
                'is_featured' => true,
            ],

            // TECLADOS (3 productos)
            [
                'category' => 'Teclados',
                'sku_code' => 'TEC-001',
                'name' => 'Teclado Logitech MX Keys',
                'description' => 'Teclado inalámbrico Logitech MX Keys con retroiluminación inteligente, teclas cóncavas, compatible con múltiples dispositivos.',
                'technical_specs' => json_encode([
                    'Tipo' => 'Membrana de perfil bajo',
                    'Conexión' => 'Bluetooth + USB Receiver',
                    'Retroiluminación' => 'Sí, ajustable',
                    'Batería' => 'Recargable, 10 días',
                    'Dispositivos' => 'Hasta 3 simultáneos',
                    'Compatibilidad' => 'Windows, macOS',
                ]),
                'stock_available' => 20,
                'price_base' => 119.99,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'category' => 'Teclados',
                'sku_code' => 'TEC-002',
                'name' => 'Teclado Mecánico HyperX Alloy',
                'description' => 'Teclado mecánico gaming HyperX Alloy Origins Core TKL con switches HyperX Red, RGB por tecla, cuerpo de aluminio.',
                'technical_specs' => json_encode([
                    'Tipo' => 'Mecánico TKL',
                    'Switches' => 'HyperX Red (lineal)',
                    'Retroiluminación' => 'RGB por tecla',
                    'Material' => 'Aluminio aeronáutico',
                    'Conexión' => 'USB-C desmontable',
                    'Software' => 'HyperX NGENUITY',
                ]),
                'stock_available' => 15,
                'price_base' => 89.99,
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'category' => 'Teclados',
                'sku_code' => 'TEC-003',
                'name' => 'Teclado Apple Magic Keyboard',
                'description' => 'Teclado Apple Magic Keyboard con Touch ID y teclado numérico para Mac con chip Apple Silicon.',
                'technical_specs' => json_encode([
                    'Tipo' => 'Tijera de bajo perfil',
                    'Conexión' => 'Bluetooth + Lightning',
                    'Touch ID' => 'Sí',
                    'Batería' => 'Recargable, 1 mes',
                    'Teclado Numérico' => 'Sí',
                    'Compatibilidad' => 'Mac con Apple Silicon',
                ]),
                'stock_available' => 18,
                'price_base' => 199.00,
                'is_active' => true,
                'is_featured' => false,
            ],
        ];

        $created = 0;
        foreach ($products as $productData) {
            $categoryName = $productData['category'];
            unset($productData['category']);
            
            $category = Category::where('name', $categoryName)->first();
            
            if ($category) {
                $productData['category_id'] = $category->id;
                $productData['slug'] = Str::slug($productData['name']);
                
                Product::create($productData);
                $created++;
            }
        }

        $this->command->info("✅ Productos creados: {$created}");
        $this->command->info('========================================');
        $this->command->info('📊 RESUMEN:');
        $this->command->info('   Total de Categorías: ' . Category::count());
        $this->command->info('   Total de Productos: ' . Product::count());
        $this->command->info('   Productos por categoría: 3');
        $this->command->info('========================================');
    }
}
