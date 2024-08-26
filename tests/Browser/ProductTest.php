<?php

namespace Tests\Browser;

use App\Models\Product;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProductTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test creating a new product.
     */
    public function testCreateProduct()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/products/create')
                    ->type('name', 'Test Product')
                    ->type('description', 'Test Description')
                    ->type('price', '19.99')
                    ->press('Save')
                    ->assertPathIs('/products')
                    ->assertSee('Test Product');

            $this->assertDatabaseHas('products', [
                'name' => 'Test Product',
                'price' => '19.99',
            ]);
        });
    }

    /**
     * Test validation errors when creating a product.
     */
    public function testCreateProductValidationErrors()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/products/create')
                    ->press('Save')
                    ->assertPathIs('/products/create')
                    ->assertSee('The name field is required.')
                    ->assertSee('The price field is required.');
        });
    }

    /**
     * Test viewing all products.
     */
    public function testViewProducts()
    {
        $products = Product::factory()->count(5)->create();

        $this->browse(function (Browser $browser) use ($products) {
            $browser->visit('/products')
                    ->assertSee($products->first()->name)
                    ->assertSee($products->last()->name);
        });
    }

    /**
     * Test viewing a single product.
     */
    public function testViewSingleProduct()
    {
        $product = Product::factory()->create();

        $this->browse(function (Browser $browser) use ($product) {
            $browser->visit("/products/{$product->id}")
                    ->assertSee($product->name)
                    ->assertSee($product->description)
                    ->assertSee($product->price);
        });
    }

    /**
     * Test updating a product's details.
     */
    public function testUpdateProduct()
    {
        $product = Product::factory()->create();

        $this->browse(function (Browser $browser) use ($product) {
            $browser->visit("/products/{$product->id}/edit")
                    ->type('name', 'Updated Product Name')
                    ->type('price', '29.99')
                    ->press('Update')
                    ->assertPathIs('/products')
                    ->assertSee('Updated Product Name');

            $this->assertDatabaseHas('products', [
                'id' => $product->id,
                'name' => 'Updated Product Name',
                'price' => '29.99',
            ]);
        });
    }

    /**
     * Test validation errors when updating a product.
     */
    public function testUpdateProductValidationErrors()
    {
        $product = Product::factory()->create();

        $this->browse(function (Browser $browser) use ($product) {
            $browser->visit("/products/{$product->id}/edit")
                    ->type('name', '')
                    ->press('Update')
                    ->assertPathIs("/products/{$product->id}/edit")
                    ->assertSee('The name field is required.');
        });
    }

    /**
     * Test deleting a product.
     */
    public function testDeleteProduct()
    {
        $product = Product::factory()->create();

        $this->browse(function (Browser $browser) use ($product) {
            $browser->visit('/products')
                    ->press("@delete-product-{$product->id}")
                    ->assertDontSee($product->name);

            $this->assertDatabaseMissing('products', [
                'id' => $product->id,
            ]);
        });
    }
}
