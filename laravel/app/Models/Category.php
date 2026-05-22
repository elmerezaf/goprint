<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'category';
    protected $primaryKey = 'cat_id';
    public $timestamps = false;

    protected $fillable = [
        'cat_id',
        'cat_name',
        'cat_name_en',
        'cat_desc',
        'cat_desc_en',
        'create_time'
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'cat_id');
    }

    private static function getNameTranslationTable(): array
    {
        return [
            1 => 'Business Cards & Stationery',
            2 => 'Flyers & Leaflets',
            3 => 'Books & Booklets',
            4 => 'Posters & Display Boards',
            5 => 'Stickers & Labels',
            6 => 'Envelopes & Office Supplies',
            7 => 'Festive & Greeting Cards',
            8 => 'Red Packets',
            9 => 'Corporate Gifts & Premiums',
            10 => 'Packaging & Paper Bags',
            11 => 'Digital Printing',
        ];
    }

    private static function getDescTranslationTable(): array
    {
        return [
            1 => 'Corporate business cards, member cards, vouchers, and all business stationery printing',
            2 => 'A4/A5 single sheet, bi-fold, tri-fold, z-fold, and all leaflet and flyer options',
            3 => 'Saddle stitch, perfect binding, hardcover, instruction manuals, catalogs, and magazines',
            4 => 'Indoor/outdoor posters, foamboard, rollup banners, backdrops, and display boards',
            5 => 'Digital stickers, clear stickers, waterproof labels, product labels, and custom stickers',
            6 => 'Color envelopes, letterhead printing, document pockets, NCR forms, and office stationery',
            7 => 'Christmas cards, New Year cards, thank you cards, invitation cards, and all greeting cards',
            8 => 'Traditional red packets, square, mini, and custom style Chinese New Year red envelopes',
            9 => 'Promotional pens, memo pads, canvas bags, water bottles, USB drives, and corporate gifts',
            10 => 'Gift boxes, paper bags, wrapping paper, corrugated boxes, and all packaging solutions',
            11 => 'Rush printing, short-run printing, same-day delivery, and quick digital printing services',
        ];
    }

    public function getLocalizedNameAttribute()
    {
        $locale = app()->getLocale();
        if ($locale === 'en') {
            if (!empty($this->cat_name_en)) {
                return $this->cat_name_en;
            }
            $table = self::getNameTranslationTable();
            if (isset($table[$this->cat_id])) {
                return $table[$this->cat_id];
            }
            return $this->cat_name;
        }
        return $this->cat_name;
    }

    public function getLocalizedDescAttribute()
    {
        $locale = app()->getLocale();
        if ($locale === 'en') {
            if (!empty($this->cat_desc_en)) {
                return $this->cat_desc_en;
            }
            $table = self::getDescTranslationTable();
            if (isset($table[$this->cat_id])) {
                return $table[$this->cat_id];
            }
            return $this->cat_desc;
        }
        return $this->cat_desc;
    }
}
