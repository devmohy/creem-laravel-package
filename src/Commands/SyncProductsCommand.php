<?php

namespace Creem\CreemLaravel\Commands;

use Illuminate\Console\Command;
use Creem\CreemLaravel\Facades\Creem;

class SyncProductsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'creem:sync-products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch products from the CREEM API and display them in a table';

    /**
     * Execute the console command.
     *
     * @return int Returns 0 on success, 1 on failure.
     */
    public function handle(): int
    {
        $this->info('Fetching products from CREEM...');

        $response = Creem::getProducts();

        if ($response->failed()) {
            $this->error('Failed to fetch products: ' . $response->body());
            return 1;
        }

        $products = $response->json();

        if (empty($products)) {
            $this->warn('No products found in your CREEM account.');
            return 0;
        }

        $this->table(
            ['ID', 'Name', 'Price', 'Currency'],
            array_map(function ($product) {
                return [
                    $product['id'] ?? 'N/A',
                    $product['name'] ?? 'N/A',
                    $product['price'] ?? 'N/A',
                    $product['currency'] ?? 'N/A',
                ];
            }, $products)
        );

        return 0;
    }
}
