<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TestProductStock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stock:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test product stock management scenarios';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🏪 Testing Product Stock Management\n');

        try {
            // Create test category if not exists
            $category = Category::firstOrCreate(
                ['name' => 'Test Category'],
                ['slug' => 'test-category', 'description' => 'For testing']
            );

            // Test Scenario 1: Normal Stock
            $this->line('📌 Scenario 1: Normal Stock (100 units)');
            $product1 = Product::updateOrCreate(
                ['name' => '[TEST] Product with Normal Stock'],
                [
                    'category_id' => $category->id,
                    'description' => 'Test product with normal stock',
                    'price' => 100000,
                    'stock' => 100,
                    'low_stock_threshold' => 10,
                    'sku' => 'TEST-001',
                    'status' => 'active',
                ]
            );
            $product1->updateStockStatus();
            $this->line("  Stock: {$product1->stock}");
            $this->line("  Status: {$product1->stock_status}");
            $this->line("  Available: " . ($product1->isAvailable() ? '✅ Yes' : '❌ No'));
            $this->line("  Low Stock: " . ($product1->hasLowStock() ? '⚠️  Yes' : '✅ No') . "\n");

            // Test Scenario 2: Low Stock
            $this->line('📌 Scenario 2: Low Stock (5 units, threshold 10)');
            $product2 = Product::updateOrCreate(
                ['name' => '[TEST] Product with Low Stock'],
                [
                    'category_id' => $category->id,
                    'description' => 'Test product with low stock',
                    'price' => 150000,
                    'stock' => 5,
                    'low_stock_threshold' => 10,
                    'sku' => 'TEST-002',
                    'status' => 'active',
                ]
            );
            $product2->updateStockStatus();
            $this->line("  Stock: {$product2->stock}");
            $this->line("  Threshold: {$product2->low_stock_threshold}");
            $this->line("  Status: {$product2->stock_status}");
            $this->line("  Available: " . ($product2->isAvailable() ? '✅ Yes' : '❌ No'));
            $this->line("  Low Stock: " . ($product2->hasLowStock() ? '⚠️  Yes' : '✅ No') . "\n");

            // Test Scenario 3: Out of Stock
            $this->line('📌 Scenario 3: Out of Stock (0 units)');
            $product3 = Product::updateOrCreate(
                ['name' => '[TEST] Product Out of Stock'],
                [
                    'category_id' => $category->id,
                    'description' => 'Test product out of stock',
                    'price' => 200000,
                    'stock' => 0,
                    'low_stock_threshold' => 10,
                    'sku' => 'TEST-003',
                    'status' => 'active',
                ]
            );
            $product3->updateStockStatus();
            $this->line("  Stock: {$product3->stock}");
            $this->line("  Status: {$product3->stock_status}");
            $this->line("  Available: " . ($product3->isAvailable() ? '✅ Yes' : '❌ No'));
            $this->line("  Low Stock: " . ($product3->hasLowStock() ? '⚠️  Yes' : '✅ No') . "\n");

            // Test Scenario 4: Negative Stock (should not happen)
            $this->line('📌 Scenario 4: Negative Stock (-5 units - should not happen)');
            $product4 = Product::updateOrCreate(
                ['name' => '[TEST] Product Negative Stock'],
                [
                    'category_id' => $category->id,
                    'description' => 'Test product with negative stock',
                    'price' => 250000,
                    'stock' => -5,
                    'low_stock_threshold' => 10,
                    'sku' => 'TEST-004',
                    'status' => 'active',
                ]
            );
            $product4->updateStockStatus();
            $this->line("  Stock: {$product4->stock}");
            $this->line("  Status: {$product4->stock_status}");
            $this->line("  Available: " . ($product4->isAvailable() ? '✅ Yes' : '❌ No'));
            $this->line("  ⚠️  WARNING: Negative stock detected!\n");

            // Test Scenario 5: Inactive Product
            $this->line('📌 Scenario 5: Inactive Product with Stock');
            $product5 = Product::updateOrCreate(
                ['name' => '[TEST] Inactive Product'],
                [
                    'category_id' => $category->id,
                    'description' => 'Test inactive product',
                    'price' => 300000,
                    'stock' => 50,
                    'low_stock_threshold' => 10,
                    'sku' => 'TEST-005',
                    'status' => 'inactive',
                ]
            );
            $product5->updateStockStatus();
            $this->line("  Stock: {$product5->stock}");
            $this->line("  Status (product): {$product5->status}");
            $this->line("  Available: " . ($product5->isAvailable() ? '✅ Yes' : '❌ No') . "\n");

            // Test Scope: Low Stock Products
            $this->line('📌 Query Test: All Low Stock Products');
            $lowStockProducts = Product::lowStock()->count();
            $this->line("  Count: {$lowStockProducts}\n");

            // Test Scope: Out of Stock Products
            $this->line('📌 Query Test: All Out of Stock Products');
            $outOfStockProducts = Product::outOfStock()->count();
            $this->line("  Count: {$outOfStockProducts}\n");

            // Test Stock Decrement
            $this->line('📌 Test: Stock Decrement');
            $testProduct = $product1->fresh();
            $originalStock = $testProduct->stock;
            $testProduct->decrement('stock', 5);
            $testProduct->updateStockStatus();
            $testProduct->refresh();
            $this->line("  Original: {$originalStock}");
            $this->line("  After decrement(5): {$testProduct->stock}");
            $this->line("  New Status: {$testProduct->stock_status}\n");

            // Test Stock Increment
            $this->line('📌 Test: Stock Increment');
            $testProduct->increment('stock', 3);
            $testProduct->updateStockStatus();
            $testProduct->refresh();
            $this->line("  Current: {$testProduct->stock}");
            $this->line("  After increment(3): {$testProduct->stock}");
            $this->line("  New Status: {$testProduct->stock_status}\n");

            // Summary Report
            $this->info('📊 Summary Report:');
            $totalProducts = Product::count();
            $activeProducts = Product::active()->count();
            $lowStockCount = Product::lowStock()->count();
            $outOfStockCount = Product::outOfStock()->count();

            $this->line("  Total Products: {$totalProducts}");
            $this->line("  Active Products: {$activeProducts}");
            $this->line("  Low Stock Products: {$lowStockCount}");
            $this->line("  Out of Stock Products: {$outOfStockCount}");

            $this->info('\n✅ All stock tests completed successfully!');

        } catch (\Exception $e) {
            $this->error("\n❌ Test Failed!");
            $this->error("Error: " . $e->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
