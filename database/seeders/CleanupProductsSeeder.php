<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CleanupProductsSeeder extends Seeder
{
    /**
     * Limpia productos dejando máximo 3 por categoría.
     * Este seeder se ejecuta una sola vez y se auto-elimina del DatabaseSeeder.
     */
    public function run(): void
    {
        $this->command->info('🧹 Iniciando limpieza de productos...');
        
        $categories = Category::all();
        $totalDeleted = 0;
        
        foreach ($categories as $category) {
            // Obtener productos de esta categoría ordenados por ID
            $products = Product::where('category_id', $category->id)
                ->orderBy('id', 'asc')
                ->get();
            
            $count = $products->count();
            
            if ($count > 3) {
                // Mantener solo los primeros 3
                $productsToDelete = $products->slice(3);
                
                foreach ($productsToDelete as $product) {
                    // Eliminar imágenes asociadas
                    $product->images()->delete();
                    $product->delete();
                    $totalDeleted++;
                }
                
                $this->command->info("  ✓ {$category->name}: eliminados " . ($count - 3) . " productos (quedan 3)");
            } else {
                $this->command->info("  - {$category->name}: {$count} productos (sin cambios)");
            }
        }
        
        $this->command->info("✅ Limpieza completada. Total eliminados: {$totalDeleted}");
        $this->command->info("📊 Productos restantes: " . Product::count());
    }
}
