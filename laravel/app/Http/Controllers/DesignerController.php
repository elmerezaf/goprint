<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DesignerController extends Controller
{
    private function getTemplates()
    {
        return [
            [
                'id' => 'business-card-1',
                'name' => '商务名片模板一',
                'width' => 90,
                'height' => 54,
                'preview' => 'data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="90" height="54" viewBox="0 0 90 54"><rect fill="white" width="90" height="54" stroke="#ccc" stroke-width="0.5"/><text x="45" y="20" text-anchor="middle" font-size="4">公司名称</text><text x="45" y="30" text-anchor="middle" font-size="3">姓名 - 职位</text><text x="45" y="40" text-anchor="middle" font-size="2">电话: 123-4567</text></svg>',
                'background' => '#ffffff'
            ],
            [
                'id' => 'business-card-2',
                'name' => '商务名片模板二',
                'width' => 90,
                'height' => 54,
                'preview' => 'data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="90" height="54" viewBox="0 0 90 54"><rect fill="#1a1a2e" width="90" height="54"/><rect fill="#16213e" x="0" y="0" width="90" height="15"/><text x="45" y="8" text-anchor="middle" font-size="3" fill="white">COMPANY</text><text x="45" y="30" text-anchor="middle" font-size="4" fill="white">姓名</text><text x="45" y="38" text-anchor="middle" font-size="2.5" fill="#aaa">职位</text><text x="45" y="48" text-anchor="middle" font-size="2" fill="#888">电话/邮箱</text></svg>',
                'background' => '#1a1a2e'
            ],
            [
                'id' => 'business-card-3',
                'name' => '简约名片模板',
                'width' => 90,
                'height' => 54,
                'preview' => 'data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="90" height="54" viewBox="0 0 90 54"><rect fill="#f8f9fa" width="90" height="54" stroke="#333" stroke-width="1"/><line x1="30" y1="0" x2="30" y2="54" stroke="#e0e0e0"/><text x="15" y="20" text-anchor="middle" font-size="5" fill="#333">LOGO</text><text x="60" y="18" text-anchor="middle" font-size="3.5">姓名</text><text x="60" y="26" text-anchor="middle" font-size="2.5" fill="#666">职位</text><text x="60" y="36" text-anchor="middle" font-size="2" fill="#888">电话</text><text x="60" y="44" text-anchor="middle" font-size="2" fill="#888">邮箱</text></svg>',
                'background' => '#f8f9fa'
            ],
            [
                'id' => 'flyer-1',
                'name' => '宣传单模板',
                'width' => 210,
                'height' => 297,
                'preview' => 'data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="210" height="297" viewBox="0 0 210 297"><rect fill="#fff" width="210" height="297" stroke="#ccc"/><rect fill="#4a90d9" width="210" height="80"/><text x="105" y="45" text-anchor="middle" font-size="8" fill="white">活动标题</text><text x="105" y="60" text-anchor="middle" font-size="4" fill="white">副标题</text><rect fill="#eee" x="20" y="100" width="170" height="150"/><text x="105" y="140" text-anchor="middle" font-size="4" fill="#333">内容区域</text><text x="105" y="180" text-anchor="middle" font-size="3" fill="#666">详细信息...</text><rect fill="#4a90d9" x="70" y="260" width="70" height="20" rx="10"/><text x="105" y="274" text-anchor="middle" font-size="3" fill="white">立即报名</text></svg>',
                'background' => '#ffffff'
            ],
            [
                'id' => 'poster-1',
                'name' => '海报模板',
                'width' => 420,
                'height' => 594,
                'preview' => 'data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="420" height="594" viewBox="0 0 420 594"><rect fill="#2d3436" width="420" height="594"/><text x="210" y="120" text-anchor="middle" font-size="12" fill="white">主标题</text><text x="210" y="160" text-anchor="middle" font-size="6" fill="#ddd">副标题</text><rect fill="#fff" x="40" y="200" width="340" height="280" opacity="0.1"/><text x="210" y="300" text-anchor="middle" font-size="5" fill="white">活动详情</text><text x="210" y="450" text-anchor="middle" font-size="4" fill="#aaa">日期：2024年1月1日</text><text x="210" y="480" text-anchor="middle" font-size="4" fill="#aaa">地点：XXX</text></svg>',
                'background' => '#2d3436'
            ],
            [
                'id' => 'invitation-1',
                'name' => '邀请函模板',
                'width' => 140,
                'height' => 210,
                'preview' => 'data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="140" height="210" viewBox="0 0 140 210"><rect fill="#fff5f5" width="140" height="210" stroke="#e91e63" stroke-width="2"/><line x1="20" y1="50" x2="120" y2="50" stroke="#e91e63" stroke-width="1"/><text x="70" y="35" text-anchor="middle" font-size="4" fill="#e91e63">INVITATION</text><text x="70" y="75" text-anchor="middle" font-size="5" fill="#333">诚邀出席</text><text x="70" y="100" text-anchor="middle" font-size="3.5" fill="#666">尊敬的贵宾</text><text x="70" y="130" text-anchor="middle" font-size="3" fill="#555">活动内容...</text><text x="70" y="170" text-anchor="middle" font-size="2.5" fill="#888">时间：XXX</text><text x="70" y="185" text-anchor="middle" font-size="2.5" fill="#888">地点：XXX</text></svg>',
                'background' => '#fff5f5'
            ],
            // ====== 新增 10 个模板 ======
            [
                'id' => 'modern-card',
                'name' => '现代蓝色名片',
                'width' => 90,
                'height' => 54,
                'preview' => 'data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="90" height="54" viewBox="0 0 90 54"><rect fill="#ffffff" width="90" height="54"/><rect fill="#2c6b9e" x="0" y="0" width="12" height="54"/><rect fill="#3a8bd4" x="0" y="0" width="12" height="20"/><text x="55" y="14" font-size="5" fill="#333" font-weight="bold">陈大明</text><text x="55" y="22" font-size="2.5" fill="#666">业务经理</text><text x="55" y="32" font-size="2" fill="#888">电话: +852 1234 5678</text><text x="55" y="38" font-size="2" fill="#888">邮箱: info@company.com</text><text x="55" y="44" font-size="2" fill="#888">地址: 香港中环皇后大道中88号</text><text x="55" y="50" font-size="1.8" fill="#aaa">www.company.com.hk</text></svg>',
                'background' => '#ffffff'
            ],
            [
                'id' => 'luxury-card',
                'name' => '奢华金色名片',
                'width' => 90,
                'height' => 54,
                'preview' => 'data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="90" height="54" viewBox="0 0 90 54"><rect fill="#1a1a1a" width="90" height="54"/><rect fill="#d4a843" x="0" y="22" width="90" height="10"/><text x="45" y="12" text-anchor="middle" font-size="5" fill="#d4a843" font-weight="bold">陈大明</text><text x="45" y="20" text-anchor="middle" font-size="2.5" fill="#aaa">总经理</text><text x="45" y="38" text-anchor="middle" font-size="2.5" fill="#d4a843">+852 1234 5678</text><text x="45" y="45" text-anchor="middle" font-size="2" fill="#777">info@company.com.hk</text><text x="45" y="51" text-anchor="middle" font-size="2" fill="#555">www.company.com.hk</text></svg>',
                'background' => '#1a1a1a'
            ],
            [
                'id' => 'letterhead',
                'name' => '公司信纸模板',
                'width' => 210,
                'height' => 297,
                'preview' => 'data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="210" height="297" viewBox="0 0 210 297"><rect fill="#fff" width="210" height="297"/><rect fill="#2c3e50" width="210" height="25"/><text x="15" y="17" font-size="7" fill="white" font-weight="bold">公司名称有限公司</text><line x1="15" y1="30" x2="195" y2="30" stroke="#2c3e50" stroke-width="0.5"/><text x="15" y="50" font-size="4" fill="#333">日期：2026年5月11日</text><text x="15" y="65" font-size="4" fill="#333">致：收件人</text><text x="15" y="90" font-size="4" fill="#333">主题：信件标题</text><text x="15" y="120" font-size="3.5" fill="#555">尊敬的先生/女士：</text><text x="15" y="145" font-size="3.5" fill="#555">正文内容区域，此处填写信件的主要内容。</text><text x="15" y="160" font-size="3.5" fill="#555">详细说明相关事宜，包括背景信息、</text><text x="15" y="175" font-size="3.5" fill="#555">具体方案及预期结果等。</text><text x="15" y="210" font-size="3.5" fill="#555">此致</text><text x="15" y="230" font-size="3.5" fill="#555">敬礼！</text><text x="170" y="260" text-anchor="end" font-size="3.5" fill="#333">签名：______________</text><rect fill="#2c3e50" x="0" y="282" width="210" height="15"/><text x="15" y="292" font-size="2.5" fill="white">电话: +852 1234 5678 | 地址: 香港中环皇后大道中88号</text></svg>',
                'background' => '#ffffff'
            ],
            [
                'id' => 'sale-poster',
                'name' => '大减价海报',
                'width' => 297,
                'height' => 420,
                'preview' => 'data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="297" height="420" viewBox="0 0 297 420"><rect fill="#e74c3c" width="297" height="420"/><rect fill="#c0392b" y="0" width="297" height="150"/><text x="148" y="80" text-anchor="middle" font-size="20" fill="white" font-weight="bold">大 减 价</text><text x="148" y="115" text-anchor="middle" font-size="8" fill="#ffcc00">低至半价</text><text x="148" y="140" text-anchor="middle" font-size="5" fill="white">限时优惠</text><circle cx="148" cy="240" r="60" fill="#ffcc00"/><text x="148" y="235" text-anchor="middle" font-size="10" fill="#c0392b" font-weight="bold">50%</text><text x="148" y="255" text-anchor="middle" font-size="4" fill="#c0392b">OFF</text><rect fill="white" x="60" y="320" width="177" height="40" rx="5"/><text x="148" y="345" text-anchor="middle" font-size="4" fill="#c0392b" font-weight="bold">立即抢购</text><text x="148" y="390" text-anchor="middle" font-size="3" fill="#ffcc00">优惠期至 2026年6月30日</text><text x="148" y="410" text-anchor="middle" font-size="2.5" fill="white">地址：香港中环皇后大道中88号</text></svg>',
                'background' => '#e74c3c'
            ],
            [
                'id' => 'wedding-invitation',
                'name' => '婚礼邀请函',
                'width' => 140,
                'height' => 210,
                'preview' => 'data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="140" height="210" viewBox="0 0 140 210"><rect fill="#fdf2f2" width="140" height="210"/><rect fill="#f8e8e8" x="10" y="10" width="120" height="190"/><line x1="20" y1="50" x2="120" y2="50" stroke="#e8b4b4" stroke-width="0.5"/><line x1="20" y1="170" x2="120" y2="170" stroke="#e8b4b4" stroke-width="0.5"/><text x="70" y="40" text-anchor="middle" font-size="3.5" fill="#c47a7a" font-weight="bold">WEDDING INVITATION</text><text x="70" y="80" text-anchor="middle" font-size="5" fill="#b84c4c">张小明 &amp; 李美玲</text><text x="70" y="105" text-anchor="middle" font-size="3" fill="#666">诚邀您出席我们的婚礼</text><text x="70" y="130" text-anchor="middle" font-size="2.5" fill="#888">2026年6月15日 (星期日)</text><text x="70" y="145" text-anchor="middle" font-size="2.5" fill="#888">中午十二时正</text><text x="70" y="160" text-anchor="middle" font-size="2.5" fill="#888">香港君悦酒店宴会厅</text><text x="70" y="190" text-anchor="middle" font-size="2.5" fill="#c47a7a">敬请赐覆</text></svg>',
                'background' => '#fdf2f2'
            ],
            [
                'id' => 'restaurant-menu',
                'name' => '餐厅餐牌',
                'width' => 210,
                'height' => 297,
                'preview' => 'data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="210" height="297" viewBox="0 0 210 297"><rect fill="#1a1a1a" width="210" height="297"/><rect fill="#f5f0e8" x="5" y="5" width="200" height="287"/><text x="105" y="35" text-anchor="middle" font-size="8" fill="#333" font-weight="bold">美 食 餐 牌</text><line x1="30" y1="45" x2="180" y2="45" stroke="#c4a46c"/><text x="20" y="70" font-size="4" fill="#c4a46c" font-weight="bold">-- 前菜 STARTERS</text><text x="20" y="90" font-size="3.5" fill="#555">凯撒沙律</text><text x="180" y="90" text-anchor="end" font-size="3.5" fill="#555">$48</text><text x="20" y="110" font-size="3.5" fill="#555">意大利杂菜汤</text><text x="180" y="110" text-anchor="end" font-size="3.5" fill="#555">$38</text><text x="20" y="140" font-size="4" fill="#c4a46c" font-weight="bold">-- 主菜 MAINS</text><text x="20" y="160" font-size="3.5" fill="#555">安格斯牛扒</text><text x="180" y="160" text-anchor="end" font-size="3.5" fill="#555">$168</text><text x="20" y="180" font-size="3.5" fill="#555">香煎三文鱼</text><text x="180" y="180" text-anchor="end" font-size="3.5" fill="#555">$128</text><text x="20" y="200" font-size="3.5" fill="#555">黑松露意大利面</text><text x="180" y="200" text-anchor="end" font-size="3.5" fill="#555">$98</text><text x="20" y="230" font-size="4" fill="#c4a46c" font-weight="bold">-- 甜品 DESSERTS</text><text x="20" y="250" font-size="3.5" fill="#555">提拉米苏</text><text x="180" y="250" text-anchor="end" font-size="3.5" fill="#555">$58</text><text x="20" y="270" font-size="3.5" fill="#555">芝士蛋糕</text><text x="180" y="270" text-anchor="end" font-size="3.5" fill="#555">$48</text></svg>',
                'background' => '#f5f0e8'
            ],
            [
                'id' => 'product-label',
                'name' => '产品标签模板',
                'width' => 100,
                'height' => 100,
                'preview' => 'data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><rect fill="#fff" width="100" height="100"/><circle cx="50" cy="50" r="45" fill="#f0f8ff" stroke="#3498db" stroke-width="1"/><circle cx="50" cy="50" r="35" fill="none" stroke="#3498db" stroke-width="0.5"/><text x="50" y="35" text-anchor="middle" font-size="5" fill="#3498db" font-weight="bold">优质</text><text x="50" y="50" text-anchor="middle" font-size="4" fill="#333" font-weight="bold">产品名称</text><text x="50" y="65" text-anchor="middle" font-size="2.5" fill="#666">净重: 500g</text><text x="50" y="80" text-anchor="middle" font-size="2" fill="#888">www.company.com</text></svg>',
                'background' => '#ffffff'
            ],
            [
                'id' => 'event-flyer',
                'name' => '活动宣传单',
                'width' => 210,
                'height' => 297,
                'preview' => 'data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="210" height="297" viewBox="0 0 210 297"><rect fill="#6c5ce7" width="210" height="297"/><rect fill="#5a4bd1" y="0" width="210" height="120"/><text x="105" y="50" text-anchor="middle" font-size="10" fill="white" font-weight="bold">年度音乐节</text><text x="105" y="75" text-anchor="middle" font-size="5" fill="#e8e4ff">2026.07.15 - 07.17</text><text x="105" y="100" text-anchor="middle" font-size="3.5" fill="#ccc">香港西九龙文化区</text><rect fill="#ffcc00" x="55" y="150" width="100" height="100" rx="10" opacity="0.15"/><text x="105" y="180" text-anchor="middle" font-size="5" fill="#ffcc00" font-weight="bold">30+</text><text x="105" y="195" text-anchor="middle" font-size="3" fill="#eee">表演嘉宾</text><text x="105" y="225" text-anchor="middle" font-size="5" fill="#ffcc00" font-weight="bold">3</text><text x="105" y="240" text-anchor="middle" font-size="3" fill="#eee">舞台</text><rect fill="#ff6b6b" x="50" y="270" width="110" height="15" rx="7"/><text x="105" y="281" text-anchor="middle" font-size="3.5" fill="white" font-weight="bold">立即购票</text></svg>',
                'background' => '#6c5ce7'
            ],
            [
                'id' => 'certificate',
                'name' => '荣誉证书模板',
                'width' => 210,
                'height' => 297,
                'preview' => 'data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="210" height="297" viewBox="0 0 210 297"><rect fill="#faf8f0" width="210" height="297"/><rect fill="none" x="10" y="10" width="190" height="277" stroke="#c4a46c" stroke-width="1"/><rect fill="none" x="15" y="15" width="180" height="267" stroke="#c4a46c" stroke-width="0.5"/><text x="105" y="60" text-anchor="middle" font-size="8" fill="#c4a46c" font-weight="bold">荣誉证书</text><text x="105" y="90" text-anchor="middle" font-size="4" fill="#c4a46c">CERTIFICATE OF APPRECIATION</text><line x1="40" y1="105" x2="170" y2="105" stroke="#c4a46c" stroke-width="0.5"/><text x="105" y="135" text-anchor="middle" font-size="3" fill="#555">兹颁予</text><text x="105" y="165" text-anchor="middle" font-size="6" fill="#333" font-weight="bold">获奖者姓名</text><text x="105" y="195" text-anchor="middle" font-size="3" fill="#555">以表彰您在过往一年中的卓越贡献</text><text x="105" y="230" text-anchor="middle" font-size="3" fill="#555">特颁此证，以资鼓励</text><text x="60" y="270" font-size="2.5" fill="#666">签发人：______________</text><text x="150" y="270" text-anchor="end" font-size="2.5" fill="#666">日期：2026年5月11日</text></svg>',
                'background' => '#faf8f0'
            ],
            [
                'id' => 'brochure-cover',
                'name' => '公司简介封面',
                'width' => 210,
                'height' => 297,
                'preview' => 'data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="210" height="297" viewBox="0 0 210 297"><rect fill="#2d3436" width="210" height="297"/><line x1="70" y1="0" x2="70" y2="297" stroke="#555" stroke-width="0.5" opacity="0.3"/><line x1="140" y1="0" x2="140" y2="297" stroke="#555" stroke-width="0.5" opacity="0.3"/><rect fill="none" x="5" y="5" width="200" height="287" stroke="#6c5ce7" stroke-width="0.5"/><text x="175" y="30" text-anchor="middle" font-size="4" fill="#6c5ce7">封面</text><text x="105" y="100" text-anchor="middle" font-size="9" fill="white" font-weight="bold">公司简介</text><text x="105" y="130" text-anchor="middle" font-size="4" fill="#6c5ce7">COMPANY PROFILE</text><line x1="60" y1="145" x2="150" y2="145" stroke="#6c5ce7"/><text x="105" y="170" text-anchor="middle" font-size="3" fill="#aaa">您的信赖，我们的承诺</text><text x="105" y="190" text-anchor="middle" font-size="2.5" fill="#777">成立于2000年 · 服务香港20+年</text><text x="105" y="260" text-anchor="middle" font-size="2.5" fill="#555">公司名称有限公司</text><text x="105" y="275" text-anchor="middle" font-size="2" fill="#555">www.company.com.hk</text></svg>',
                'background' => '#2d3436'
            ],
        ];
    }

    public function index($productId = null)
    {
        $templates = $this->getTemplates();

        $shapes = [
            ['type' => 'rect', 'name' => '矩形', 'icon' => 'rectangle'],
            ['type' => 'circle', 'name' => '圆形', 'icon' => 'circle'],
            ['type' => 'triangle', 'name' => '三角形', 'icon' => 'triangle'],
            ['type' => 'line', 'name' => '线条', 'icon' => 'minus']
        ];

        $fonts = [
            ['name' => 'SimHei', 'label' => '黑体'],
            ['name' => 'SimSun', 'label' => '宋体'],
            ['name' => 'Microsoft YaHei', 'label' => '微软雅黑'],
            ['name' => 'KaiTi', 'label' => '楷体'],
            ['name' => 'Arial', 'label' => 'Arial'],
            ['name' => 'Times New Roman', 'label' => 'Times New Roman']
        ];

        $colors = [
            '#000000', '#ffffff', '#333333', '#666666', '#999999',
            '#e74c3c', '#3498db', '#2ecc71', '#f39c12', '#9b59b6',
            '#1abc9c', '#e91e63', '#ff5722', '#00bcd4', '#ff9800'
        ];

        return view('designer.index', compact('templates', 'shapes', 'fonts', 'colors', 'productId'));
    }

    public function export(Request $request)
    {
        $data = $request->input('design_data');
        
        return response()->json([
            'success' => true,
            'message' => '设计已保存',
            'data' => $data
        ]);
    }
}
