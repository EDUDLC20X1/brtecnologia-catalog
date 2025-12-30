<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class CleanupProducts extends Command
{
    protected $signature = 'products:cleanup {--limit=3 : Number of products to keep per category}';
    protected $description = 'Keep only N products per category, delete the rest';

    public function handle()
    {
        $limit = (int) $this->option('limit');
        $categories = Category::all();
        $totalDeleted = 0;

        $this->info("🧹 Cleaning up products, keeping {$limit} per category...");

        foreach ($categories as $category) {
            // Obtener IDs de productos a mantener
            $keepIds = Product::where('category_id', $category->id)
                ->orderBy('id', 'asc')
                ->limit($limit)
                ->pluck('id')
                ->toArray();
            
            // Contar productos a eliminar
            $toDeleteCount = Product::where('category_id', $category->id)
                ->whereNotIn('id', $keepIds)
                ->count();
            
            if ($toDeleteCount > 0) {
                // Eliminar imágenes primero
                DB::table('product_images')
                    ->whereIn('product_id', function($query) use ($category, $keepIds) {
                        $query->select('id')
                            ->from('products')
                            ->where('category_id', $category->id)
                            ->whereNotIn('id', $keepIds);
                    })
                    ->delete();
                
                // Eliminar productos
                $deleted = Product::where('category_id', $category->id)
                    ->whereNotIn('id', $keepIds)
                    ->delete();
                
                $totalDeleted += $deleted;
                $this->line("  ✓ {$category->name}: {$deleted} deleted");
            }
        }

        $remaining = Product::count();
        $this->info("✅ Total deleted: {$totalDeleted}");
        $this->info("📊 Products remaining: {$remaining}");
        
        return Command::SUCCESS;
    }
}
