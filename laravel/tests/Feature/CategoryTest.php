<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->adminUser = User::factory()->create([
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);
    }

    /**
     * 測試管理員可以訪問分類管理頁面
     */
    public function test_admin_can_access_category_management(): void
    {
        $response = $this->actingAs($this->adminUser)
            ->get('/admin/categories');
        
        $response->assertStatus(200);
        $response->assertViewIs('admin.categories');
    }

    /**
     * 測試管理員可以創建分類
     */
    public function test_admin_can_create_category(): void
    {
        $categoryData = [
            'cat_name' => '新測試分類',
            'cat_desc' => '這是新測試分類描述',
        ];

        $response = $this->actingAs($this->adminUser)
            ->post('/admin/categories', $categoryData);

        $response->assertRedirect('/admin/categories');
        $response->assertSessionHas('success');
        
        $this->assertDatabaseHas('category', [
            'cat_name' => '新測試分類',
        ]);
    }

    /**
     * 測試管理員可以更新分類
     */
    public function test_admin_can_update_category(): void
    {
        $category = Category::create([
            'cat_name' => '原始分類',
            'cat_desc' => '原始描述',
            'create_time' => now()->toDateTimeString(),
        ]);

        $updateData = [
            'cat_name' => '更新後分類',
            'cat_desc' => '更新後描述',
        ];

        $response = $this->actingAs($this->adminUser)
            ->put("/admin/categories/{$category->cat_id}", $updateData);

        $response->assertRedirect('/admin/categories');
        $response->assertSessionHas('success');
        
        $this->assertDatabaseHas('category', [
            'cat_id' => $category->cat_id,
            'cat_name' => '更新後分類',
        ]);
    }

    /**
     * 測試管理員可以刪除空分類
     */
    public function test_admin_can_delete_empty_category(): void
    {
        $category = Category::create([
            'cat_name' => '待刪除分類',
            'cat_desc' => '待刪除描述',
            'create_time' => now()->toDateTimeString(),
        ]);

        $response = $this->actingAs($this->adminUser)
            ->delete("/admin/categories/{$category->cat_id}");

        $response->assertRedirect('/admin/categories');
        $response->assertSessionHas('success');
        
        $this->assertDatabaseMissing('category', [
            'cat_id' => $category->cat_id,
        ]);
    }

    /**
     * 測試有產品的分類不能被刪除
     */
    public function test_category_with_products_cannot_be_deleted(): void
    {
        $category = Category::create([
            'cat_name' => '有產品的分類',
            'cat_desc' => '描述',
            'create_time' => now()->toDateTimeString(),
        ]);

        Product::create([
            'pro_name' => '測試產品',
            'pro_price' => 100.00,
            'pro_stock' => 10,
            'pro_desc' => '描述',
            'cat_id' => $category->cat_id,
            'create_time' => now()->toDateTimeString(),
        ]);

        $response = $this->actingAs($this->adminUser)
            ->delete("/admin/categories/{$category->cat_id}");

        $response->assertSessionHas('error');
        
        $this->assertDatabaseHas('category', [
            'cat_id' => $category->cat_id,
        ]);
    }

    /**
     * 測試分類創建需要名稱
     */
    public function test_category_creation_requires_name(): void
    {
        $categoryData = [
            'cat_name' => '',
            'cat_desc' => '描述',
        ];

        $response = $this->actingAs($this->adminUser)
            ->post('/admin/categories', $categoryData);

        $response->assertSessionHasErrors('cat_name');
    }

    /**
     * 測試分類與產品的關聯
     */
    public function test_category_has_many_products(): void
    {
        $category = Category::create([
            'cat_name' => '測試分類',
            'cat_desc' => '描述',
            'create_time' => now()->toDateTimeString(),
        ]);

        Product::create([
            'pro_name' => '產品1',
            'pro_price' => 100.00,
            'pro_stock' => 10,
            'pro_desc' => '描述',
            'cat_id' => $category->cat_id,
            'create_time' => now()->toDateTimeString(),
        ]);

        Product::create([
            'pro_name' => '產品2',
            'pro_price' => 200.00,
            'pro_stock' => 20,
            'pro_desc' => '描述',
            'cat_id' => $category->cat_id,
            'create_time' => now()->toDateTimeString(),
        ]);

        $this->assertEquals(2, $category->products()->count());
    }
}