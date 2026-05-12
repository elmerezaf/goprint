import os
import shutil

# 图片文件夹路径
image_dir = r'C:\xampp\htdocs\goprint\laravel\public\storage\products'

# 产品类别与图片映射
category_images = {
    'business-card': ['gop1 (1).png', 'gop1 (2).png', 'gop1 (3).png', 'gop1 (4).png', 'gop1 (5).png'],
    'flyer': ['gop1 (6).png', 'gop1 (7).png', 'gop1 (8).png', 'gop1 (9).png', 'gop1 (10).png'],
    'brochure': ['gop1 (11).png', 'gop1 (12).png', 'gop1 (13).png', 'gop1 (14).png', 'gop1 (15).png'],
    'poster': ['gop1 (16).png', 'gop1 (17).png', 'gop1 (18).png', 'gop1 (19).png', 'gop1 (20).png'],
    'banner': ['gop1 (21).png']
}

# 产品名称映射（修复乱码）
product_names = {
    1: {'name': 'Premium Business Cards', 'category': 'business-card'},
    2: {'name': 'A4 Flyer Printing', 'category': 'flyer'},
    3: {'name': 'Product Brochure', 'category': 'brochure'},
    4: {'name': 'A4 Color Paper', 'category': 'paper'},
    5: {'name': 'Company Business Card', 'category': 'business-card'},
    6: {'name': 'Booklet Brochure', 'category': 'brochure'},
    7: {'name': 'Poster Printing', 'category': 'poster'},
    8: {'name': 'Custom Sticker Printing', 'category': 'sticker'},
    9: {'name': 'Product Packaging', 'category': 'packaging'},
    10: {'name': 'Handbag', 'category': 'bag'},
    11: {'name': 'Calendar Printing', 'category': 'calendar'},
    12: {'name': 'A5 Flyer Printing', 'category': 'flyer'},
    13: {'name': 'A4 Tri-fold Brochure', 'category': 'brochure'},
    14: {'name': 'Canvas Bag', 'category': 'bag'},
    15: {'name': 'A4 Printing', 'category': 'paper'},
    16: {'name': 'Offset Printing', 'category': 'printing'},
    17: {'name': 'Digital Printing', 'category': 'printing'},
    18: {'name': 'Mini Notebook', 'category': 'stationery'},
    19: {'name': 'PVC Card Printing', 'category': 'card'},
    20: {'name': 'Round Sticker', 'category': 'sticker'},
    21: {'name': 'Rectangle Sticker', 'category': 'sticker'},
    22: {'name': 'Transparent Sticker', 'category': 'sticker'},
    23: {'name': 'Surface Sticker', 'category': 'sticker'},
    24: {'name': 'A2 Poster', 'category': 'poster'},
    25: {'name': 'A1 Outdoor Poster', 'category': 'poster'},
    26: {'name': 'Foamboard Display', 'category': 'display'},
    27: {'name': 'A3 Poster', 'category': 'poster'},
    28: {'name': 'Color Envelope', 'category': 'envelope'},
    29: {'name': 'Sticker Roll', 'category': 'sticker'},
    30: {'name': 'Document Binding', 'category': 'binding'},
    31: {'name': 'Long Envelope', 'category': 'envelope'},
    32: {'name': 'Outdoor Banner', 'category': 'banner'},
    33: {'name': 'X Banner Stand', 'category': 'display'},
    34: {'name': 'Background Wall Cloth', 'category': 'display'},
    35: {'name': 'Flag Banner', 'category': 'banner'}
}

def rename_images():
    """重命名图片文件"""
    print("🔄 开始重命名图片文件...")
    
    # 创建类别索引
    category_index = {cat: 1 for cat in category_images.keys()}
    
    for pro_id, info in product_names.items():
        category = info['category']
        name = info['name']
        
        # 获取可用的图片
        if category in category_images and category_images[category]:
            old_name = category_images[category].pop(0)
            extension = os.path.splitext(old_name)[1]
            new_name = f"{category}_{category_index[category]}{extension}"
            category_index[category] += 1
            
            old_path = os.path.join(image_dir, old_name)
            new_path = os.path.join(image_dir, new_name)
            
            if os.path.exists(old_path):
                shutil.move(old_path, new_path)
                print(f"✅ 重命名: {old_name} -> {new_name}")
                product_names[pro_id]['image'] = new_name
            else:
                print(f"❌ 文件不存在: {old_name}")
                product_names[pro_id]['image'] = None
        else:
            # 使用默认图片或同类别图片
            product_names[pro_id]['image'] = f"{category}_1.png"
    
    print("✅ 图片重命名完成！")

def generate_sql_update():
    """生成 SQL 更新语句"""
    print("\n📝 生成 SQL 更新语句...")
    sql_lines = []
    
    for pro_id, info in product_names.items():
        image = info['image']
        name = info['name']
        sql_lines.append(f"UPDATE product SET pro_name = '{name}', pro_image = '{image}' WHERE pro_id = {pro_id};")
    
    # 保存 SQL 文件
    sql_file = os.path.join(image_dir, 'update_product_images.sql')
    with open(sql_file, 'w', encoding='utf-8') as f:
        f.write('\n'.join(sql_lines))
    
    print(f"✅ SQL 文件已保存: {sql_file}")
    return sql_lines

def main():
    rename_images()
    generate_sql_update()
    
    # 打印结果
    print("\n📊 产品图片映射结果:")
    print("-" * 60)
    print(f"{'ID':<4} {'名称':<30} {'类别':<15} {'图片'}")
    print("-" * 60)
    for pro_id, info in product_names.items():
        print(f"{pro_id:<4} {info['name']:<30} {info['category']:<15} {info.get('image', '无')}")

if __name__ == '__main__':
    main()