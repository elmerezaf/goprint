<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Design;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class DesignerController extends Controller
{
    private function getTemplates()
    {
        $configTemplates = config('templates.default', []);

        if (!empty($configTemplates)) {
            foreach ($configTemplates as &$t) {
                $t['preview'] = 'data:image/svg+xml;base64,' . base64_encode($t['svg']);
            }
            return $configTemplates;
        }

        return $this->getDefaultTemplates();
    }

    private function getDefaultTemplates()
    {
        $templates = [
            // === 名片模板 ===
            [
                'id' => 'biz-card-gradient-1',
                'name' => '渐变科技风名片',
                'category' => 'business-card',
                'category_name' => '名片',
                'width' => 90,
                'height' => 54,
                'background' => '#667eea',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="90" height="54" viewBox="0 0 90 54"><defs><linearGradient id="bg1" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#667eea"/><stop offset="100%" style="stop-color:#764ba2"/></linearGradient></defs><rect fill="url(#bg1)" x="2" y="2" width="86" height="50" rx="2"/><circle cx="20" cy="27" r="12" fill="rgba(255,255,255,0.2)"/><text x="20" y="25" text-anchor="middle" font-size="4" fill="white">IT</text><text x="55" y="18" font-size="5" fill="white" font-weight="bold">张科技</text><text x="55" y="26" font-size="2.5" fill="rgba(255,255,255,0.8)">技术总监</text><text x="55" y="36" font-size="2" fill="rgba(255,255,255,0.7)">+852 9876 5432</text><text x="55" y="44" font-size="1.8" fill="rgba(255,255,255,0.6)">tech@company.hk</text></svg>'
            ],
            [
                'id' => 'biz-card-minimal-white',
                'name' => '极简白名片',
                'category' => 'business-card',
                'category_name' => '名片',
                'width' => 90,
                'height' => 54,
                'background' => '#ffffff',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="90" height="54" viewBox="0 0 90 54"><rect fill="white" x="2" y="2" width="86" height="50" rx="2" stroke="#ddd" stroke-width="0.5"/><rect fill="#000" x="2" y="2" width="3" height="50"/><text x="15" y="20" font-size="5" fill="#000" font-weight="bold">李简约</text><text x="15" y="30" font-size="2.5" fill="#666">设计师</text><line x1="15" y1="38" x2="85" y2="38" stroke="#ddd"/><text x="15" y="48" font-size="2" fill="#999">+852 1234 5678</text></svg>'
            ],
            [
                'id' => 'biz-card-creative',
                'name' => '创意撞色名片',
                'category' => 'business-card',
                'category_name' => '名片',
                'width' => 90,
                'height' => 54,
                'background' => '#ffecd2',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="90" height="54" viewBox="0 0 90 54"><rect fill="#ffecd2" x="2" y="2" width="86" height="50" rx="2"/><circle cx="75" cy="10" r="20" fill="#fcb69f" opacity="0.6"/><circle cx="10" cy="50" r="15" fill="#ff9a9e" opacity="0.5"/><text x="20" y="25" font-size="5" fill="#333" font-weight="bold">王创意</text><text x="20" y="35" font-size="2.5" fill="#666">创意总监</text><text x="20" y="48" font-size="1.8" fill="#999">design@art.hk</text></svg>'
            ],
            [
                'id' => 'biz-card-elegant',
                'name' => '优雅深蓝名片',
                'category' => 'business-card',
                'category_name' => '名片',
                'width' => 90,
                'height' => 54,
                'background' => '#0c3483',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="90" height="54" viewBox="0 0 90 54"><rect fill="#0c3483" x="2" y="2" width="86" height="50" rx="2"/><rect fill="#1a1a1a" x="2" y="2" width="23" height="50"/><circle cx="12" cy="27" r="8" fill="#c9a227"/><text x="35" y="20" font-size="4.5" fill="#fff" font-weight="bold">陈优雅</text><text x="35" y="30" font-size="2.5" fill="#a0b4c8">财务总监</text><text x="35" y="42" font-size="1.8" fill="#7a8da3">+852 2345 6789</text><text x="35" y="50" font-size="1.5" fill="#5c7391">finance@elegance.hk</text></svg>'
            ],
            [
                'id' => 'biz-card-nature',
                'name' => '自然绿色名片',
                'category' => 'business-card',
                'category_name' => '名片',
                'width' => 90,
                'height' => 54,
                'background' => '#e8f5e9',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="90" height="54" viewBox="0 0 90 54"><rect fill="#e8f5e9" x="2" y="2" width="86" height="50" rx="2"/><path d="M2 52 Q45 2 88 52 Z" fill="#81c784" opacity="0.3"/><circle cx="75" cy="27" r="18" fill="#4caf50"/><text x="75" y="30" text-anchor="middle" font-size="3" fill="white">ECO</text><text x="15" y="22" font-size="5" fill="#2e7d32" font-weight="bold">林环保</text><text x="15" y="32" font-size="2.5" fill="#558b2f">可持续发展经理</text><text x="15" y="45" font-size="2" fill="#689f38">green@eco.hk</text></svg>'
            ],
            [
                'id' => 'biz-card-luxury-gold',
                'name' => '奢华金边名片',
                'category' => 'business-card',
                'category_name' => '名片',
                'width' => 90,
                'height' => 54,
                'background' => '#1a1a1a',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="90" height="54" viewBox="0 0 90 54"><rect fill="#1a1a1a" x="2" y="2" width="86" height="50" rx="2"/><rect fill="none" x="2" y="2" width="86" height="50" stroke="#c9a227" stroke-width="1"/><line x1="2" y1="18" x2="88" y2="18" stroke="#c9a227" stroke-width="0.5"/><text x="45" y="14" text-anchor="middle" font-size="3" fill="#c9a227">EXECUTIVE</text><text x="45" y="38" text-anchor="middle" font-size="5" fill="#c9a227" font-weight="bold">周总裁</text><text x="45" y="48" text-anchor="middle" font-size="2" fill="#888">ceo@luxury.hk</text></svg>'
            ],
            [
                'id' => 'biz-card-geometric',
                'name' => '几何图形名片',
                'category' => 'business-card',
                'category_name' => '名片',
                'width' => 90,
                'height' => 54,
                'background' => '#f5f5f5',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="90" height="54" viewBox="0 0 90 54"><rect fill="#f5f5f5" x="2" y="2" width="86" height="50" rx="2"/><polygon points="2,2 30,2 2,30" fill="#e74c3c" opacity="0.8"/><polygon points="88,52 60,52 88,26" fill="#3498db" opacity="0.8"/><rect x="60" y="15" width="20" height="20" fill="#f39c12" opacity="0.7" transform="rotate(45 70 25)"/><text x="45" y="30" text-anchor="middle" font-size="4.5" fill="#333" font-weight="bold">赵设计</text><text x="45" y="42" text-anchor="middle" font-size="2.5" fill="#666">产品设计师</text></svg>'
            ],
            // === 宣传单模板 ===
            [
                'id' => 'flyer-summer-sale',
                'name' => '夏季大减价',
                'category' => 'flyer',
                'category_name' => '宣传单',
                'width' => 210,
                'height' => 297,
                'background' => '#ff6b6b',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="210" height="297" viewBox="0 0 210 297"><rect fill="#ff6b6b" x="5" y="5" width="200" height="287" rx="3"/><circle cx="105" cy="148" r="90" fill="#fff" opacity="0.1"/><text x="105" y="50" text-anchor="middle" font-size="12" fill="white" font-weight="bold">SUMMER</text><text x="105" y="70" text-anchor="middle" font-size="8" fill="#fff">大减价</text><text x="105" y="130" text-anchor="middle" font-size="30" fill="#fff" font-weight="bold">UP TO</text><text x="105" y="180" text-anchor="middle" font-size="50" fill="#fff" font-weight="bold">70%</text><text x="105" y="220" text-anchor="middle" font-size="20" fill="#fff">OFF</text><rect fill="white" x="55" y="250" width="100" height="25" rx="12"/><text x="105" y="268" text-anchor="middle" font-size="5" fill="#ff6b6b" font-weight="bold">立即抢购 →</text></svg>'
            ],
            [
                'id' => 'flyer-restaurant',
                'name' => '餐厅开业宣传',
                'category' => 'flyer',
                'category_name' => '宣传单',
                'width' => 210,
                'height' => 297,
                'background' => '#2d3436',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="210" height="297" viewBox="0 0 210 297"><rect fill="#2d3436" x="5" y="5" width="200" height="287" rx="3"/><rect fill="#c9a227" x="5" y="5" width="200" height="8"/><rect fill="#c9a227" x="5" y="284" width="200" height="8"/><text x="105" y="50" text-anchor="middle" font-size="6" fill="#c9a227" letter-spacing="3">NOW OPEN</text><text x="105" y="90" text-anchor="middle" font-size="12" fill="white" font-weight="bold">意大利餐厅</text><text x="105" y="115" text-anchor="middle" font-size="5" fill="#ddd">ITALIAN CUISINE</text><rect fill="#c9a227" x="60" y="130" width="90" height="1"/><text x="105" y="160" text-anchor="middle" font-size="4" fill="#aaa">正宗意大利风味</text><text x="105" y="180" text-anchor="middle" font-size="4" fill="#aaa">新鲜食材 · 传统工艺</text><text x="105" y="210" text-anchor="middle" font-size="8" fill="#c9a227" font-weight="bold">开幕优惠</text><text x="105" y="240" text-anchor="middle" font-size="15" fill="white">8</text><text x="105" y="260" text-anchor="middle" font-size="5" fill="#aaa">月内全单8折</text><text x="105" y="280" text-anchor="middle" font-size="3" fill="#888">地址：铜锣湾时代广场</text></svg>'
            ],
            [
                'id' => 'flyer-tech-conference',
                'name' => '科技大会宣传',
                'category' => 'flyer',
                'category_name' => '宣传单',
                'width' => 210,
                'height' => 297,
                'background' => '#0f0c29',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="210" height="297" viewBox="0 0 210 297"><defs><linearGradient id="techBg" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#0f0c29"/><stop offset="50%" style="stop-color:#302b63"/><stop offset="100%" style="stop-color:#24243e"/></linearGradient></defs><rect fill="url(#techBg)" x="5" y="5" width="200" height="287" rx="3"/><rect x="20" y="30" width="170" height="1" fill="#00d2ff" opacity="0.5"/><text x="105" y="60" text-anchor="middle" font-size="5" fill="#00d2ff">HONG KONG 2026</text><text x="105" y="100" text-anchor="middle" font-size="10" fill="white" font-weight="bold">科技创新大会</text><text x="105" y="120" text-anchor="middle" font-size="4" fill="#888">AI · 区块链 · 云计算</text><rect fill="rgba(0,210,255,0.2)" x="30" y="140" width="150" height="80" rx="5"/><text x="105" y="165" text-anchor="middle" font-size="4" fill="#00d2ff" font-weight="bold">50+演讲嘉宾</text><text x="105" y="185" text-anchor="middle" font-size="3" fill="#ccc">100+科技企业</text><text x="105" y="205" text-anchor="middle" font-size="3" fill="#ccc">2000+参会者</text><text x="105" y="260" text-anchor="middle" font-size="5" fill="white">2026年8月15-17日</text><text x="105" y="280" text-anchor="middle" font-size="3" fill="#00d2ff">香港会议展览中心</text></svg>'
            ],
            // === 海报模板 ===
            [
                'id' => 'poster-concert',
                'name' => '音乐会海报',
                'category' => 'poster',
                'category_name' => '海报',
                'width' => 297,
                'height' => 420,
                'background' => '#1a1a2e',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="297" height="420" viewBox="0 0 297 420"><defs><linearGradient id="concertBg" x1="0%" y1="0%" x2="0%" y2="100%"><stop offset="0%" style="stop-color:#667eea"/><stop offset="100%" style="stop-color:#764ba2"/></linearGradient></defs><rect fill="url(#concertBg)" x="5" y="5" width="287" height="410" rx="3"/><circle cx="148" cy="150" r="80" fill="rgba(255,255,255,0.1)"/><circle cx="148" cy="150" r="60" fill="rgba(255,255,255,0.05)"/><text x="148" y="80" text-anchor="middle" font-size="6" fill="#fff" letter-spacing="5">LIVE IN HONG KONG</text><text x="148" y="150" text-anchor="middle" font-size="25" fill="#fff" font-weight="bold">周杰伦</text><text x="148" y="200" text-anchor="middle" font-size="8" fill="#ffd700">地表最强世界巡回</text><rect fill="#ff6b6b" x="98" y="250" width="100" height="30" rx="15"/><text x="148" y="270" text-anchor="middle" font-size="5" fill="white" font-weight="bold">2026年12月31日</text><text x="148" y="320" text-anchor="middle" font-size="5" fill="#ccc">香港红磡体育馆</text><text x="148" y="380" text-anchor="middle" font-size="15" fill="#ffd700">$388 - $1888</text></svg>'
            ],
            [
                'id' => 'poster-gym',
                'name' => '健身房促销',
                'category' => 'poster',
                'category_name' => '海报',
                'width' => 297,
                'height' => 420,
                'background' => '#1e1e1e',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="297" height="420" viewBox="0 0 297 420"><rect fill="#1e1e1e" x="5" y="5" width="287" height="410" rx="3"/><rect fill="#ff4757" x="5" y="5" width="287" height="100"/><text x="148" y="40" text-anchor="middle" font-size="8" fill="white">限时特惠</text><text x="148" y="70" text-anchor="middle" font-size="15" fill="white" font-weight="bold">健身会员招募</text><rect fill="#2ed573" x="98" y="130" width="100" height="100" rx="50"/><text x="148" y="170" text-anchor="middle" font-size="8" fill="white">首年</text><text x="148" y="195" text-anchor="middle" font-size="12" fill="white" font-weight="bold">半价</text><text x="148" y="280" text-anchor="middle" font-size="6" fill="#ccc">免费体测 · 专业教练</text><text x="148" y="310" text-anchor="middle" font-size="6" fill="#ccc">团体课程 · 24小时开放</text><rect fill="#ff4757" x="73" y="350" width="150" height="35" rx="5"/><text x="148" y="373" text-anchor="middle" font-size="5" fill="white" font-weight="bold">立即报名：+852 1234 5678</text></svg>'
            ],
            [
                'id' => 'poster-spa',
                'name' => '水疗中心海报',
                'category' => 'poster',
                'category_name' => '海报',
                'width' => 297,
                'height' => 420,
                'background' => '#fdf6f0',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="297" height="420" viewBox="0 0 297 420"><rect fill="#fdf6f0" x="5" y="5" width="287" height="410" rx="3"/><rect fill="#d4a373" x="5" y="5" width="287" height="120"/><text x="148" y="50" text-anchor="middle" font-size="6" fill="#8b7355" letter-spacing="3">RELAX &amp; REJUVENATE</text><text x="148" y="90" text-anchor="middle" font-size="12" fill="#5d4e37">奢华水疗体验</text><circle cx="148" cy="220" r="60" fill="#e8d5c4" stroke="#d4a373" stroke-width="2"/><text x="148" y="210" text-anchor="middle" font-size="5" fill="#8b7355">尊享</text><text x="148" y="235" text-anchor="middle" font-size="8" fill="#5d4e37" font-weight="bold">60分钟</text><text x="148" y="250" text-anchor="middle" font-size="4" fill="#8b7355">芳疗按摩</text><text x="148" y="330" text-anchor="middle" font-size="10" fill="#d4a373" font-weight="bold">限时优惠</text><text x="148" y="360" text-anchor="middle" font-size="6" fill="#8b7355">原价 $1288 · 优惠价 $688</text><text x="148" y="395" text-anchor="middle" font-size="3" fill="#aaa">预约电话：+852 9876 5432</text></svg>'
            ],
            // === 邀请函模板 ===
            [
                'id' => 'invite-corporate',
                'name' => '企业周年晚宴',
                'category' => 'invitation',
                'category_name' => '邀请函',
                'width' => 140,
                'height' => 210,
                'background' => '#1a1a1a',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="140" height="210" viewBox="0 0 140 210"><rect fill="#1a1a1a" x="3" y="3" width="134" height="204" rx="2"/><rect fill="none" x="10" y="10" width="120" height="190" stroke="#c9a227" stroke-width="0.5"/><text x="70" y="50" text-anchor="middle" font-size="4" fill="#c9a227" letter-spacing="2">CORDIALLY INVITED</text><text x="70" y="80" text-anchor="middle" font-size="6" fill="white" font-weight="bold">公司名称</text><text x="70" y="100" text-anchor="middle" font-size="5" fill="#c9a227">20周年庆典晚宴</text><line x1="40" y1="115" x2="100" y2="115" stroke="#c9a227"/><text x="70" y="140" text-anchor="middle" font-size="3" fill="#aaa">2026年6月15日 (星期六)</text><text x="70" y="155" text-anchor="middle" font-size="3" fill="#aaa">晚上七时正</text><text x="70" y="175" text-anchor="middle" font-size="3" fill="#aaa">香港君悦酒店大礼堂</text><text x="70" y="195" text-anchor="middle" font-size="2.5" fill="#c9a227">着装要求：正式</text></svg>'
            ],
            [
                'id' => 'invite-birthday',
                'name' => '生日派对邀请',
                'category' => 'invitation',
                'category_name' => '邀请函',
                'width' => 140,
                'height' => 210,
                'background' => '#fff0f5',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="140" height="210" viewBox="0 0 140 210"><rect fill="#fff0f5" x="3" y="3" width="134" height="204" rx="2"/><circle cx="70" cy="50" r="25" fill="#ff69b4" opacity="0.3"/><circle cx="30" cy="30" r="8" fill="#ff69b4" opacity="0.2"/><circle cx="110" cy="40" r="10" fill="#ff69b4" opacity="0.2"/><text x="70" y="45" text-anchor="middle" font-size="3" fill="#ff69b4">YOU ARE INVITED</text><text x="70" y="80" text-anchor="middle" font-size="7" fill="#e91e63" font-weight="bold">生日派对</text><text x="70" y="105" text-anchor="middle" font-size="4" fill="#333">为陈小明庆祝</text><text x="70" y="130" text-anchor="middle" font-size="5" fill="#e91e63" font-weight="bold">8岁生日</text><line x1="30" y1="145" x2="110" y2="145" stroke="#ff69b4" stroke-dasharray="2,2"/><text x="70" y="165" text-anchor="middle" font-size="3" fill="#666">2026年7月20日</text><text x="70" y="180" text-anchor="middle" font-size="3" fill="#666">下午三点</text><text x="70" y="195" text-anchor="middle" font-size="2.5" fill="#999">香港迪士尼乐园酒店</text></svg>'
            ],
            [
                'id' => 'invite-graduation',
                'name' => '毕业典礼邀请',
                'category' => 'invitation',
                'category_name' => '邀请函',
                'width' => 140,
                'height' => 210,
                'background' => '#f0f8ff',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="140" height="210" viewBox="0 0 140 210"><rect fill="#f0f8ff" x="3" y="3" width="134" height="204" rx="2"/><polygon points="70,10 90,40 70,35 50,40" fill="#4169e1"/><rect fill="#4169e1" x="60" y="35" width="20" height="25"/><text x="70" y="80" text-anchor="middle" font-size="4" fill="#4169e1" letter-spacing="1">CONGRATULATIONS</text><text x="70" y="105" text-anchor="middle" font-size="5" fill="#333" font-weight="bold">毕业典礼</text><text x="70" y="130" text-anchor="middle" font-size="4" fill="#666">香港大学工商管理学士</text><text x="70" y="150" text-anchor="middle" font-size="5" fill="#333" font-weight="bold">张同学</text><line x1="30" y1="165" x2="110" y2="165" stroke="#4169e1" opacity="0.5"/><text x="70" y="185" text-anchor="middle" font-size="3" fill="#888">2026年6月8日 上午十时</text><text x="70" y="200" text-anchor="middle" font-size="2.5" fill="#aaa">香港大学陆佑堂</text></svg>'
            ],
            // === 优惠券模板 ===
            [
                'id' => 'coupon-food',
                'name' => '美食优惠券',
                'category' => 'coupon',
                'category_name' => '优惠券',
                'width' => 200,
                'height' => 100,
                'background' => '#ff6347',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="200" height="100" viewBox="0 0 200 100"><rect fill="#ff6347" x="2" y="2" width="196" height="96" rx="2"/><circle cx="10" cy="50" r="8" fill="white"/><circle cx="10" cy="30" r="8" fill="white"/><circle cx="10" cy="70" r="8" fill="white"/><circle cx="190" cy="50" r="8" fill="white"/><circle cx="190" cy="30" r="8" fill="white"/><circle cx="190" cy="70" r="8" fill="white"/><text x="100" y="30" text-anchor="middle" font-size="5" fill="white">抵用券</text><text x="100" y="60" text-anchor="middle" font-size="20" fill="white" font-weight="bold">$50</text><text x="100" y="80" text-anchor="middle" font-size="3" fill="rgba(255,255,255,0.8)">满200可用 · 有效期至6月30日</text></svg>'
            ],
            [
                'id' => 'coupon-shopping',
                'name' => '购物满减券',
                'category' => 'coupon',
                'category_name' => '优惠券',
                'width' => 200,
                'height' => 100,
                'background' => '#9b59b6',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="200" height="100" viewBox="0 0 200 100"><rect fill="#9b59b6" x="2" y="2" width="196" height="96" rx="3"/><text x="100" y="25" text-anchor="middle" font-size="4" fill="rgba(255,255,255,0.8)">购物满减</text><text x="100" y="60" text-anchor="middle" font-size="8" fill="white" font-weight="bold">满500减100</text><rect fill="rgba(255,255,255,0.2)" x="50" y="70" width="100" height="20" rx="3"/><text x="100" y="85" text-anchor="middle" font-size="3" fill="white">全场通用 · 不限品类</text></svg>'
            ],
            // === 餐牌模板 ===
            [
                'id' => 'menu-cafe',
                'name' => '咖啡店餐牌',
                'category' => 'menu',
                'category_name' => '餐牌',
                'width' => 148,
                'height' => 210,
                'background' => '#3e2723',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="148" height="210" viewBox="0 0 148 210"><rect fill="#3e2723" x="3" y="3" width="142" height="204" rx="2"/><rect fill="#d7ccc8" x="10" y="10" width="128" height="190"/><text x="74" y="40" text-anchor="middle" font-size="7" fill="#5d4037" font-weight="bold">COFFEE HOUSE</text><text x="74" y="55" text-anchor="middle" font-size="3" fill="#8d6e63">精选咖啡 · 手冲咖啡</text><line x1="30" y1="65" x2="118" y2="65" stroke="#8d6e63"/><text x="15" y="85" font-size="4" fill="#5d4037" font-weight="bold">咖啡 COFFEE</text><text x="15" y="100" font-size="3" fill="#6d4c41">美式咖啡</text><text x="125" y="100" text-anchor="end" font-size="3" fill="#6d4c41">$32</text><text x="15" y="115" font-size="3" fill="#6d4c41">拿铁</text><text x="125" y="115" text-anchor="end" font-size="3" fill="#6d4c41">$38</text><text x="15" y="130" font-size="3" fill="#6d4c41">卡布奇诺</text><text x="125" y="130" text-anchor="end" font-size="3" fill="#6d4c41">$38</text><text x="15" y="150" font-size="4" fill="#5d4037" font-weight="bold">甜点 DESSERT</text><text x="15" y="165" font-size="3" fill="#6d4c41">芝士蛋糕</text><text x="125" y="165" text-anchor="end" font-size="3" fill="#6d4c41">$45</text><text x="15" y="180" font-size="3" fill="#6d4c41">提拉米苏</text><text x="125" y="180" text-anchor="end" font-size="3" fill="#6d4c41">$42</text></svg>'
            ],
            [
                'id' => 'menu-tea',
                'name' => '茶餐厅餐牌',
                'category' => 'menu',
                'category_name' => '餐牌',
                'width' => 148,
                'height' => 210,
                'background' => '#fffde7',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="148" height="210" viewBox="0 0 148 210"><rect fill="#fffde7" x="3" y="3" width="142" height="204" rx="2"/><rect fill="#4caf50" x="3" y="3" width="142" height="30"/><text x="74" y="20" text-anchor="middle" font-size="6" fill="white" font-weight="bold">港式茶餐厅</text><text x="10" y="50" font-size="4" fill="#388e3c" font-weight="bold">早餐 BREAKFAST</text><text x="10" y="70" font-size="3" fill="#555">火腿通粉 + 咖啡</text><text x="130" y="70" text-anchor="end" font-size="3" fill="#555">$38</text><text x="10" y="90" font-size="4" fill="#388e3c" font-weight="bold">常餐 SET MEAL</text><text x="10" y="110" font-size="3" fill="#555">焗猪扒饭</text><text x="130" y="110" text-anchor="end" font-size="3" fill="#555">$48</text><text x="10" y="130" font-size="4" fill="#388e3c" font-weight="bold">饮品 DRINKS</text><text x="10" y="150" font-size="3" fill="#555">丝袜奶茶</text><text x="130" y="150" text-anchor="end" font-size="3" fill="#555">$22</text><text x="10" y="170" font-size="3" fill="#555">柠檬可乐</text><text x="130" y="170" text-anchor="end" font-size="3" fill="#555">$18</text><rect fill="#4caf50" x="3" y="182" width="142" height="25"/><text x="74" y="199" text-anchor="middle" font-size="3" fill="white">午市套餐优惠 11:00-14:00</text></svg>'
            ],
            // === 社交媒体模板 ===
            [
                'id' => 'social-facebook',
                'name' => 'Facebook封面',
                'category' => 'social',
                'category_name' => '社交媒体',
                'width' => 820,
                'height' => 312,
                'background' => '#1877f2',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="820" height="312" viewBox="0 0 820 312"><rect fill="#1877f2" x="5" y="5" width="810" height="302" rx="3"/><circle cx="410" cy="156" r="100" fill="rgba(255,255,255,0.1)"/><text x="410" y="130" text-anchor="middle" font-size="20" fill="white" font-weight="bold">公司名称</text><text x="410" y="170" text-anchor="middle" font-size="8" fill="rgba(255,255,255,0.8)">您的信赖之选</text><rect fill="white" x="340" y="200" width="140" height="35" rx="5"/><text x="410" y="223" text-anchor="middle" font-size="5" fill="#1877f2" font-weight="bold">立即关注</text></svg>'
            ],
            [
                'id' => 'social-instagram',
                'name' => 'Instagram故事',
                'category' => 'social',
                'category_name' => '社交媒体',
                'width' => 108,
                'height' => 192,
                'background' => '#e4405f',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="108" height="192" viewBox="0 0 108 192"><defs><linearGradient id="instaGrad" x1="0%" y1="100%" x2="100%" y2="0%"><stop offset="0%" style="stop-color:#833ab4"/><stop offset="50%" style="stop-color:#fd1d1d"/><stop offset="100%" style="stop-color:#fcb045"/></linearGradient></defs><rect fill="url(#instaGrad)" x="3" y="3" width="102" height="186" rx="2"/><rect fill="rgba(0,0,0,0.2)" x="3" y="3" width="102" height="60"/><text x="54" y="25" text-anchor="middle" font-size="4" fill="white" font-weight="bold">NEW ARRIVAL</text><text x="54" y="45" text-anchor="middle" font-size="8" fill="white">新品上市</text><circle cx="54" cy="110" r="25" fill="white"/><text x="54" y="115" text-anchor="middle" font-size="8" fill="#e4405f">SALE</text><text x="54" y="155" text-anchor="middle" font-size="6" fill="white" font-weight="bold">限时5折</text><text x="54" y="175" text-anchor="middle" font-size="3" fill="rgba(255,255,255,0.8)">立即抢购</text></svg>'
            ],
            // === 贺卡模板 ===
            [
                'id' => 'greeting-thanks',
                'name' => '感谢贺卡',
                'category' => 'greeting',
                'category_name' => '贺卡',
                'width' => 148,
                'height' => 105,
                'background' => '#fff9c4',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="148" height="105" viewBox="0 0 148 105"><rect fill="#fff9c4" x="3" y="3" width="142" height="99" rx="2"/><rect fill="#ffca28" x="3" y="3" width="142" height="5"/><rect fill="#ffca28" x="3" y="97" width="142" height="5"/><circle cx="74" cy="35" r="15" fill="#ffca28" opacity="0.5"/><text x="74" y="40" text-anchor="middle" font-size="4" fill="#f57f17">感谢</text><text x="74" y="60" text-anchor="middle" font-size="6" fill="#333" font-weight="bold">THANK YOU</text><text x="74" y="80" text-anchor="middle" font-size="3" fill="#666">衷心感谢您的支持</text></svg>'
            ],
            [
                'id' => 'greeting-festival',
                'name' => '节日祝福贺卡',
                'category' => 'greeting',
                'category_name' => '贺卡',
                'width' => 148,
                'height' => 105,
                'background' => '#1b5e20',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="148" height="105" viewBox="0 0 148 105"><rect fill="#1b5e20" x="3" y="3" width="142" height="99" rx="2"/><polygon points="20,30 30,50 10,50" fill="#4caf50"/><polygon points="40,25 50,45 30,45" fill="#66bb6a"/><polygon points="120,30 130,50 110,50" fill="#4caf50"/><polygon points="130,20 140,40 120,40" fill="#66bb6a"/><text x="74" y="50" text-anchor="middle" font-size="6" fill="#ffd54f">新年快乐</text><text x="74" y="70" text-anchor="middle" font-size="4" fill="white">HAPPY NEW YEAR</text><text x="74" y="90" text-anchor="middle" font-size="3" fill="#a5d6a7">2026</text></svg>'
            ],
            // === 标签模板 ===
            [
                'id' => 'label-price',
                'name' => '价格标签',
                'category' => 'label',
                'category_name' => '标签',
                'width' => 80,
                'height' => 40,
                'background' => '#e74c3c',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="80" height="40" viewBox="0 0 80 40"><rect fill="#e74c3c" x="2" y="2" width="76" height="36" rx="2"/><text x="40" y="15" text-anchor="middle" font-size="4" fill="white">特惠价</text><text x="40" y="32" text-anchor="middle" font-size="10" fill="white" font-weight="bold">$99</text></svg>'
            ],
            [
                'id' => 'label-new',
                'name' => '新品标签',
                'category' => 'label',
                'category_name' => '标签',
                'width' => 60,
                'height' => 60,
                'background' => '#2ecc71',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 60 60"><rect fill="#2ecc71" x="2" y="2" width="56" height="56" rx="2"/><text x="30" y="25" text-anchor="middle" font-size="4" fill="white">NEW</text><text x="30" y="45" text-anchor="middle" font-size="8" fill="white" font-weight="bold">新品</text></svg>'
            ],
            [
                'id' => 'label-discount',
                'name' => '限时折扣标签',
                'category' => 'label',
                'category_name' => '标签',
                'width' => 80,
                'height' => 80,
                'background' => '#ff6b6b',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 80 80"><circle fill="#ff6b6b" cx="40" cy="40" r="38"/><text x="40" y="30" text-anchor="middle" font-size="4" fill="white">限时</text><text x="40" y="52" text-anchor="middle" font-size="12" fill="white" font-weight="bold">5折</text></svg>'
            ],
            [
                'id' => 'label-bestseller',
                'name' => '热卖标签',
                'category' => 'label',
                'category_name' => '标签',
                'width' => 70,
                'height' => 30,
                'background' => '#f39c12',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="70" height="30" viewBox="0 0 70 30"><rect fill="#f39c12" x="1" y="1" width="68" height="28" rx="4"/><text x="35" y="20" text-anchor="middle" font-size="4" fill="white" font-weight="bold">热卖</text></svg>'
            ],
            [
                'id' => 'label-organic',
                'name' => '有机产品标签',
                'category' => 'label',
                'category_name' => '标签',
                'width' => 70,
                'height' => 70,
                'background' => '#27ae60',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" viewBox="0 0 70 70"><circle fill="#27ae60" cx="35" cy="35" r="33" stroke="#fff" stroke-width="1"/><text x="35" y="30" text-anchor="middle" font-size="4" fill="white">有机</text><text x="35" y="50" text-anchor="middle" font-size="3" fill="rgba(255,255,255,0.8)">ORGANIC</text></svg>'
            ],
            // === 信封模板 ===
            [
                'id' => 'envelope-corporate',
                'name' => '企业信封',
                'category' => 'envelope',
                'category_name' => '信封',
                'width' => 220,
                'height' => 110,
                'background' => '#ffffff',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="220" height="110" viewBox="0 0 220 110"><rect fill="white" x="2" y="2" width="216" height="106" rx="2" stroke="#ccc" stroke-width="0.5"/><rect fill="#1a3a5c" x="2" y="2" width="216" height="18"/><text x="8" y="15" font-size="4" fill="white" font-weight="bold">公司名称有限公司</text><text x="150" y="15" font-size="3" fill="rgba(255,255,255,0.8)">电话: +852 1234 5678</text><rect x="170" y="50" width="40" height="20" rx="2" fill="none" stroke="#ddd" stroke-width="0.5"/><text x="190" y="64" text-anchor="middle" font-size="3" fill="#aaa">邮票</text><text x="10" y="85" font-size="4" fill="#333">致：香港湾仔皇后大道东123号</text></svg>'
            ],
            [
                'id' => 'envelope-window',
                'name' => '开窗信封',
                'category' => 'envelope',
                'category_name' => '信封',
                'width' => 220,
                'height' => 110,
                'background' => '#fafafa',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="220" height="110" viewBox="0 0 220 110"><rect fill="#fafafa" x="2" y="2" width="216" height="106" rx="1"/><rect fill="none" x="2" y="2" width="216" height="106" stroke="#bbb" stroke-width="0.3"/><rect fill="#2c3e50" x="2" y="2" width="216" height="12"/><text x="5" y="11" font-size="3" fill="white">公司名称 · 地址 · 电话</text><rect fill="none" x="50" y="35" width="100" height="30" rx="1" stroke="#999" stroke-width="0.5" stroke-dasharray="2,1"/><text x="100" y="53" text-anchor="middle" font-size="2.5" fill="#999">收件人地址窗口</text><text x="175" y="95" font-size="3" fill="#666">寄件人地址</text></svg>'
            ],
            [
                'id' => 'envelope-wedding',
                'name' => '婚礼信封',
                'category' => 'envelope',
                'category_name' => '信封',
                'width' => 220,
                'height' => 110,
                'background' => '#fff5f5',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="220" height="110" viewBox="0 0 220 110"><rect fill="#fff5f5" x="2" y="2" width="216" height="106" rx="2"/><rect fill="none" x="4" y="4" width="212" height="102" rx="2" stroke="#e8b4b8" stroke-width="0.5"/><circle cx="20" cy="20" r="8" fill="#e8b4b8" opacity="0.3"/><circle cx="200" cy="90" r="10" fill="#e8b4b8" opacity="0.3"/><text x="110" y="55" text-anchor="middle" font-size="8" fill="#d4a0a0">Wedding</text><text x="110" y="75" text-anchor="middle" font-size="4" fill="#c49a9a">诚挚邀请</text></svg>'
            ],
            [
                'id' => 'envelope-holiday',
                'name' => '节日信封',
                'category' => 'envelope',
                'category_name' => '信封',
                'width' => 220,
                'height' => 110,
                'background' => '#e8f5e9',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="220" height="110" viewBox="0 0 220 110"><rect fill="#e8f5e9" x="2" y="2" width="216" height="106" rx="2"/><rect fill="#388e3c" x="2" y="2" width="216" height="8"/><rect fill="#388e3c" x="2" y="100" width="216" height="8"/><text x="110" y="40" text-anchor="middle" font-size="6" fill="#2e7d32" font-weight="bold">新年快乐</text><text x="110" y="70" text-anchor="middle" font-size="3" fill="#558b2f">Happy New Year 2026</text></svg>'
            ],
            // === 信纸模板 ===
            [
                'id' => 'letterhead-corporate',
                'name' => '企业信纸',
                'category' => 'letterhead',
                'category_name' => '信纸',
                'width' => 210,
                'height' => 297,
                'background' => '#ffffff',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="210" height="297" viewBox="0 0 210 297"><rect fill="white" x="2" y="2" width="206" height="293" rx="1" stroke="#eee" stroke-width="0.3"/><rect fill="#1a3a5c" x="2" y="2" width="206" height="25"/><text x="10" y="18" font-size="6" fill="white" font-weight="bold">公司名称</text><text x="10" y="50" font-size="3" fill="#666">地址：香港中环金融街8号</text><text x="10" y="60" font-size="3" fill="#666">电话：+852 1234 5678 | 电邮：info@company.hk</text><line x1="10" y1="70" x2="200" y2="70" stroke="#ccc" stroke-width="0.3"/><line x1="10" y1="280" x2="200" y2="280" stroke="#1a3a5c" stroke-width="0.5"/><text x="105" y="290" text-anchor="middle" font-size="2.5" fill="#999">© 2026 公司名称 版权所有</text></svg>'
            ],
            [
                'id' => 'letterhead-elegant',
                'name' => '优雅信纸',
                'category' => 'letterhead',
                'category_name' => '信纸',
                'width' => 210,
                'height' => 297,
                'background' => '#fdfcf9',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="210" height="297" viewBox="0 0 210 297"><rect fill="#fdfcf9" x="2" y="2" width="206" height="293" rx="1"/><rect fill="#8b7355" x="2" y="2" width="206" height="3"/><text x="105" y="20" text-anchor="middle" font-size="6" fill="#5d4e37" font-weight="bold">ELEGANCE</text><text x="105" y="30" text-anchor="middle" font-size="2.5" fill="#8b7355">Est. 2026</text><line x1="50" y1="40" x2="160" y2="40" stroke="#8b7355" stroke-width="0.3"/><rect fill="#8b7355" x="2" y="290" width="206" height="3"/></svg>'
            ],
            [
                'id' => 'letterhead-creative',
                'name' => '创意信纸',
                'category' => 'letterhead',
                'category_name' => '信纸',
                'width' => 210,
                'height' => 297,
                'background' => '#ffffff',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="210" height="297" viewBox="0 0 210 297"><rect fill="white" x="2" y="2" width="206" height="293" rx="1"/><rect fill="#e74c3c" x="2" y="2" width="8" height="293"/><circle cx="150" cy="20" r="12" fill="#3498db" opacity="0.2"/><text x="20" y="25" font-size="6" fill="#333" font-weight="bold">CREATIVE STUDIO</text><text x="20" y="40" font-size="3" fill="#888">创意无限</text><rect fill="#e74c3c" x="2" y="280" width="206" height="5"/></svg>'
            ],
            // === 文件夹模板 ===
            [
                'id' => 'folder-corporate',
                'name' => '企业文件夹',
                'category' => 'folder',
                'category_name' => '文件夹',
                'width' => 220,
                'height' => 310,
                'background' => '#1a3a5c',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="220" height="310" viewBox="0 0 220 310"><rect fill="#1a3a5c" x="3" y="3" width="214" height="304" rx="2"/><rect fill="#fff" x="3" y="80" width="214" height="227"/><text x="110" y="35" text-anchor="middle" font-size="10" fill="white" font-weight="bold">公司名称</text><text x="110" y="55" text-anchor="middle" font-size="4" fill="rgba(255,255,255,0.8)">COMPANY NAME</text><text x="110" y="150" text-anchor="middle" font-size="6" fill="#333" font-weight="bold">会议资料</text><text x="110" y="200" text-anchor="middle" font-size="3" fill="#666">2026年度</text></svg>'
            ],
            [
                'id' => 'folder-presentation',
                'name' => '演示文件夹',
                'category' => 'folder',
                'category_name' => '文件夹',
                'width' => 220,
                'height' => 310,
                'background' => '#2c3e50',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="220" height="310" viewBox="0 0 220 310"><rect fill="#2c3e50" x="3" y="3" width="214" height="304" rx="2"/><rect fill="#ecf0f1" x="3" y="3" width="214" height="120"/><circle cx="110" cy="45" r="25" fill="#3498db" opacity="0.2"/><text x="110" y="50" text-anchor="middle" font-size="6" fill="#2c3e50" font-weight="bold">PRESENTATION</text><text x="110" y="75" text-anchor="middle" font-size="4" fill="#7f8c8d">2026</text><rect fill="#3498db" x="3" y="120" width="214" height="5"/><text x="110" y="200" text-anchor="middle" font-size="5" fill="white">提案文件</text></svg>'
            ],
            [
                'id' => 'folder-product',
                'name' => '产品文件夹',
                'category' => 'folder',
                'category_name' => '文件夹',
                'width' => 220,
                'height' => 310,
                'background' => '#e74c3c',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="220" height="310" viewBox="0 0 220 310"><rect fill="#e74c3c" x="3" y="3" width="214" height="304" rx="2"/><rect fill="white" x="3" y="90" width="214" height="217"/><text x="110" y="40" text-anchor="middle" font-size="8" fill="white" font-weight="bold">产品目录</text><text x="110" y="65" text-anchor="middle" font-size="4" fill="rgba(255,255,255,0.8)">PRODUCT CATALOG</text><text x="110" y="170" text-anchor="middle" font-size="5" fill="#333" font-weight="bold">2026春夏系列</text></svg>'
            ],
            // === 贴纸模板 ===
            [
                'id' => 'sticker-round-logo',
                'name' => '圆形Logo贴纸',
                'category' => 'sticker',
                'category_name' => '贴纸',
                'width' => 80,
                'height' => 80,
                'background' => '#3498db',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 80 80"><circle fill="#3498db" cx="40" cy="40" r="38"/><circle fill="none" cx="40" cy="40" r="35" stroke="white" stroke-width="1.5" stroke-dasharray="4,2"/><text x="40" y="35" text-anchor="middle" font-size="6" fill="white" font-weight="bold">LOGO</text><text x="40" y="55" text-anchor="middle" font-size="3" fill="rgba(255,255,255,0.8)">品牌名称</text></svg>'
            ],
            [
                'id' => 'sticker-sale',
                'name' => '促销贴纸',
                'category' => 'sticker',
                'category_name' => '贴纸',
                'width' => 100,
                'height' => 60,
                'background' => '#ff4757',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="100" height="60" viewBox="0 0 100 60"><rect fill="#ff4757" x="2" y="2" width="96" height="56" rx="8"/><text x="50" y="25" text-anchor="middle" font-size="4" fill="rgba(255,255,255,0.9)">限时优惠</text><text x="50" y="48" text-anchor="middle" font-size="10" fill="white" font-weight="bold">-50%</text></svg>'
            ],
            [
                'id' => 'sticker-eco',
                'name' => '环保贴纸',
                'category' => 'sticker',
                'category_name' => '贴纸',
                'width' => 70,
                'height' => 70,
                'background' => '#27ae60',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" viewBox="0 0 70 70"><circle fill="#27ae60" cx="35" cy="35" r="33" stroke="#fff" stroke-width="0.5"/><text x="35" y="30" text-anchor="middle" font-size="4" fill="white" font-weight="bold">ECO</text><text x="35" y="50" text-anchor="middle" font-size="3" fill="rgba(255,255,255,0.8)">FRIENDLY</text></svg>'
            ],
            [
                'id' => 'sticker-qr',
                'name' => '扫码贴纸',
                'category' => 'sticker',
                'category_name' => '贴纸',
                'width' => 60,
                'height' => 80,
                'background' => '#ffffff',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="60" height="80" viewBox="0 0 60 80"><rect fill="white" x="1" y="1" width="58" height="78" rx="3" stroke="#ddd" stroke-width="0.5"/><rect fill="#333" x="12" y="8" width="36" height="36" rx="2"/><text x="30" y="28" text-anchor="middle" font-size="4" fill="white">QR</text><text x="30" y="38" text-anchor="middle" font-size="2" fill="white">CODE</text><text x="30" y="60" text-anchor="middle" font-size="3" fill="#666">扫码关注</text><text x="30" y="72" text-anchor="middle" font-size="2" fill="#999">Scan Me</text></svg>'
            ],
            // === 证书模板 ===
            [
                'id' => 'certificate-award',
                'name' => '荣誉证书',
                'category' => 'certificate',
                'category_name' => '证书',
                'width' => 297,
                'height' => 210,
                'background' => '#fffef5',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="297" height="210" viewBox="0 0 297 210"><rect fill="#fffef5" x="3" y="3" width="291" height="204" rx="2"/><rect fill="none" x="10" y="10" width="277" height="190" stroke="#c9a227" stroke-width="2"/><rect fill="none" x="15" y="15" width="267" height="180" stroke="#c9a227" stroke-width="0.5"/><text x="148" y="40" text-anchor="middle" font-size="5" fill="#c9a227" letter-spacing="3">CERTIFICATE</text><text x="148" y="70" text-anchor="middle" font-size="8" fill="#333" font-weight="bold">荣誉证书</text><line x1="60" y1="85" x2="236" y2="85" stroke="#c9a227" stroke-width="0.5"/><text x="148" y="110" text-anchor="middle" font-size="4" fill="#666">兹证明</text><text x="148" y="135" text-anchor="middle" font-size="5" fill="#333" font-weight="bold">[获奖者姓名]</text><text x="148" y="155" text-anchor="middle" font-size="3.5" fill="#666">在2026年度表现卓越，特发此证</text><text x="148" y="185" text-anchor="middle" font-size="3" fill="#999">颁发日期：2026年____月____日</text></svg>'
            ],
            [
                'id' => 'certificate-completion',
                'name' => '结业证书',
                'category' => 'certificate',
                'category_name' => '证书',
                'width' => 297,
                'height' => 210,
                'background' => '#f8fbff',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="297" height="210" viewBox="0 0 297 210"><rect fill="#f8fbff" x="3" y="3" width="291" height="204" rx="2"/><rect fill="#1a3a5c" x="3" y="3" width="291" height="12"/><rect fill="#1a3a5c" x="3" y="195" width="291" height="12"/><text x="148" y="50" text-anchor="middle" font-size="5" fill="#1a3a5c" letter-spacing="2">CERTIFICATE OF COMPLETION</text><text x="148" y="85" text-anchor="middle" font-size="7" fill="#333" font-weight="bold">结业证书</text><text x="148" y="110" text-anchor="middle" font-size="3.5" fill="#666">兹证明 [学员姓名] 已完成</text><text x="148" y="130" text-anchor="middle" font-size="4" fill="#1a3a5c" font-weight="bold">[课程名称]</text><text x="148" y="160" text-anchor="middle" font-size="3" fill="#999">课程日期：2026年____月至____月</text></svg>'
            ],
            [
                'id' => 'certificate-appreciation',
                'name' => '感谢状',
                'category' => 'certificate',
                'category_name' => '证书',
                'width' => 297,
                'height' => 210,
                'background' => '#fffaf5',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="297" height="210" viewBox="0 0 297 210"><rect fill="#fffaf5" x="3" y="3" width="291" height="204" rx="2"/><rect fill="none" x="12" y="12" width="273" height="186" stroke="#d4a373" stroke-width="1"/><text x="148" y="45" text-anchor="middle" font-size="5" fill="#d4a373" letter-spacing="3">APPRECIATION</text><text x="148" y="80" text-anchor="middle" font-size="8" fill="#5d4e37" font-weight="bold">感谢状</text><text x="148" y="110" text-anchor="middle" font-size="4" fill="#8b7355">衷心感谢</text><text x="148" y="140" text-anchor="middle" font-size="5" fill="#5d4e37" font-weight="bold">[感谢对象]</text><text x="148" y="165" text-anchor="middle" font-size="3.5" fill="#8b7355">对本次活动的慷慨支持与帮助</text><text x="148" y="195" text-anchor="middle" font-size="3" fill="#aaa">2026年____月____日</text></svg>'
            ],
            // === 易拉宝/展架模板 ===
            [
                'id' => 'banner-promotion',
                'name' => '促销易拉宝',
                'category' => 'banner',
                'category_name' => '易拉宝/展架',
                'width' => 80,
                'height' => 200,
                'background' => '#ff4757',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="80" height="200" viewBox="0 0 80 200"><rect fill="#ff4757" x="2" y="2" width="76" height="196" rx="1"/><text x="40" y="30" text-anchor="middle" font-size="5" fill="white" font-weight="bold">大减价</text><text x="40" y="60" text-anchor="middle" font-size="15" fill="white" font-weight="bold">5折</text><text x="40" y="80" text-anchor="middle" font-size="4" fill="rgba(255,255,255,0.9)">SALE</text><rect fill="white" x="15" y="100" width="50" height="20" rx="3"/><text x="40" y="114" text-anchor="middle" font-size="3" fill="#ff4757" font-weight="bold">立即抢购</text><text x="40" y="150" text-anchor="middle" font-size="3" fill="rgba(255,255,255,0.8)">全场商品</text><text x="40" y="170" text-anchor="middle" font-size="3" fill="rgba(255,255,255,0.8)">低至5折</text></svg>'
            ],
            [
                'id' => 'banner-corporate',
                'name' => '企业展架',
                'category' => 'banner',
                'category_name' => '易拉宝/展架',
                'width' => 80,
                'height' => 200,
                'background' => '#1a3a5c',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="80" height="200" viewBox="0 0 80 200"><rect fill="#1a3a5c" x="2" y="2" width="76" height="196" rx="1"/><rect fill="#3498db" x="2" y="2" width="76" height="6"/><text x="40" y="30" text-anchor="middle" font-size="4" fill="white" font-weight="bold">公司名称</text><text x="40" y="50" text-anchor="middle" font-size="3" fill="rgba(255,255,255,0.8)">COMPANY</text><line x1="15" y1="60" x2="65" y2="60" stroke="rgba(255,255,255,0.3)"/><text x="40" y="90" text-anchor="middle" font-size="4" fill="white">专业服务</text><text x="40" y="120" text-anchor="middle" font-size="4" fill="white">品质保证</text><text x="40" y="150" text-anchor="middle" font-size="4" fill="white">值得信赖</text><rect fill="#3498db" x="2" y="192" width="76" height="6"/></svg>'
            ],
            [
                'id' => 'banner-event',
                'name' => '活动易拉宝',
                'category' => 'banner',
                'category_name' => '易拉宝/展架',
                'width' => 80,
                'height' => 200,
                'background' => '#6c5ce7',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="80" height="200" viewBox="0 0 80 200"><rect fill="#6c5ce7" x="2" y="2" width="76" height="196" rx="1"/><text x="40" y="25" text-anchor="middle" font-size="3" fill="rgba(255,255,255,0.8)">诚挚邀请</text><text x="40" y="60" text-anchor="middle" font-size="5" fill="white" font-weight="bold">年度盛会</text><circle cx="40" cy="100" r="20" fill="rgba(255,255,255,0.15)"/><text x="40" y="100" text-anchor="middle" font-size="4" fill="white">2026</text><text x="40" y="140" text-anchor="middle" font-size="3" fill="rgba(255,255,255,0.8)">8月15日</text><text x="40" y="160" text-anchor="middle" font-size="3" fill="rgba(255,255,255,0.8)">香港会议展览中心</text><rect fill="white" x="20" y="178" width="40" height="15" rx="2"/><text x="40" y="189" text-anchor="middle" font-size="2.5" fill="#6c5ce7" font-weight="bold">立即报名</text></svg>'
            ],
            // === 明信片模板 ===
            [
                'id' => 'postcard-travel',
                'name' => '旅行明信片',
                'category' => 'postcard',
                'category_name' => '明信片',
                'width' => 148,
                'height' => 105,
                'background' => '#e3f2fd',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="148" height="105" viewBox="0 0 148 105"><rect fill="#e3f2fd" x="2" y="2" width="144" height="101" rx="2"/><rect fill="#fff" x="2" y="2" width="80" height="101"/><text x="42" y="30" text-anchor="middle" font-size="5" fill="#1976d2" font-weight="bold">香港</text><text x="42" y="50" text-anchor="middle" font-size="3" fill="#64b5f6">HONG KONG</text><circle cx="42" cy="70" r="15" fill="#1976d2" opacity="0.1"/><text x="42" y="74" text-anchor="middle" font-size="3" fill="#1976d2">维港夜景</text><line x1="88" y1="15" x2="140" y2="15" stroke="#ddd" stroke-width="0.3"/><line x1="88" y1="30" x2="140" y2="30" stroke="#ddd" stroke-width="0.3"/><line x1="88" y1="45" x2="140" y2="45" stroke="#ddd" stroke-width="0.3"/><text x="90" y="65" font-size="3" fill="#999">Greetings from</text><text x="90" y="80" font-size="3" fill="#999">Hong Kong!</text></svg>'
            ],
            [
                'id' => 'postcard-holiday',
                'name' => '节日明信片',
                'category' => 'postcard',
                'category_name' => '明信片',
                'width' => 148,
                'height' => 105,
                'background' => '#fff3e0',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="148" height="105" viewBox="0 0 148 105"><rect fill="#fff3e0" x="2" y="2" width="144" height="101" rx="2"/><rect fill="#ff9800" x="2" y="2" width="144" height="8"/><rect fill="#ff9800" x="2" y="95" width="144" height="8"/><text x="74" y="40" text-anchor="middle" font-size="6" fill="#e65100" font-weight="bold">节日快乐</text><text x="74" y="60" text-anchor="middle" font-size="4" fill="#ff9800">Happy Holidays</text><text x="74" y="80" text-anchor="middle" font-size="3" fill="#bf360c">2026</text></svg>'
            ],
            [
                'id' => 'postcard-wedding',
                'name' => '婚礼明信片',
                'category' => 'postcard',
                'category_name' => '明信片',
                'width' => 148,
                'height' => 105,
                'background' => '#fce4ec',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="148" height="105" viewBox="0 0 148 105"><rect fill="#fce4ec" x="2" y="2" width="144" height="101" rx="2"/><rect fill="none" x="6" y="6" width="136" height="93" rx="1" stroke="#f8bbd0" stroke-width="0.5"/><text x="74" y="30" text-anchor="middle" font-size="4" fill="#e91e63" letter-spacing="2">Save the Date</text><text x="74" y="55" text-anchor="middle" font-size="5" fill="#ad1457" font-weight="bold">我们结婚了</text><text x="74" y="75" text-anchor="middle" font-size="3" fill="#e91e63">2026.12.25</text></svg>'
            ],
            // === 台历模板 ===
            [
                'id' => 'calendar-desk',
                'name' => '桌面台历',
                'category' => 'calendar',
                'category_name' => '台历',
                'width' => 210,
                'height' => 148,
                'background' => '#ffffff',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="210" height="148" viewBox="0 0 210 148"><rect fill="white" x="3" y="3" width="204" height="142" rx="2" stroke="#ddd" stroke-width="0.5"/><rect fill="#e74c3c" x="3" y="3" width="204" height="25"/><text x="105" y="20" text-anchor="middle" font-size="6" fill="white" font-weight="bold">JANUARY 2026</text><text x="15" y="50" font-size="3" fill="#e74c3c" font-weight="bold">日</text><text x="40" y="50" font-size="3" fill="#333" font-weight="bold">一</text><text x="65" y="50" font-size="3" fill="#333" font-weight="bold">二</text><text x="90" y="50" font-size="3" fill="#333" font-weight="bold">三</text><text x="115" y="50" font-size="3" fill="#333" font-weight="bold">四</text><text x="140" y="50" font-size="3" fill="#333" font-weight="bold">五</text><text x="165" y="50" font-size="3" fill="#333" font-weight="bold">六</text><text x="15" y="70" font-size="3" fill="#999">1</text><text x="40" y="70" font-size="3" fill="#333">2</text><text x="65" y="70" font-size="3" fill="#333">3</text><text x="90" y="70" font-size="3" fill="#333">4</text><text x="115" y="70" font-size="3" fill="#333">5</text><text x="140" y="70" font-size="3" fill="#333">6</text><text x="165" y="70" font-size="3" fill="#333">7</text><text x="15" y="90" font-size="3" fill="#999">8</text><text x="40" y="90" font-size="3" fill="#333">9</text><text x="65" y="90" font-size="3" fill="#333">10</text><text x="90" y="90" font-size="3" fill="#333">11</text><text x="115" y="90" font-size="3" fill="#333">12</text><text x="140" y="90" font-size="3" fill="#333">13</text><text x="165" y="90" font-size="3" fill="#333">14</text><text x="15" y="110" font-size="3" fill="#999">15</text><text x="40" y="110" font-size="3" fill="#333">16</text><text x="65" y="110" font-size="3" fill="#333">17</text><text x="90" y="110" font-size="3" fill="#333">18</text><text x="115" y="110" font-size="3" fill="#333">19</text><text x="140" y="110" font-size="3" fill="#333">20</text><text x="165" y="110" font-size="3" fill="#333">21</text><text x="15" y="130" font-size="3" fill="#999">22</text><text x="40" y="130" font-size="3" fill="#333">23</text><text x="65" y="130" font-size="3" fill="#333">24</text><text x="90" y="130" font-size="3" fill="#333">25</text><text x="115" y="130" font-size="3" fill="#333">26</text><text x="140" y="130" font-size="3" fill="#333">27</text><text x="165" y="130" font-size="3" fill="#333">28</text></svg>'
            ],
            [
                'id' => 'calendar-photo',
                'name' => '照片台历',
                'category' => 'calendar',
                'category_name' => '台历',
                'width' => 210,
                'height' => 148,
                'background' => '#fafafa',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="210" height="148" viewBox="0 0 210 148"><rect fill="#fafafa" x="3" y="3" width="204" height="142" rx="2"/><rect fill="#ddd" x="3" y="3" width="80" height="142"/><text x="43" y="74" text-anchor="middle" font-size="4" fill="#999">照片区</text><text x="100" y="25" font-size="4" fill="#333" font-weight="bold">2026</text><text x="100" y="50" font-size="2.5" fill="#666">一月 January</text><line x1="88" y1="55" x2="200" y2="55" stroke="#ddd"/><text x="100" y="75" font-size="3" fill="#333">日 一 二 三 四 五 六</text><text x="100" y="95" font-size="2.5" fill="#999">1 2 3 4 5 6 7</text><text x="100" y="110" font-size="2.5" fill="#333">8 9 10 11 12 13 14</text><text x="100" y="125" font-size="2.5" fill="#333">15 16 17 18 19 20 21</text></svg>'
            ],
            [
                'id' => 'calendar-minimal',
                'name' => '简约台历',
                'category' => 'calendar',
                'category_name' => '台历',
                'width' => 148,
                'height' => 210,
                'background' => '#ffffff',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="148" height="210" viewBox="0 0 148 210"><rect fill="white" x="2" y="2" width="144" height="206" rx="1" stroke="#eee" stroke-width="0.3"/><text x="74" y="40" text-anchor="middle" font-size="10" fill="#333" font-weight="bold">2026</text><text x="74" y="65" text-anchor="middle" font-size="5" fill="#999">JANUARY</text><line x1="30" y1="80" x2="118" y2="80" stroke="#333" stroke-width="1"/><text x="74" y="110" text-anchor="middle" font-size="4" fill="#333">日 一 二 三 四 五 六</text><text x="74" y="135" text-anchor="middle" font-size="3" fill="#999">1 2 3 4 5 6 7</text><text x="74" y="155" text-anchor="middle" font-size="3" fill="#333">8 9 10 11 12 13 14</text><text x="74" y="175" text-anchor="middle" font-size="3" fill="#333">15 16 17 18 19 20 21</text><text x="74" y="195" text-anchor="middle" font-size="3" fill="#333">22 23 24 25 26 27 28</text></svg>'
            ],
            // === 扩展：宣传单 ===
            [
                'id' => 'flyer-real-estate',
                'name' => '房地产宣传单',
                'category' => 'flyer',
                'category_name' => '宣传单',
                'width' => 210,
                'height' => 297,
                'background' => '#1a237e',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="210" height="297" viewBox="0 0 210 297"><rect fill="#1a237e" x="5" y="5" width="200" height="287" rx="3"/><rect fill="#283593" x="5" y="5" width="200" height="80"/><text x="105" y="35" text-anchor="middle" font-size="5" fill="#ffd54f">豪华住宅</text><text x="105" y="60" text-anchor="middle" font-size="8" fill="white" font-weight="bold">维港海景豪宅</text><rect fill="rgba(255,255,255,0.1)" x="20" y="100" width="170" height="100" rx="2"/><text x="105" y="130" text-anchor="middle" font-size="4" fill="#ccc">建筑面积 2,000 呎</text><text x="105" y="155" text-anchor="middle" font-size="4" fill="#ccc">4房2厅 · 2车位</text><text x="105" y="180" text-anchor="middle" font-size="4" fill="#ccc">顶级会所设施</text><text x="105" y="230" text-anchor="middle" font-size="12" fill="#ffd54f" font-weight="bold">$3,800万起</text><rect fill="#ffd54f" x="60" y="255" width="90" height="25" rx="5"/><text x="105" y="273" text-anchor="middle" font-size="4" fill="#1a237e" font-weight="bold">预约参观</text></svg>'
            ],
            [
                'id' => 'flyer-education',
                'name' => '教育课程宣传',
                'category' => 'flyer',
                'category_name' => '宣传单',
                'width' => 210,
                'height' => 297,
                'background' => '#e8f5e9',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="210" height="297" viewBox="0 0 210 297"><rect fill="#e8f5e9" x="5" y="5" width="200" height="287" rx="3"/><rect fill="#43a047" x="5" y="5" width="200" height="60"/><text x="105" y="30" text-anchor="middle" font-size="5" fill="white">2026暑期班</text><text x="105" y="50" text-anchor="middle" font-size="8" fill="white" font-weight="bold">STEAM教育课程</text><text x="105" y="90" text-anchor="middle" font-size="4" fill="#2e7d32">编程 · 机器人 · 科学实验</text><rect fill="white" x="25" y="110" width="160" height="40" rx="3"/><text x="105" y="130" text-anchor="middle" font-size="4" fill="#333" font-weight="bold">适合6-12岁儿童</text><text x="105" y="145" text-anchor="middle" font-size="3" fill="#666">小班教学 · 名师指导</text><rect fill="white" x="25" y="165" width="160" height="40" rx="3"/><text x="105" y="185" text-anchor="middle" font-size="4" fill="#333" font-weight="bold">早鸟优惠</text><text x="105" y="200" text-anchor="middle" font-size="3" fill="#e74c3c">6月30日前报名享8折</text><rect fill="#43a047" x="45" y="230" width="120" height="30" rx="5"/><text x="105" y="250" text-anchor="middle" font-size="4" fill="white" font-weight="bold">立即报名</text></svg>'
            ],
            [
                'id' => 'flyer-beauty',
                'name' => '美容宣传单',
                'category' => 'flyer',
                'category_name' => '宣传单',
                'width' => 210,
                'height' => 297,
                'background' => '#fce4ec',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="210" height="297" viewBox="0 0 210 297"><rect fill="#fce4ec" x="5" y="5" width="200" height="287" rx="3"/><rect fill="#e91e63" x="5" y="5" width="200" height="90"/><text x="105" y="35" text-anchor="middle" font-size="5" fill="rgba(255,255,255,0.9)">Beauty Salon</text><text x="105" y="65" text-anchor="middle" font-size="9" fill="white" font-weight="bold">焕颜美容中心</text><circle cx="105" cy="155" r="45" fill="#f8bbd0" opacity="0.5"/><text x="105" y="145" text-anchor="middle" font-size="4" fill="#c2185b">新客户专享</text><text x="105" y="170" text-anchor="middle" font-size="10" fill="#e91e63" font-weight="bold">体验价</text><text x="105" y="200" text-anchor="middle" font-size="6" fill="#ad1457">$388</text><text x="105" y="230" text-anchor="middle" font-size="3" fill="#888">原价 $888 · 面部护理60分钟</text><rect fill="#e91e63" x="55" y="255" width="100" height="25" rx="5"/><text x="105" y="273" text-anchor="middle" font-size="3" fill="white" font-weight="bold">预约热线：+852 8888 8888</text></svg>'
            ],
            // === 扩展：海报 ===
            [
                'id' => 'poster-movie',
                'name' => '电影海报',
                'category' => 'poster',
                'category_name' => '海报',
                'width' => 297,
                'height' => 420,
                'background' => '#0d0d0d',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="297" height="420" viewBox="0 0 297 420"><rect fill="#0d0d0d" x="5" y="5" width="287" height="410" rx="3"/><rect fill="#1a1a1a" x="5" y="300" width="287" height="115"/><text x="148" y="40" text-anchor="middle" font-size="4" fill="#ffd700" letter-spacing="5">COMING SOON</text><text x="148" y="120" text-anchor="middle" font-size="18" fill="#fff" font-weight="bold">THE LAST</text><text x="148" y="160" text-anchor="middle" font-size="18" fill="#fff" font-weight="bold">JOURNEY</text><line x1="80" y1="180" x2="216" y2="180" stroke="#ffd700" stroke-width="1"/><text x="148" y="210" text-anchor="middle" font-size="5" fill="#ccc">最后的旅程</text><text x="148" y="250" text-anchor="middle" font-size="4" fill="#888">导演：某某 · 主演：某某某</text><text x="148" y="340" text-anchor="middle" font-size="6" fill="#ffd700" font-weight="bold">2026年12月</text><text x="148" y="370" text-anchor="middle" font-size="4" fill="#ccc">全球上映</text></svg>'
            ],
            [
                'id' => 'poster-product',
                'name' => '产品发布海报',
                'category' => 'poster',
                'category_name' => '海报',
                'width' => 297,
                'height' => 420,
                'background' => '#f5f5f5',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="297" height="420" viewBox="0 0 297 420"><rect fill="#f5f5f5" x="5" y="5" width="287" height="410" rx="3"/><rect fill="#333" x="5" y="5" width="287" height="180"/><text x="148" y="60" text-anchor="middle" font-size="5" fill="#ffd700" letter-spacing="4">NEW PRODUCT</text><text x="148" y="110" text-anchor="middle" font-size="12" fill="white" font-weight="bold">全新产品</text><text x="148" y="145" text-anchor="middle" font-size="6" fill="#ccc">震撼上市</text><text x="148" y="240" text-anchor="middle" font-size="5" fill="#333" font-weight="bold">产品名称</text><text x="148" y="270" text-anchor="middle" font-size="4" fill="#666">全新设计 · 突破极限</text><text x="148" y="310" text-anchor="middle" font-size="10" fill="#e74c3c" font-weight="bold">$2,999</text><text x="148" y="350" text-anchor="middle" font-size="4" fill="#999">立即预订享早鸟价</text><rect fill="#333" x="98" y="375" width="100" height="25" rx="5"/><text x="148" y="393" text-anchor="middle" font-size="3" fill="white" font-weight="bold">了解更多</text></svg>'
            ],
            [
                'id' => 'poster-charity',
                'name' => '慈善活动海报',
                'category' => 'poster',
                'category_name' => '海报',
                'width' => 297,
                'height' => 420,
                'background' => '#e8f5e9',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="297" height="420" viewBox="0 0 297 420"><rect fill="#e8f5e9" x="5" y="5" width="287" height="410" rx="3"/><rect fill="#4caf50" x="5" y="5" width="287" height="100"/><text x="148" y="45" text-anchor="middle" font-size="5" fill="white" letter-spacing="3">CHARITY EVENT</text><text x="148" y="80" text-anchor="middle" font-size="10" fill="white" font-weight="bold">爱心慈善跑</text><text x="148" y="150" text-anchor="middle" font-size="6" fill="#2e7d32" font-weight="bold">为爱奔跑</text><text x="148" y="180" text-anchor="middle" font-size="4" fill="#558b2f">每一步都是爱的传递</text><circle cx="148" cy="250" r="50" fill="#a5d6a7" opacity="0.4"/><text x="148" y="240" text-anchor="middle" font-size="4" fill="#2e7d32">目标筹款</text><text x="148" y="270" text-anchor="middle" font-size="12" fill="#2e7d32" font-weight="bold">$100万</text><text x="148" y="330" text-anchor="middle" font-size="4" fill="#333">2026年10月1日</text><text x="148" y="355" text-anchor="middle" font-size="3" fill="#666">香港维多利亚公园</text><rect fill="#4caf50" x="83" y="380" width="130" height="25" rx="5"/><text x="148" y="398" text-anchor="middle" font-size="3" fill="white" font-weight="bold">立即报名参与</text></svg>'
            ],
            // === 扩展：邀请函 ===
            [
                'id' => 'invite-wedding',
                'name' => '婚礼邀请函',
                'category' => 'invitation',
                'category_name' => '邀请函',
                'width' => 140,
                'height' => 210,
                'background' => '#fdf2f8',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="140" height="210" viewBox="0 0 140 210"><rect fill="#fdf2f8" x="3" y="3" width="134" height="204" rx="2"/><rect fill="none" x="8" y="8" width="124" height="194" rx="1" stroke="#e8b4b8" stroke-width="0.5"/><text x="70" y="40" text-anchor="middle" font-size="4" fill="#c49a9a" letter-spacing="2">Together with their families</text><text x="70" y="70" text-anchor="middle" font-size="6" fill="#ad1457" font-weight="bold">陈小明</text><text x="70" y="95" text-anchor="middle" font-size="3" fill="#c49a9a">&amp;</text><text x="70" y="120" text-anchor="middle" font-size="6" fill="#ad1457" font-weight="bold">李小花</text><line x1="35" y1="135" x2="105" y2="135" stroke="#e8b4b8"/><text x="70" y="160" text-anchor="middle" font-size="3" fill="#999">2026年12月25日</text><text x="70" y="178" text-anchor="middle" font-size="3" fill="#999">下午三时</text><text x="70" y="196" text-anchor="middle" font-size="2.5" fill="#aaa">香港四季酒店</text></svg>'
            ],
            [
                'id' => 'invite-seminar',
                'name' => '研讨会邀请',
                'category' => 'invitation',
                'category_name' => '邀请函',
                'width' => 140,
                'height' => 210,
                'background' => '#e3f2fd',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="140" height="210" viewBox="0 0 140 210"><rect fill="#e3f2fd" x="3" y="3" width="134" height="204" rx="2"/><rect fill="#1565c0" x="3" y="3" width="134" height="40"/><text x="70" y="20" text-anchor="middle" font-size="4" fill="white" font-weight="bold">研讨会邀请</text><text x="70" y="35" text-anchor="middle" font-size="3" fill="rgba(255,255,255,0.8)">SEMINAR INVITATION</text><text x="70" y="70" text-anchor="middle" font-size="5" fill="#333" font-weight="bold">数字化转型</text><text x="70" y="95" text-anchor="middle" font-size="4" fill="#1565c0">研讨会</text><line x1="30" y1="110" x2="110" y2="110" stroke="#90caf9"/><text x="70" y="135" text-anchor="middle" font-size="3" fill="#666">主讲嘉宾：张博士</text><text x="70" y="155" text-anchor="middle" font-size="3" fill="#666">2026年7月15日</text><text x="70" y="175" text-anchor="middle" font-size="3" fill="#666">下午二时至五时</text><text x="70" y="195" text-anchor="middle" font-size="2.5" fill="#999">香港科学园</text></svg>'
            ],
            [
                'id' => 'invite-gala',
                'name' => '慈善晚宴邀请',
                'category' => 'invitation',
                'category_name' => '邀请函',
                'width' => 140,
                'height' => 210,
                'background' => '#1a1a2e',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="140" height="210" viewBox="0 0 140 210"><rect fill="#1a1a2e" x="3" y="3" width="134" height="204" rx="2"/><rect fill="none" x="8" y="8" width="124" height="194" rx="1" stroke="#c9a227" stroke-width="0.5"/><text x="70" y="40" text-anchor="middle" font-size="4" fill="#c9a227" letter-spacing="3">GALA DINNER</text><text x="70" y="75" text-anchor="middle" font-size="6" fill="white" font-weight="bold">慈善晚宴</text><line x1="35" y1="90" x2="105" y2="90" stroke="#c9a227" stroke-width="0.3"/><text x="70" y="115" text-anchor="middle" font-size="3" fill="#aaa">为儿童教育筹款</text><text x="70" y="145" text-anchor="middle" font-size="3" fill="#ccc">2026年9月18日</text><text x="70" y="165" text-anchor="middle" font-size="3" fill="#ccc">晚上六时半</text><text x="70" y="185" text-anchor="middle" font-size="3" fill="#ccc">香港君悦酒店</text><rect fill="#c9a227" x="40" y="192" width="60" height="8" rx="2"/></svg>'
            ],
            // === 扩展：优惠券 ===
            [
                'id' => 'coupon-beauty',
                'name' => '美容体验券',
                'category' => 'coupon',
                'category_name' => '优惠券',
                'width' => 200,
                'height' => 100,
                'background' => '#e91e63',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="200" height="100" viewBox="0 0 200 100"><rect fill="#e91e63" x="2" y="2" width="196" height="96" rx="3"/><circle cx="10" cy="50" r="7" fill="white"/><circle cx="190" cy="50" r="7" fill="white"/><text x="100" y="30" text-anchor="middle" font-size="4" fill="rgba(255,255,255,0.9)">美容体验券</text><text x="100" y="60" text-anchor="middle" font-size="15" fill="white" font-weight="bold">免费体验</text><text x="100" y="82" text-anchor="middle" font-size="3" fill="rgba(255,255,255,0.8)">面部护理一次 · 需预约</text></svg>'
            ],
            [
                'id' => 'coupon-coffee',
                'name' => '咖啡买一送一',
                'category' => 'coupon',
                'category_name' => '优惠券',
                'width' => 200,
                'height' => 100,
                'background' => '#5d4037',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="200" height="100" viewBox="0 0 200 100"><rect fill="#5d4037" x="2" y="2" width="196" height="96" rx="2"/><circle cx="10" cy="50" r="6" fill="#8d6e63"/><circle cx="190" cy="50" r="6" fill="#8d6e63"/><text x="100" y="28" text-anchor="middle" font-size="4" fill="#d7ccc8">COFFEE COUPON</text><text x="100" y="58" text-anchor="middle" font-size="12" fill="#ffd54f" font-weight="bold">买一送一</text><text x="100" y="82" text-anchor="middle" font-size="3" fill="#bcaaa4">任意饮品 · 有效期30天</text></svg>'
            ],
            [
                'id' => 'coupon-fitness',
                'name' => '健身体验券',
                'category' => 'coupon',
                'category_name' => '优惠券',
                'width' => 200,
                'height' => 100,
                'background' => '#212121',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="200" height="100" viewBox="0 0 200 100"><rect fill="#212121" x="2" y="2" width="196" height="96" rx="2"/><rect fill="#ff5722" x="2" y="2" width="196" height="8"/><text x="100" y="35" text-anchor="middle" font-size="5" fill="white" font-weight="bold">健身体验券</text><text x="100" y="65" text-anchor="middle" font-size="15" fill="#ff5722" font-weight="bold">7天免费</text><text x="100" y="88" text-anchor="middle" font-size="3" fill="#888">24小时健身房 · 团课体验</text></svg>'
            ],
            [
                'id' => 'coupon-birthday',
                'name' => '生日优惠券',
                'category' => 'coupon',
                'category_name' => '优惠券',
                'width' => 200,
                'height' => 100,
                'background' => '#ff9800',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="200" height="100" viewBox="0 0 200 100"><rect fill="#ff9800" x="2" y="2" width="196" height="96" rx="3"/><circle cx="30" cy="20" r="8" fill="rgba(255,255,255,0.2)"/><circle cx="170" cy="80" r="10" fill="rgba(255,255,255,0.2)"/><text x="100" y="30" text-anchor="middle" font-size="4" fill="white">Happy Birthday</text><text x="100" y="65" text-anchor="middle" font-size="18" fill="white" font-weight="bold">8折</text><text x="100" y="85" text-anchor="middle" font-size="3" fill="rgba(255,255,255,0.8)">生日当月享全单8折优惠</text></svg>'
            ],
            // === 扩展：餐牌 ===
            [
                'id' => 'menu-japanese',
                'name' => '日式料理餐牌',
                'category' => 'menu',
                'category_name' => '餐牌',
                'width' => 148,
                'height' => 210,
                'background' => '#fff8e1',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="148" height="210" viewBox="0 0 148 210"><rect fill="#fff8e1" x="3" y="3" width="142" height="204" rx="2"/><rect fill="#e65100" x="3" y="3" width="142" height="35"/><text x="74" y="25" text-anchor="middle" font-size="6" fill="white" font-weight="bold">日式料理</text><text x="10" y="55" font-size="4" fill="#e65100" font-weight="bold">前菜 APPETIZER</text><text x="10" y="72" font-size="3" fill="#555">枝豆</text><text x="130" y="72" text-anchor="end" font-size="3" fill="#555">$28</text><text x="10" y="88" font-size="3" fill="#555">炸豆腐</text><text x="130" y="88" text-anchor="end" font-size="3" fill="#555">$38</text><text x="10" y="110" font-size="4" fill="#e65100" font-weight="bold">寿司 SUSHI</text><text x="10" y="128" font-size="3" fill="#555">三文鱼寿司</text><text x="130" y="128" text-anchor="end" font-size="3" fill="#555">$45</text><text x="10" y="144" font-size="3" fill="#555">鳗鱼寿司</text><text x="130" y="144" text-anchor="end" font-size="3" fill="#555">$52</text><text x="10" y="166" font-size="4" fill="#e65100" font-weight="bold">拉面 RAMEN</text><text x="10" y="184" font-size="3" fill="#555">豚骨拉面</text><text x="130" y="184" text-anchor="end" font-size="3" fill="#555">$68</text></svg>'
            ],
            [
                'id' => 'menu-western',
                'name' => '西餐厅餐牌',
                'category' => 'menu',
                'category_name' => '餐牌',
                'width' => 148,
                'height' => 210,
                'background' => '#1a1a1a',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="148" height="210" viewBox="0 0 148 210"><rect fill="#1a1a1a" x="3" y="3" width="142" height="204" rx="2"/><rect fill="#c9a227" x="3" y="3" width="142" height="2"/><rect fill="#c9a227" x="3" y="205" width="142" height="2"/><text x="74" y="30" text-anchor="middle" font-size="7" fill="#c9a227" font-weight="bold">FINE DINING</text><text x="10" y="55" font-size="4" fill="#c9a227" font-weight="bold">STARTERS</text><text x="10" y="72" font-size="3" fill="#ccc">Caesar Salad</text><text x="130" y="72" text-anchor="end" font-size="3" fill="#c9a227">$88</text><text x="10" y="95" font-size="4" fill="#c9a227" font-weight="bold">MAIN COURSE</text><text x="10" y="112" font-size="3" fill="#ccc">Grilled Salmon</text><text x="130" y="112" text-anchor="end" font-size="3" fill="#c9a227">$188</text><text x="10" y="128" font-size="3" fill="#ccc">Ribeye Steak</text><text x="130" y="128" text-anchor="end" font-size="3" fill="#c9a227">$268</text><text x="10" y="151" font-size="4" fill="#c9a227" font-weight="bold">DESSERT</text><text x="10" y="168" font-size="3" fill="#ccc">Tiramisu</text><text x="130" y="168" text-anchor="end" font-size="3" fill="#c9a227">$68</text></svg>'
            ],
            [
                'id' => 'menu-bubble-tea',
                'name' => '珍珠奶茶餐牌',
                'category' => 'menu',
                'category_name' => '餐牌',
                'width' => 148,
                'height' => 210,
                'background' => '#fce4ec',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="148" height="210" viewBox="0 0 148 210"><rect fill="#fce4ec" x="3" y="3" width="142" height="204" rx="2"/><rect fill="#f06292" x="3" y="3" width="142" height="40"/><text x="74" y="28" text-anchor="middle" font-size="7" fill="white" font-weight="bold">BUBBLE TEA</text><text x="10" y="60" font-size="4" fill="#c2185b" font-weight="bold">经典系列</text><text x="10" y="80" font-size="3" fill="#555">原味珍珠奶茶</text><text x="130" y="80" text-anchor="end" font-size="3" fill="#555">$25</text><text x="10" y="96" font-size="3" fill="#555">黑糖珍珠鲜奶</text><text x="130" y="96" text-anchor="end" font-size="3" fill="#555">$30</text><text x="10" y="118" font-size="4" fill="#c2185b" font-weight="bold">水果系列</text><text x="10" y="138" font-size="3" fill="#555">芒果冰沙</text><text x="130" y="138" text-anchor="end" font-size="3" fill="#555">$28</text><text x="10" y="154" font-size="3" fill="#555">草莓奶盖</text><text x="130" y="154" text-anchor="end" font-size="3" fill="#555">$32</text><rect fill="#f06292" x="3" y="185" width="142" height="22"/><text x="74" y="200" text-anchor="middle" font-size="3" fill="white">满$100减$10</text></svg>'
            ],
            // === 扩展：社交媒体 ===
            [
                'id' => 'social-linkedin',
                'name' => 'LinkedIn封面',
                'category' => 'social',
                'category_name' => '社交媒体',
                'width' => 1128,
                'height' => 191,
                'background' => '#0077b5',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="1128" height="191" viewBox="0 0 1128 191"><rect fill="#0077b5" x="5" y="5" width="1118" height="181" rx="2"/><text x="564" y="80" text-anchor="middle" font-size="16" fill="white" font-weight="bold">Your Name</text><text x="564" y="115" text-anchor="middle" font-size="8" fill="rgba(255,255,255,0.8)">Professional Title | Company Name</text><text x="564" y="150" text-anchor="middle" font-size="5" fill="rgba(255,255,255,0.6)">linkedin.com/in/yourprofile</text></svg>'
            ],
            [
                'id' => 'social-youtube',
                'name' => 'YouTube缩略图',
                'category' => 'social',
                'category_name' => '社交媒体',
                'width' => 256,
                'height' => 144,
                'background' => '#ff0000',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="256" height="144" viewBox="0 0 256 144"><rect fill="#ff0000" x="2" y="2" width="252" height="140" rx="2"/><rect fill="rgba(0,0,0,0.3)" x="2" y="2" width="252" height="140" rx="2"/><circle cx="128" cy="72" r="25" fill="white" opacity="0.9"/><polygon points="120,60 120,84 140,72" fill="#ff0000"/><text x="128" y="120" text-anchor="middle" font-size="6" fill="white" font-weight="bold">视频标题</text></svg>'
            ],
            [
                'id' => 'social-wechat',
                'name' => '微信朋友圈',
                'category' => 'social',
                'category_name' => '社交媒体',
                'width' => 108,
                'height' => 192,
                'background' => '#07c160',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="108" height="192" viewBox="0 0 108 192"><rect fill="#07c160" x="2" y="2" width="104" height="188" rx="2"/><text x="54" y="40" text-anchor="middle" font-size="4" fill="white">新品上市</text><circle cx="54" cy="100" r="30" fill="white" opacity="0.2"/><text x="54" y="95" text-anchor="middle" font-size="6" fill="white" font-weight="bold">限时</text><text x="54" y="115" text-anchor="middle" font-size="6" fill="white" font-weight="bold">优惠</text><rect fill="white" x="24" y="150" width="60" height="18" rx="3"/><text x="54" y="163" text-anchor="middle" font-size="3" fill="#07c160" font-weight="bold">立即抢购</text></svg>'
            ],
            // === 扩展：贺卡 ===
            [
                'id' => 'greeting-christmas',
                'name' => '圣诞贺卡',
                'category' => 'greeting',
                'category_name' => '贺卡',
                'width' => 148,
                'height' => 105,
                'background' => '#1b5e20',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="148" height="105" viewBox="0 0 148 105"><rect fill="#1b5e20" x="3" y="3" width="142" height="99" rx="2"/><rect fill="#c62828" x="3" y="3" width="142" height="5"/><rect fill="#c62828" x="3" y="97" width="142" height="5"/><text x="74" y="30" text-anchor="middle" font-size="4" fill="#ffd54f">Merry Christmas</text><text x="74" y="60" text-anchor="middle" font-size="7" fill="white" font-weight="bold">圣诞快乐</text><text x="74" y="85" text-anchor="middle" font-size="3" fill="#a5d6a7">2026</text></svg>'
            ],
            [
                'id' => 'greeting-valentine',
                'name' => '情人节贺卡',
                'category' => 'greeting',
                'category_name' => '贺卡',
                'width' => 148,
                'height' => 105,
                'background' => '#fce4ec',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="148" height="105" viewBox="0 0 148 105"><rect fill="#fce4ec" x="3" y="3" width="142" height="99" rx="2"/><rect fill="none" x="7" y="7" width="134" height="91" rx="1" stroke="#f8bbd0" stroke-width="0.5"/><circle cx="40" cy="30" r="10" fill="#f48fb1" opacity="0.3"/><circle cx="108" cy="75" r="12" fill="#f48fb1" opacity="0.3"/><text x="74" y="35" text-anchor="middle" font-size="5" fill="#e91e63">Happy</text><text x="74" y="60" text-anchor="middle" font-size="5" fill="#e91e63">Valentines</text><text x="74" y="85" text-anchor="middle" font-size="3" fill="#ad1457">I Love You</text></svg>'
            ],
            [
                'id' => 'greeting-mid-autumn',
                'name' => '中秋贺卡',
                'category' => 'greeting',
                'category_name' => '贺卡',
                'width' => 148,
                'height' => 105,
                'background' => '#1a237e',
                'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="148" height="105" viewBox="0 0 148 105"><rect fill="#1a237e" x="3" y="3" width="142" height="99" rx="2"/><circle cx="74" cy="35" r="20" fill="#ffd54f"/><circle cx="68" cy="30" r="18" fill="#1a237e"/><text x="74" y="75" text-anchor="middle" font-size="6" fill="#ffd54f" font-weight="bold">中秋快乐</text><text x="74" y="93" text-anchor="middle" font-size="3" fill="rgba(255,255,255,0.6)">人月两团圆</text></svg>'
            ],
        ];

        foreach ($templates as &$t) {
            $t['preview'] = 'data:image/svg+xml;base64,' . base64_encode($t['svg']);
        }

        return $templates;
    }

    public function index($productId = null)
    {
        $templates = $this->getTemplates();

        $shapes = [
            ['type' => 'rect', 'name' => '矩形', 'icon' => 'square'],
            ['type' => 'circle', 'name' => '圆形', 'icon' => 'circle'],
            ['type' => 'triangle', 'name' => '三角形', 'icon' => 'triangle'],
            ['type' => 'line', 'name' => '线条', 'icon' => 'minus'],
            ['type' => 'ellipse', 'name' => '椭圆', 'icon' => 'circle'],
            ['type' => 'diamond', 'name' => '菱形', 'icon' => 'square'],
            ['type' => 'star', 'name' => '星形', 'icon' => 'star'],
            ['type' => 'heart', 'name' => '心形', 'icon' => 'heart'],
            ['type' => 'hexagon', 'name' => '六边形', 'icon' => 'hexagon'],
            ['type' => 'roundedRect', 'name' => '圆角矩形', 'icon' => 'rectangle'],
            ['type' => 'dashedLine', 'name' => '虚线', 'icon' => 'minus'],
            ['type' => 'dotLine', 'name' => '点线', 'icon' => 'circle']
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
        $designData = $request->input('design_data');
        $designToken = $request->input('design_token', 'temp_' . time());

        if (empty($designData)) {
            return response()->json([
                'success' => false,
                'message' => '设计数据为空'
            ], 422);
        }

        session(['design_data_' . $designToken => json_decode($designData, true) ?: $designData]);

        try {
            $design = Design::create([
                'user_id' => Auth::id(),
                'product_id' => $request->input('product_id'),
                'design_data' => json_decode($designData, true) ?: $designData,
                'meta' => [
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ],
            ]);

            Log::info('Design saved', ['design_id' => $design->id, 'user_id' => Auth::id()]);

            return response()->json([
                'success' => true,
                'message' => '设计已保存',
                'design_id' => $design->id,
                'design_token' => $designToken,
            ]);
        } catch (\Exception $e) {
            Log::error('Design save failed', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => true,
                'message' => '设计已保存（本地）',
                'design_token' => $designToken,
            ]);
        }
    }

    public function orderProduct($token)
    {
        $designData = session('design_data_' . $token);
        if (!$designData) {
            return redirect()->route('designer.index')->with('error', '设计数据已过期，请重新设计');
        }

        $product = null;
        if (class_exists('\App\Models\Product')) {
            $product = \App\Models\Product::where('pro_name', 'LIKE', '%在线设计%')
                ->orWhere('pro_name', 'LIKE', '%在線設計%')
                ->first();
        }

        if (!$product) {
            $product = (object) [
                'pro_id' => 0,
                'pro_name' => '在线设计定制印刷',
                'pro_price' => 88,
                'pro_stock' => 9999,
                'pro_desc' => '您在GoPrint在线设计工具中创作的个性化印刷品。专业印刷，品质保证。',
                'pro_image' => null,
                'category' => (object) ['cat_name' => '在线设计']
            ];
        }

        return view('designer.order', compact('product', 'designData', 'token'));
    }
}
