<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Inventory;
use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderControllerTest extends TestCase
{
   use RefreshDatabase;

    public function test_user_that_are_auth_can_only_view_orders()
    {
        $response = $this->get(route('orders.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_auth_user_can_see_products()
    {
        //Create a user with orders
        $user = User::factory()
        ->has(
            Product::factory()
                ->has(
                    Inventory::factory()->count(1)
                )
                ->has(
                    Order::factory()->count(3), 'orders'
                )->count(1)
        )
        ->create();

        $orders = $user->orders;
        $orderCount = $orders->count();
        $orderSum   = $orders->sum('total_cents');

        $this->actingAs($user);

        $response = $this->get(route('orders.index'));

        $response->assertInertia(function($page) use($user, $orderCount, $orderSum) {
            $page->component('Orders/Index')
            ->where('auth.user', $user)
            ->where('orders.total' , $orderCount)
            ->where('stats.total_sales_sum', "$orderSum")
            ->hasAll([
                'orders.data.0.name',
                'orders.data.0.product.id',
                'orders.data.0.inventory.id',
                'orders.data.0.inventory.sku',
                'stats.total_sales_sum',
                'stats.avg_sales_sum',
            ]);
        });
    }

    public function test_orders_can_be_filtered_by_product_name()
    {
        //Create a user with orders
        $user = User::factory()
        ->has(
            Product::factory()
                ->has(Inventory::factory()->count(1))
                ->has(Order::factory()->count(3),'orders')
                ->state([
                    'name' => 'product1'
                ])
                ->count(1)
        )
        ->has(
            Product::factory()
                ->has(Inventory::factory()->count(1))
                ->has(Order::factory()->count(3),'orders')
                ->state([
                    'name' => 'product2'
                ])
                ->count(1)
        )
        ->create();

        $this->actingAs($user);

        $searchTerm = 'product1';

        $orders = $user->orders()->search($searchTerm)->get();
        $orderCount = $orders->count();
        $orderSum   = $orders->sum('total_cents');

        $response = $this->get(route('orders.index', ['search' => $searchTerm]));

        $response->assertInertia(function($page) use($user, $orderCount, $orderSum, $searchTerm) {
            $page->component('Orders/Index')
            ->where('auth.user', $user)
            ->where('orders.total' , $orderCount)
            ->where('stats.total_sales_sum', "$orderSum")
            ->where('filters', [
                'search'  => $searchTerm
            ])
            ->hasAll([
                'orders.data.0.name',
                'orders.data.0.product.id',
                'orders.data.0.inventory.id',
                'orders.data.0.inventory.sku',
                'stats.total_sales_sum',
                'stats.avg_sales_sum',
            ]);
        });
    }

    public function test_user_can_view_his_own_order()
    {
        //Create a user with orders
        $user = User::factory()
        ->has(
            Product::factory()
                ->has(Inventory::factory()->count(1))
                ->has(Order::factory()->count(3),'orders')
                ->state([
                    'name' => 'product1'
                ])
                ->count(1)
        )
        ->create();

        $this->actingAs($user);

        $order = $user->orders()->first();

        $response = $this->get(route('orders.show', ['order' => $order->id]));

        $response->assertInertia(function($page) use($user, $order) {
            $page->component('Orders/Show')
            ->where('auth.user', $user)
            ->where('order.id' , $order->id)
            ->hasAll([
                'order.name',
                'order.product.id',
                'order.product.name',
                'order.product.brand',
                'order.inventory.id',
                'order.inventory.sku',
                'order.inventory.color',
                'order.inventory.size',
            ]);
        });
    }

    public function test_user_cant_view_other_people_orders()
    {
        //Create a user with orders
        $user = User::factory()
        ->has(
            Product::factory()
                ->has(Inventory::factory()->count(1))
                ->has(Order::factory()->count(3),'orders')
                ->count(1)
        )
        ->create();

        $user2 = User::factory()
        ->has(
            Product::factory()
                ->has(Inventory::factory()->count(1))
                ->has(Order::factory()->count(3),'orders')
                ->count(1)
        )
        ->create();

        $this->actingAs($user);

        //get other user  order
        $order = $user2->orders()->first();

        $response = $this->get(route('orders.show', ['order' => $order->id]));
        $response->assertForbidden();
    }
}
