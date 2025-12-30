<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;
use App\Models\Product;

class CleanupProducts extends Command
{
    protected $signature = 'products:cleanup {--limit=3 : Number of products to keep per category}';
    protected $description = 'Keep only N products per category, delete the rest';

    public function handle()
    {
        $limit = (int) $this->option('limit');
        $categories = Category::all();
        $totalDeleted = 0;

        $this->info("Cleaning up products, keeping {$limit} per category...");

        foreach ($categories as $category) {
            $products = $category->products()->orderBy('id', 'desc')->get();
            $toKeep = $products->take($limit)->pluck('id')->toArray();
            
            $deleted = Product::where('category_id', $category->id)
                ->whereNotIn('id', $toKeep)
                ->delete();
            
            $totalDeleted += $deleted;
            
            if ($deleted > 0) {
                $this->line("  {$category->name}: {$deleted} deleted");
            }
        }

        $this->info("Total products deleted: {$totalDeleted}");
        
        return Command::SUCCESS;
    }
}
