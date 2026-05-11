<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;
    protected $regularUser;
    protected $category;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->adminUser = User::factory()->create([
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);
        
        $this->regularUser = User::factory()->create([
            'role' => 'user',
            'email_verified_at' => now(),
        ]);
        
        $this->category = Category::create([
            'cat_name' => '測試分類',
            'cat_desc' => '描述',
            'create_time' => now()->toDateTimeString(),
        ]);
    }

    /**
     * 測試管理員可以訪問管理後台
     */
    public function test_admin_can_access_admin_dashboard(): void
    {
        $response = $this->actingAs($this->adminUser)
            ->get('/admin');
        
        $response->assertStatus(200);
        $response->assertViewIs('admin.dashboard');
    }

    /**
     * 測試普通用戶不能訪問管理後台
     */
    public function test_regular_user_cannot_access_admin_dashboard(): void
    {
        $response = $this->actingAs($this->regularUser)
            ->get('/admin');
        
        $response->assertStatus(403);
    }

    /**
     * 測試未登入用戶不能訪問管理後台
     */
    public function test_guest_cannot_access_admin_dashboard(): void
    {
        $response = $this->get('/admin');
        $response->assertRedirect('/login');
    }

    /**
     * 測試管理後台統計數據
     */
    public function test_admin_dashboard_shows_statistics(): void
    {
        // 創建訂單
        Order::create([
            'user_id' => $this->regularUser->id,
            'name' => '客戶',
            'phone' => '1234567890',
            'email' => 'test@example.com',
            'product' => '產品',
            'size' => 'A4',
            'material' => '紙張',
            'quantity' => 10,
            'price' => 100.00,
            'status' => 'pending',
            'file' => 'test.pdf',
        ]);

        Order::create([
            'user_id' => $this->regularUser->id,
            'name' => '客戶2',
            'phone' => '1234567891',
            'email' => 'test2@example.com',
            'product' => '產品2',
            'size' => 'A3',
            'material' => '紙張',
            'quantity' => 5,
            'price' => 200.00,
            'status' => 'completed',
            'file' => 'test2.pdf',
        ]);

        $response = $this->actingAs($this->adminUser)
            ->get('/admin');
        
        $response->assertStatus(200);
        $response->assertViewHas('totalOrders', 2);
        $response->assertViewHas('pendingOrders', 1);
        $response->assertViewHas('completedOrders', 1);
    }

    /**
     * 測試管理員可以訪問統計報表
     */
    public function test_admin_can_access_reports(): void
    {
        $response = $this->actingAs($this->adminUser)
            ->get('/admin/reports');
        
        $response->assertStatus(200);
        $response->assertViewIs('admin.reports');
    }

    /**
     * 測試普通用戶不能訪問統計報表
     */
    public function test_regular_user_cannot_access_reports(): void
    {
        $response = $this->actingAs($this->regularUser)
            ->get('/admin/reports');
        
        $response->assertStatus(403);
    }

    /**
     * 測試報表頁面顯示正確數據
     */
    public function test_reports_page_shows_correct_data(): void
    {
        // 創建產品
        Product::create([
            'pro_name' => '產品1',
            'pro_price' => 100.00,
            'pro_stock' => 10,
            'pro_desc' => '描述',
            'cat_id' => $this->category->cat_id,
            'create_time' => now()->toDateTimeString(),
        ]);

        // 創建訂單
        Order::create([
            'user_id' => $this->regularUser->id,
            'name' => '客戶',
            'phone' => '1234567890',
            'email' => 'test@example.com',
            'product' => '產品',
            'size' => 'A4',
            'material' => '紙張',
            'quantity' => 10,
            'price' => 100.00,
            'status' => 'completed',
            'file' => 'test.pdf',
        ]);

        $response = $this->actingAs($this->adminUser)
            ->get('/admin/reports');
        
        $response->assertStatus(200);
        $response->assertViewHas('totalProducts', 1);
        $response->assertViewHas('totalCategories', 1);
        $response->assertViewHas('totalOrders', 1);
    }

    /**
     * 測試管理員權限中間件
     */
    public function test_admin_middleware_blocks_unauthorized_users(): void
    {
        $protectedRoutes = [
            '/admin',
            '/admin/orders',
            '/admin/products',
            '/admin/categories',
            '/admin/reports',
        ];

        foreach ($protectedRoutes as $route) {
            // 測試普通用戶
            $response = $this->actingAs($this->regularUser)->get($route);
            $response->assertStatus(403);

            // 測試未登入用戶
            $response = $this->get($route);
            $response->assertRedirect('/login');
        }
    }

    /**
     * 測試管理員可以訪問所有管理功能
     */
    public function test_admin_can_access_all_management_features(): void
    {
        $routes = [
            '/admin' => 200,
            '/admin/orders' => 200,
            '/admin/products' => 200,
            '/admin/categories' => 200,
            '/admin/reports' => 200,
        ];

        foreach ($routes as $route => $expectedStatus) {
            $response = $this->actingAs($this->adminUser)->get($route);
            $response->assertStatus($expectedStatus);
        }
    }
}