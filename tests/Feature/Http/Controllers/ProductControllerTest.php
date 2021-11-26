<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductControllerTest extends TestCase
{

    use RefreshDatabase;

    public function test_user_that_are_auth_can_only_view_products()
    {
        $response = $this->get(route('products.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_auth_user_can_see_products()
    {
        $user = User::factory()
        ->has(Product::factory()->count(10))
        ->create();

        $this->actingAs($user);

        $response = $this->get(route('products.index'));

        $response->assertInertia(function($page) use($user) {
            $page->component('Products/Index')
            ->where('auth.user', $user)
            ->hasAll([
                'products.data' => 10,
                'products.data.0.id',
                'products.data.0.name',
                'products.data.0.style',
                'products.data.0.brand',

            ]);
        });
    }

    public function test_user_that_are_auth_can_only_edit_products()
    {
        $user = User::factory()
        ->has(Product::factory()->count(1))
        ->create();

        $product = $user->products->first();

        $response = $this->get(route('products.edit', [
            'product' => $product->id
        ]));
        $response->assertRedirect(route('login'));
    }

    public function test_user_can_view_a_product()
    {
        $user = User::factory()
        ->has(Product::factory()->count(1))
        ->create();

        $product = $user->products->first();

        $this->actingAs($user);


        $response = $this->get(route('products.edit', [
            'product' => $product
        ]));

        $response->assertInertia(function($page) use($user, $product) {
            $page->component('Products/Edit')
            ->where('auth.user', $user)
            ->where('product', $product);
        });
    }

    public function test_user_cant_view_other_people_products()
    {

        $user = User::factory()
        ->has(Product::factory()->count(1))
        ->create();

        $user2 = User::factory()
        ->has(Product::factory()->count(1))
        ->create();

        //Get the other user product
        $product = $user2->products->first();

        $this->actingAs($user);

        $response = $this->get(route('products.edit', [
            'product' => $product
        ]));

        $response->assertForbidden();

    }

    public function test_user_that_are_auth_can_only_update_product()
    {
        $user = User::factory()
        ->has(Product::factory()->count(1))
        ->create();

        $product = $user->products->first();

        $updatedProduct = [
            'name' => 'new name',
            'description' => 'tesing',
            'style' => 'tesing',
            'brand' => 'tesing',
            'type' => 'tesing',
            'url' => 'http://test.com',
            'shipping_price' => 123,
            'note' => 'test',
        ];

        //Check database
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => $product->name
        ]);

        $response = $this->put(route('products.update', [
            'product' => $product->id
        ]), $updatedProduct);

        $response->assertRedirect(route('login'));

        //Check database
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => $product->name
        ]);
    }



    public function test_user_can_update_his_product()
    {

        $user = User::factory()
        ->has(Product::factory()->count(1))
        ->create();

        $product = $user->products->first();

        $this->actingAs($user);

        $updatedProduct = [
            'name' => 'new name',
            'description' => 'tesing',
            'style' => 'tesing',
            'brand' => 'tesing',
            'type' => 'tesing',
            'url' => 'http://test.com',
            'shipping_price' => 123,
            'note' => 'test',
        ];

        //Check database
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => $product->name
        ]);


        $response = $this->put(route('products.update', [
            'product' => $product->id
        ]), $updatedProduct);

        $response->assertSessionHas('success', 'Product has been saved');

        //Check that database changed
        $this->assertDatabaseHas('products', $updatedProduct);

    }

    public function test_user_cant_update_other_people_products()
    {

        $user = User::factory()
        ->has(Product::factory()->count(1))
        ->create();

        $user2 = User::factory()
        ->has(Product::factory()->count(1))
        ->create();

        //Get the other user product
        $product = $user2->products->first();

        $this->actingAs($user);

        $updatedProduct = [
            'name' => 'new name',
            'description' => 'tesing',
            'style' => 'tesing',
            'brand' => 'tesing',
            'type' => 'tesing',
            'url' => 'http://test.com',
            'shipping_price' => 123,
            'note' => 'test',
        ];

        //Check database
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => $product->name
        ]);


        $response = $this->put(route('products.update', [
            'product' => $product->id
        ]), $updatedProduct);

        $response->assertForbidden();

        //Confirm that the data hasn't chahnged
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => $product->name
        ]);
    }


    public function test_user_that_are_auth_can_only_delete_product()
    {
        $user = User::factory()
        ->has(Product::factory()->count(1))
        ->create();

        $product = $user->products->first();

        //Check database
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => $product->name
        ]);

        $response = $this->delete(route('products.destroy', [
            'product' => $product->id
        ]));

        $response->assertRedirect(route('login'));

        //Check database
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => $product->name
        ]);
    }

    public function test_user_can_delete_his_product()
    {

        $user = User::factory()
        ->has(Product::factory()->count(1))
        ->create();

        $product = $user->products->first();

        $this->actingAs($user);

        //Check database
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => $product->name
        ]);


        $response = $this->delete(route('products.destroy', [
            'product' => $product->id
        ]));

        $response->assertRedirect(route('products.index'));
        $response->assertSessionHas('success', 'Product has been deleted');

        //Check database for deleted product
        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
            'name' => $product->name
        ]);

    }

    public function test_user_cant_delete_other_people_products()
    {

        $user = User::factory()
        ->has(Product::factory()->count(1))
        ->create();

        $user2 = User::factory()
        ->has(Product::factory()->count(1))
        ->create();

        //Get the other user product
        $product = $user2->products->first();

        $this->actingAs($user);

        //Check database
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => $product->name
        ]);

        $response = $this->delete(route('products.destroy', [
            'product' => $product->id
        ]));

        $response->assertForbidden();

        //Confirm that the data hasn't chahnged
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => $product->name
        ]);
    }


    public function test_user_that_are_auth_can_only_create_product()
    {
        $response = $this->get(route('products.create'));
        $response->assertRedirect(route('login'));
    }

    public function test_user_can_store_product()
    {

        $user = User::factory()
        ->create();

        $this->actingAs($user);

        $product = [
            'name' => 'new name',
            'description' => 'tesing',
            'style' => 'tesing',
            'brand' => 'tesing',
            'type' => 'tesing',
            'url' => 'http://test.com',
            'shipping_price' => 123,
            'note' => 'test',
        ];


        //Check database
        $this->assertDatabaseMissing('products', $product);

        $response = $this->post(route('products.store', $product));

        $response->assertRedirect(route('products.index'));
        $response->assertSessionHas('success', 'Product has been saved');

        //Check database for deleted product
        $this->assertDatabaseHas('products', $product);

    }

    public function test_create_product_validation_errors_for_name()
    {

        $user = User::factory()
        ->create();

        $this->actingAs($user);

        $product = [
            'name' => '',
            'description' => 'tesing',
            'style' => 'tesing',
            'brand' => 'tesing',
            'type' => 'tesing',
            'url' => 'http://test.com',
            'shipping_price' => 123,
            'note' => 'test',
        ];


        //Check database
        $this->assertDatabaseMissing('products', $product);

        $response = $this->post(route('products.store', $product));
        $response->assertSessionHasErrors('name');

        //Check database for product
        $this->assertDatabaseMissing('products', $product);
    }

    public function test_create_product_validation_errors_for_description()
    {

        $user = User::factory()
        ->create();

        $this->actingAs($user);

        $product = [
            'name' => 'asd',
            'description' => '',
            'style' => 'tesing',
            'brand' => 'tesing',
            'type' => 'tesing',
            'url' => 'http://test.com',
            'shipping_price' => 123,
            'note' => 'test',
        ];


        //Check database
        $this->assertDatabaseMissing('products', $product);

        $response = $this->post(route('products.store', $product));
        $response->assertSessionHasErrors('description');

        //Check database for product
        $this->assertDatabaseMissing('products', $product);
    }

    public function test_create_product_validation_errors_for_style()
    {

        $user = User::factory()
        ->create();

        $this->actingAs($user);

        $product = [
            'name' => 'asd',
            'description' => 'asd',
            'style' => '',
            'brand' => 'tesing',
            'type' => 'tesing',
            'url' => 'http://test.com',
            'shipping_price' => 123,
            'note' => 'test',
        ];


        //Check database
        $this->assertDatabaseMissing('products', $product);

        $response = $this->post(route('products.store', $product));
        $response->assertSessionHasErrors('style');

        //Check database for product
        $this->assertDatabaseMissing('products', $product);
    }

    public function test_create_product_validation_errors_for_brand()
    {

        $user = User::factory()
        ->create();

        $this->actingAs($user);

        $product = [
            'name' => 'asd',
            'description' => 'asd',
            'style' => 'asd',
            'brand' => '',
            'type' => 'tesing',
            'url' => 'http://test.com',
            'shipping_price' => 123,
            'note' => 'test',
        ];


        //Check database
        $this->assertDatabaseMissing('products', $product);

        $response = $this->post(route('products.store', $product));
        $response->assertSessionHasErrors('brand');

        //Check database for product
        $this->assertDatabaseMissing('products', $product);
    }

    public function test_create_product_validation_errors_for_type()
    {

        $user = User::factory()
        ->create();

        $this->actingAs($user);

        $product = [
            'name' => 'asd',
            'description' => 'asd',
            'style' => 'asd',
            'brand' => 'asd',
            'type' => '',
            'url' => 'http://test.com',
            'shipping_price' => 123,
            'note' => 'test',
        ];


        //Check database
        $this->assertDatabaseMissing('products', $product);

        $response = $this->post(route('products.store', $product));
        $response->assertSessionHasErrors('type');

        //Check database for product
        $this->assertDatabaseMissing('products', $product);
    }


    public function test_create_product_validation_errors_for_shipping_price()
    {

        $user = User::factory()
        ->create();

        $this->actingAs($user);

        $product = [
            'name' => 'asd',
            'description' => 'asd',
            'style' => 'asd',
            'brand' => 'asd',
            'type' => 'asd',
            'url' => 'http://test.com',
            'note' => 'test',
        ];


        //Check database
        $this->assertDatabaseMissing('products', $product);

        $response = $this->post(route('products.store', $product));
        $response->assertSessionHasErrors('shipping_price');

        //Check database for product
        $this->assertDatabaseMissing('products', $product);
    }




}
