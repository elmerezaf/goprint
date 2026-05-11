<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DesignerController extends Controller
{
    public function index($productId = null)
    {
        $templates = [
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
            ]
        ];

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
