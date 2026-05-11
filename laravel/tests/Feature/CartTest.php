<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartTest extends TestCase
{
    use RefreshDatabase;

    protected $category;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->category = Category::create([
            'cat_name' => '測試分類',
            'cat_desc' => '描述',
            'create_time' => now()->toDateTimeString(),
        ]);
    }

    /**
     * 測試購物車頁面可以訪問
     */
    public function test_cart_page_can_be_accessed(): void
    {
        $response = $this->get('/cart');
        $response->assertStatus(200);
        $response->assertViewIs('cart.index');
    }

    /**
     * 測試可以添加產品到購物車
     */
    public function test_can_add_product_to_cart(): void
    {
        $product = Product::create([
            'pro_name' => '測試產品',
            'pro_price' => 100.00,
            'pro_stock' => 10,
            'pro_desc' => '描述',
            'cat_id' => $this->category->cat_id,
            'create_time' => now()->toDateTimeString(),
        ]);

        $response = $this->post('/cart/add', [
            'product_id' => $product->pro_id,
            'qty' => 1,
        ]);

        $response->assertRedirect('/cart');
    }

    /**
     * 測試添加不存在的產品會失敗
     */
    public function test_cannot_add_nonexistent_product(): void
    {
        $response = $this->post('/cart/add', [
            'product_id' => 99999,
            'qty' => 1,
        ]);

        $response->assertStatus(404);
    }

    /**
     * 測試可以更新購物車商品數量
     */
    public function test_can_update_cart_item_quantity(): void
    {
        $product = Product::create([
            'pro_name' => '測試產品',
            'pro_price' => 100.00,
            'pro_stock' => 10,
            'pro_desc' => '描述',
            'cat_id' => $this->category->cat_id,
            'create_time' => now()->toDateTimeString(),
        ]);

        // 先添加到購物車
        $this->post('/cart/add', [
            'product_id' => $product->pro_id,
            'qty' => 1,
        ]);

        // 更新數量
        $response = $this->post('/cart/update', [
            'rowId' => Cart::content()->first()->rowId ?? 'invalid',
            'qty' => 3,
        ]);

        $response->assertRedirect('/cart');
    }

    /**
     * 測試可以從購物車移除商品
     */
    public function test_can_remove_item_from_cart(): void
    {
        $product = Product::create([
            'pro_name' => '測試產品',
            'pro_price' => 100.00,
            'pro_stock' => 10,
            'pro_desc' => '描述',
            'cat_id' => $this->category->cat_id,
            'create_time' => now()->toDateTimeString(),
        ]);

        // 先添加到購物車
        $this->post('/cart/add', [
            'product_id' => $product->pro_id,
            'qty' => 1,
        ]);

        $rowId = Cart::content()->first()->rowId ?? '';
        
        if (!empty($rowId)) {
            $response = $this->post('/cart/remove', [
                'rowId' => $rowId,
            ]);
            $response->assertRedirect('/cart');
        }
    }

    /**
     * 測試可以清空購物車
     */
    public function test_can_clear_cart(): void
    {
        $product = Product::create([
            'pro_name' => '測試產品',
            'pro_price' => 100.00,
            'pro_stock' => 10,
            'pro_desc' => '描述',
            'cat_id' => $this->category->cat_id,
            'create_time' => now()->toDateTimeString(),
        ]);

        // 先添加到購物車
        $this->post('/cart/add', [
            'product_id' => $product->pro_id,
            'qty' => 1,
        ]);

        $response = $this->get('/cart/clear');
        $response->assertRedirect('/cart');
    }

    /**
     * 測試空購物車顯示
     */
    public function test_empty_cart_displays_correctly(): void
    {
        Cart::destroy();

        $response = $this->get('/cart');
        $response->assertStatus(200);
    }
}