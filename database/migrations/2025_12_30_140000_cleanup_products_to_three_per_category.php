<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Limpia productos dejando máximo 3 por categoría.
     */
    public function up(): void
    {
        $categories = DB::table('categories')->get();
        $totalDeleted = 0;
        
        foreach ($categories as $category) {
            // Obtener IDs de productos a mantener (los 3 primeros)
            $keepIds = DB::table('products')
                ->where('category_id', $category->id)
                ->orderBy('id', 'asc')
                ->limit(3)
                ->pluck('id')
                ->toArray();
            
            if (count($keepIds) > 0) {
                // Eliminar imágenes de productos que se van a borrar
                DB::table('product_images')
                    ->whereIn('product_id', function($query) use ($category, $keepIds) {
                        $query->select('id')
                            ->from('products')
                            ->where('category_id', $category->id)
                            ->whereNotIn('id', $keepIds);
                    })
                    ->delete();
                
                // Eliminar productos excepto los 3 primeros
                $deleted = DB::table('products')
                    ->where('category_id', $category->id)
                    ->whereNotIn('id', $keepIds)
                    ->delete();
                
                $totalDeleted += $deleted;
            }
        }
        
        echo "Total productos eliminados: {$totalDeleted}\n";
        echo "Productos restantes: " . DB::table('products')->count() . "\n";
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No se puede revertir la eliminación de productos
    }
};
