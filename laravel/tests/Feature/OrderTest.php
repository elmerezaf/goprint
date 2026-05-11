<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
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
     * 測試管理員可以訪問訂單列表
     */
    public function test_admin_can_access_orders_list(): void
    {
        $response = $this->actingAs($this->adminUser)
            ->get('/admin/orders');
        
        $response->assertStatus(200);
        $response->assertViewIs('admin.orders');
    }

    /**
     * 測試管理員可以查看訂單詳情
     */
    public function test_admin_can_view_order_detail(): void
    {
        $order = Order::create([
            'user_id' => $this->regularUser->id,
            'name' => '測試客戶',
            'phone' => '1234567890',
            'email' => 'test@example.com',
            'product' => '測試產品',
            'size' => 'A4',
            'material' => '紙張',
            'quantity' => 10,
            'price' => 100.00,
            'status' => 'pending',
            'file' => 'test.pdf',
        ]);

        $response = $this->actingAs($this->adminUser)
            ->get("/admin/order/{$order->id}");
        
        $response->assertStatus(200);
        $response->assertViewIs('admin.order-detail');
    }

    /**
     * 測試管理員可以更新訂單狀態
     */
    public function test_admin_can_update_order_status(): void
    {
        $order = Order::create([
            'user_id' => $this->regularUser->id,
            'name' => '測試客戶',
            'phone' => '1234567890',
            'email' => 'test@example.com',
            'product' => '測試產品',
            'size' => 'A4',
            'material' => '紙張',
            'quantity' => 10,
            'price' => 100.00,
            'status' => 'pending',
            'file' => 'test.pdf',
        ]);

        $response = $this->actingAs($this->adminUser)
            ->post("/admin/order/{$order->id}/status", [
                'status' => 'completed',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'completed',
        ]);
    }

    /**
     * 測試管理員可以刪除訂單
     */
    public function test_admin_can_delete_order(): void
    {
        $order = Order::create([
            'user_id' => $this->regularUser->id,
            'name' => '測試客戶',
            'phone' => '1234567890',
            'email' => 'test@example.com',
            'product' => '測試產品',
            'size' => 'A4',
            'material' => '紙張',
            'quantity' => 10,
            'price' => 100.00,
            'status' => 'pending',
            'file' => 'test.pdf',
        ]);

        $response = $this->actingAs($this->adminUser)
            ->delete("/admin/order/{$order->id}");

        $response->assertRedirect('/admin/orders');
        $response->assertSessionHas('success');
        
        $this->assertDatabaseMissing('orders', [
            'id' => $order->id,
        ]);
    }

    /**
     * 測試普通用戶不能訪問訂單管理
     */
    public function test_regular_user_cannot_access_order_management(): void
    {
        $response = $this->actingAs($this->regularUser)
            ->get('/admin/orders');
        
        $response->assertStatus(403);
    }

    /**
     * 測試訂單統計數據
     */
    public function test_order_statistics(): void
    {
        // 創建多個訂單
        Order::create([
            'user_id' => $this->regularUser->id,
            'name' => '客戶1',
            'phone' => '1234567890',
            'email' => 'test1@example.com',
            'product' => '產品1',
            'size' => 'A4',
            'material' => '紙張',
            'quantity' => 10,
            'price' => 100.00,
            'status' => 'pending',
            'file' => 'test1.pdf',
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

        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $completedOrders = Order::where('status', 'completed')->count();
        $totalRevenue = Order::where('status', 'completed')->sum('price');

        $this->assertEquals(2, $totalOrders);
        $this->assertEquals(1, $pendingOrders);
        $this->assertEquals(1, $completedOrders);
        $this->assertEquals(200.00, $totalRevenue);
    }

    /**
     * 測試訂單與用戶的關聯
     */
    public function test_order_belongs_to_user(): void
    {
        $order = Order::create([
            'user_id' => $this->regularUser->id,
            'name' => '測試客戶',
            'phone' => '1234567890',
            'email' => 'test@example.com',
            'product' => '測試產品',
            'size' => 'A4',
            'material' => '紙張',
            'quantity' => 10,
            'price' => 100.00,
            'status' => 'pending',
            'file' => 'test.pdf',
        ]);

        $this->assertEquals($this->regularUser->id, $order->user_id);
    }
}