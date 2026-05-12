import os
import shutil

image_dir = r'C:\xampp\htdocs\goprint\laravel\public\storage\products'

product_data = {
    1: {'name': '高檔名片印刷', 'category': 'business-card', 'current_image': '1778222064.jpg'},
    2: {'name': 'A4宣傳單打印', 'category': 'flyer', 'current_image': '1778222125.jpg'},
    3: {'name': '產品包裝盒', 'category': 'brochure', 'current_image': '1778222139.jpg'},
    4: {'name': 'A4彩色傳單', 'category': 'flyer', 'current_image': '1778222152.jpg'},
    5: {'name': '企業名片', 'category': 'business-card', 'current_image': '1778222165.jpg'}
}

category_images = {
    'business-card': [],
    'flyer': [],
    'brochure': [],
    'poster': [],
    'banner': [],
    'other': []
}

def scan_images():
    print("🔍 扫描图片文件夹...")
    for filename in os.listdir(image_dir):
        if filename.lower().endswith(('.png', '.jpg', '.jpeg', '.webp')) and not filename.startswith('hero-') and not filename.startswith('service-'):
            filepath = os.path.join(image_dir, filename)
            if os.path.isfile(filepath):
                found = False
                for cat in category_images.keys():
                    if cat in filename.lower():
                        category_images[cat].append(filename)
                        found = True
                        break
                if not found:
                    category_images['other'].append(filename)
    
    print("\n📁 图片分类结果:")
    for cat, images in category_images.items():
        print(f"  {cat}: {len(images)} 张图片")
        for img in images:
            print(f"    - {img}")

def generate_sql_update():
    print("\n📝 生成 SQL 更新语句...")
    sql_lines = []
    used_images = set()
    
    for pro_id, info in product_data.items():
        category = info['category']
        current_image = info['current_image']
        
        new_image = None
        if category_images[category]:
            for img in category_images[category]:
                if img not in used_images:
                    new_image = img
                    used_images.add(img)
                    break
        
        if not new_image and category_images['other']:
            for img in category_images['other']:
                if img not in used_images:
                    new_image = img
                    used_images.add(img)
                    break
        
        if new_image:
            sql_lines.append(f"UPDATE product SET pro_image = '{new_image}' WHERE pro_id = {pro_id};")
            print(f"✅ 产品 {pro_id} ({info['name']}): {current_image} -> {new_image}")
        else:
            sql_lines.append(f"-- 产品 {pro_id} ({info['name']}): 没有找到合适的图片")
            print(f"❌ 产品 {pro_id} ({info['name']}): 没有找到合适的图片")
    
    sql_file = os.path.join(image_dir, 'update_product_images_final.sql')
    with open(sql_file, 'w', encoding='utf-8') as f:
        f.write('\n'.join(sql_lines))
    
    print(f"\n✅ SQL 文件已保存: {sql_file}")
    return sql_lines

def update_product_view():
    print("\n🔄 更新产品列表视图以显示图片...")
    view_path = r'C:\xampp\htdocs\goprint\laravel\resources\views\products\index.blade.php'
    
    with open(view_path, 'r', encoding='utf-8') as f:
        content = f.read()
    
    old_html = '''<div class="card-img-wrap" style="background: linear-gradient(135deg, {{ '#' . substr(md5($product->pro_name), 0, 6) }}, {{ '#' . substr(md5($product->pro_id), 0, 6) }});">
                                    <i class="fas fa-print"></i>'''
    
    new_html = '''<div class="card-img-wrap" style="background: linear-gradient(135deg, {{ '#' . substr(md5($product->pro_name), 0, 6) }}, {{ '#' . substr(md5($product->pro_id), 0, 6) }});">
                                    @if($product->pro_image)
                                        <img src="{{ asset('storage/products/' . $product->pro_image) }}" alt="{{ $product->pro_name }}" class="card-img-top" style="max-height: 150px; object-fit: cover;">
                                    @else
                                        <i class="fas fa-print"></i>
                                    @endif'''
    
    if old_html in content:
        content = content.replace(old_html, new_html)
        with open(view_path, 'w', encoding='utf-8') as f:
            f.write(content)
        print("✅ 产品列表视图已更新")
    else:
        print("❌ 未找到需要更新的代码段")

def main():
    scan_images()
    generate_sql_update()
    update_product_view()
    
    print("\n🎉 图片修复完成！")
    print("\n📋 下一步操作：")
    print("1. 运行生成的 SQL 文件更新数据库")
    print("2. 清除浏览器缓存后刷新页面查看效果")

if __name__ == '__main__':
    main()