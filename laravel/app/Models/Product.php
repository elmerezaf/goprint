<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product';
    protected $primaryKey = 'pro_id';
    public $timestamps = false;

    protected $fillable = [
        'pro_id',
        'cat_id',
        'pro_name',
        'pro_name_en',
        'pro_desc',
        'pro_desc_en',
        'pro_price',
        'pro_stock',
        'create_time',
        'pro_image'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'cat_id');
    }

    private static function getNameTranslationTable(): array
    {
        return [
            1 => 'Standard Business Cards (90x54mm)',
            2 => 'Matte Laminated Business Cards',
            3 => 'Spot UV Business Cards',
            4 => 'Premium Thick Card Business Cards',
            5 => 'Folded Business Cards',
            6 => 'A5 Promotional Flyers',
            7 => 'A4 Promotional Flyers',
            8 => 'DL Flyers (99x210mm)',
            9 => 'A4 Trifold Brochures',
            10 => 'A4 Bi-fold Brochures',
            11 => 'Saddle Stitch Booklets',
            12 => 'Perfect Binding Books',
            13 => 'Hardcover Books',
            14 => 'Twin Ring Binding Books',
            15 => 'Wire-O Binding Books',
            16 => 'A3 Posters',
            17 => 'A2 Posters',
            18 => 'A1 Large Format Posters',
            19 => 'Foamboard Display Boards',
            20 => 'Rollup Banners',
            21 => 'Digital Stickers',
            22 => 'Clear Stickers',
            23 => 'Kraft Paper Stickers',
            24 => 'Resin Dome Stickers',
            25 => 'Custom Shape Stickers',
            26 => 'Colorful DL Envelopes',
            27 => 'C5 Envelopes',
            28 => 'C4 Large Envelopes',
            29 => 'Company Letterheads',
            30 => 'NCR Duplicate Books',
            31 => 'Christmas Cards',
            32 => 'New Year Greeting Cards',
            33 => 'Thank You Cards',
            34 => 'Event Invitation Cards',
            35 => 'Square Red Packets (9x9cm)',
            36 => 'Rectangle Red Packets (9x17cm)',
            37 => 'Mini Red Packets (8x11cm)',
            38 => 'Premium Velvet Red Packets',
            39 => 'Cartoon Red Packet Set',
            40 => 'Custom Memo Pads',
            41 => 'Promotional Pens',
            42 => 'Canvas Tote Bags',
            43 => 'Desk Calendars',
            44 => 'Promotional Hand Fans',
            45 => 'Gift Packaging Boxes',
            46 => 'Custom Paper Bags',
            47 => 'Corrugated Boxes',
            48 => 'Wrapping Paper',
            49 => 'Rush Digital Printing',
            50 => 'Short Run Digital Printing',
            51 => 'Variable Data Printing',
            52 => 'Digital Booklets',
        ];
    }

    private static function getDescTranslationTable(): array
    {
        return [
            1 => '300g coated paper, full color double-sided printing, 500 sheets per box, our most popular classic style',
            2 => '300g matte paper, double-sided matte lamination, premium feel, perfect for professional image',
            3 => '300g coated paper with spot UV varnish, 3D logo effect, business top choice',
            4 => '400g premium thick card, full color double-sided, outstanding quality for premium business occasions',
            5 => '180x54mm folded design, double-sided printing, double information capacity, ideal for service industry',
            6 => 'A5 size (148x210mm), 157g coated paper, double-sided full color, minimum 1000 sheets',
            7 => 'A4 size (210x297mm), 157g coated paper, perfect for menus and price lists',
            8 => 'Long strip design, fits DL envelopes for mailing, ideal for promotions and marketing',
            9 => 'A4 accordion fold, 200g matte paper, six panel design, perfect for product catalogs and service introductions',
            10 => 'A4 bi-fold, four panel design, ideal for event introductions and company overviews',
            11 => 'A5/A4 size, 8-64 pages, optional lamination on cover, suitable for brochures and journals',
            12 => 'A5/A4 size, ideal for books with more pages, professional adhesive binding',
            13 => 'Hardcover with gold/silver foil on spine, perfect for commemorative albums, portfolios and annual reports',
            14 => 'Twin ring binding, lies completely flat when opened, ideal for manuals, recipe books and guides',
            15 => 'Double reinforcement with wire stitching and adhesive, ideal for thick books, durable and long-lasting',
            16 => 'A3 size, 200g matte paper, single-sided full color printing, perfect for shop window displays',
            17 => 'A2 size, 200g coated paper, high definition printing, ideal for malls and exhibition promotions',
            18 => 'Waterproof PP paper, indoor or outdoor use available, UV resistant and fade proof',
            19 => '5mm KT board mounting, edge wrapping, optional frame, ideal for exhibitions and launches',
            20 => '80x200cm standard size, waterproof PP with aluminum alloy stand, portable and easy to assemble',
            21 => 'Multiple shapes available, waterproof PVC material, ideal for product labels and promotional stickers',
            22 => 'Fully transparent PVC, full color printing, perfect for glass windows and product packaging',
            23 => 'Vintage kraft paper style, popular for artisan brands, eco-friendly and recyclable material',
            24 => '3D dome resin effect, waterproof and wear resistant, premium quality, ideal for brand logos',
            25 => 'Custom shapes and sizes, die-cut effect available, perfect for creative designs',
            26 => 'DL size (110x220mm), full color printing, minimum 1000 pieces, ideal for business correspondence',
            27 => 'C5 size (162x229mm), fits A5 documents without folding, minimum 1000 pieces',
            28 => 'C4 size (229x324mm), fits A4 documents, convenient for mailing important documents',
            29 => 'A4 size, 100g writing paper, single-sided full color printing, minimum 500 sheets',
            30 => 'Carbonless duplicate books, 2-part/3-part options available, ideal for receipts and delivery orders',
            31 => 'A6 folded cards, 250g art paper, multiple designs available, with envelopes included',
            32 => 'Chinese festive design, optional gold foil effect, perfect for corporate New Year gifts',
            33 => 'A6 size, 250g art paper, double-sided full color, suitable for weddings or business occasions',
            34 => 'Custom size and design, optional gold foil, embossing or die-cut special finishing',
            35 => 'Traditional square style, 9x9cm, 128g art paper, gold foil patterns, minimum 100 pieces',
            36 => 'Classic rectangle style, 9x17cm, 128g art paper, multiple gold foil designs available',
            37 => 'Delicate mini style, 8x11cm, perfect for giving to children or colleagues, minimum 100 pieces',
            38 => 'Velvet texture feel, gold or silver foil effect, elegant and dignified, top choice for corporate gifts',
            39 => 'Multiple cartoon designs, 10 pieces per set, childrens favorite, essential for Chinese New Year',
            40 => 'Custom cover and inner page design, practical corporate gift, perfect for exhibition giveaways',
            41 => 'Metal or plastic pen body, full color printing of company logo, minimum 100 pens',
            42 => 'Multiple colors available, silk screen or heat transfer logo printing, eco-friendly practical corporate gift',
            43 => '13 pages full color printing, customizable company info and holiday markers, must-have year-end gift',
            44 => 'Handheld or desktop advertising fans, essential for summer outdoor promotion, economical and practical',
            45 => 'Custom size and design, optional gold foil, embossing or UV effects, premium quality',
            46 => 'Multiple sizes and colors, white card or kraft paper material, optional cotton rope or ribbon handles',
            47 => 'Economical corrugated boxes, ideal for shipping packaging and storage, single color logo printing available',
            48 => 'Lightweight wrapping paper, can print brand logos and patterns, perfect for retail stores',
            49 => 'Same day delivery available, ideal for urgent needs, A4/A3 sizes',
            50 => 'Print from one copy, no minimum order quantity, perfect for startups and small projects',
            51 => 'Each print with different content (name/number), perfect for invitation cards, coupons and certificates',
            52 => 'A5 digital printing booklets, saddle stitch binding, 8-24 pages, perfect for product catalogs',
        ];
    }

    public function getLocalizedNameAttribute()
    {
        $locale = app()->getLocale();
        if ($locale === 'en') {
            if (!empty($this->pro_name_en)) {
                return $this->pro_name_en;
            }
            $table = self::getNameTranslationTable();
            if (isset($table[$this->pro_id])) {
                return $table[$this->pro_id];
            }
            return $this->pro_name;
        }
        return $this->pro_name;
    }

    public function getLocalizedDescAttribute()
    {
        $locale = app()->getLocale();
        if ($locale === 'en') {
            if (!empty($this->pro_desc_en)) {
                return $this->pro_desc_en;
            }
            $table = self::getDescTranslationTable();
            if (isset($table[$this->pro_id])) {
                return $table[$this->pro_id];
            }
            return $this->pro_desc;
        }
        return $this->pro_desc;
    }
}
