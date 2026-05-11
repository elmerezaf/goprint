<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;
    protected $category;

    protected function setUp(): void
    {
        parent::setUp();
        
        // 創建管理員用戶
        $this->adminUser = User::factory()->create([
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);
        
        // 創建測試分類
        $this->category = Category::create([
            'cat_name' => '測試分類',
            'cat_desc' => '這是測試分類',
            'create_time' => now()->toDateTimeString(),
        ]);
    }

    /**
     * 測試產品列表頁面
     */
    public function test_products_page_can_be_accessed(): void
    {
        $response = $this->get('/products');
        $response->assertStatus(200);
        $response->assertViewIs('products.index');
    }

    /**
     * 測試產品詳情頁面
     */
    public function test_product_detail_page_can_be_accessed(): void
    {
        $product = Product::create([
            'pro_name' => '測試產品',
            'pro_price' => 100.00,
            'pro_stock' => 10,
            'pro_desc' => '這是測試產品描述',
            'cat_id' => $this->category->cat_id,
            'create_time' => now()->toDateTimeString(),
        ]);

        $response = $this->get("/product/{$product->pro_id}");
        $response->assertStatus(200);
        $response->assertViewIs('products.show');
        $response->assertViewHas('product', $product);
    }

    /**
     * 測試管理員可以訪問產品管理頁面
     */
    public function test_admin_can_access_product_management(): void
    {
        $response = $this->actingAs($this->adminUser)
            ->get('/admin/products');
        
        $response->assertStatus(200);
        $response->assertViewIs('admin.products');
    }

    /**
     * 測試普通用戶不能訪問產品管理頁面
     */
    public function test_regular_user_cannot_access_product_management(): void
    {
        $regularUser = User::factory()->create([
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($regularUser)
            ->get('/admin/products');
        
        $response->assertStatus(403);
    }

    /**
     * 測試管理員可以創建產品
     */
    public function test_admin_can_create_product(): void
    {
        Storage::fake('public');

        $productData = [
            'pro_name' => '新測試產品',
            'pro_price' => 150.00,
            'pro_stock' => 20,
            'pro_desc' => '這是新測試產品描述',
            'cat_id' => $this->category->cat_id,
        ];

        $response = $this->actingAs($this->adminUser)
            ->post('/admin/products', $productData);

        $response->assertRedirect('/admin/products');
        $response->assertSessionHas('success');
        
        $this->assertDatabaseHas('product', [
            'pro_name' => '新測試產品',
            'pro_price' => 150.00,
        ]);
    }

    /**
     * 測試管理員可以更新產品
     */
    public function test_admin_can_update_product(): void
    {
        $product = Product::create([
            'pro_name' => '原始產品',
            'pro_price' => 100.00,
            'pro_stock' => 10,
            'pro_desc' => '原始描述',
            'cat_id' => $this->category->cat_id,
            'create_time' => now()->toDateTimeString(),
        ]);

        $updateData = [
            'pro_name' => '更新後產品',
            'pro_price' => 200.00,
            'pro_stock' => 30,
            'pro_desc' => '更新後描述',
            'cat_id' => $this->category->cat_id,
        ];

        $response = $this->actingAs($this->adminUser)
            ->put("/admin/products/{$product->pro_id}", $updateData);

        $response->assertRedirect('/admin/products');
        $response->assertSessionHas('success');
        
        $this->assertDatabaseHas('product', [
            'pro_id' => $product->pro_id,
            'pro_name' => '更新後產品',
            'pro_price' => 200.00,
        ]);
    }

    /**
     * 測試管理員可以刪除產品
     */
    public function test_admin_can_delete_product(): void
    {
        $product = Product::create([
            'pro_name' => '待刪除產品',
            'pro_price' => 100.00,
            'pro_stock' => 10,
            'pro_desc' => '待刪除描述',
            'cat_id' => $this->category->cat_id,
            'create_time' => now()->toDateTimeString(),
        ]);

        $response = $this->actingAs($this->adminUser)
            ->delete("/admin/products/{$product->pro_id}");

        $response->assertRedirect('/admin/products');
        $response->assertSessionHas('success');
        
        $this->assertDatabaseMissing('product', [
            'pro_id' => $product->pro_id,
        ]);
    }

    /**
     * 測試產品創建驗證
     */
    public function test_product_creation_requires_name(): void
    {
        $productData = [
            'pro_name' => '',
            'pro_price' => 150.00,
            'pro_stock' => 20,
            'cat_id' => $this->category->cat_id,
        ];

        $response = $this->actingAs($this->adminUser)
            ->post('/admin/products', $productData);

        $response->assertSessionHasErrors('pro_name');
    }

    /**
     * 測試產品價格必須是數字
     */
    public function test_product_price_must_be_numeric(): void
    {
        $productData = [
            'pro_name' => '測試產品',
            'pro_price' => 'invalid',
            'pro_stock' => 20,
            'cat_id' => $this->category->cat_id,
        ];

        $response = $this->actingAs($this->adminUser)
            ->post('/admin/products', $productData);

        $response->assertSessionHasErrors('pro_price');
    }

    /**
     * 測試產品庫存必須是整數
     */
    public function test_product_stock_must_be_integer(): void
    {
        $productData = [
            'pro_name' => '測試產品',
            'pro_price' => 150.00,
            'pro_stock' => 'invalid',
            'cat_id' => $this->category->cat_id,
        ];

        $response = $this->actingAs($this->adminUser)
            ->post('/admin/products', $productData);

        $response->assertSessionHasErrors('pro_stock');
    }
}