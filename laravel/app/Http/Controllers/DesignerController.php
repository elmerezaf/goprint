<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DesignerController extends Controller
{
    private function getTemplates()
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
        $data = $request->input('design_data');
        
        return response()->json([
            'success' => true,
            'message' => '设计已保存',
            'data' => $data
        ]);
    }
}
