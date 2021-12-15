<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Product extends Model
{
    use HasFactory;

    //テーブル名
    protected $table = 'products';

    //可変項目
    protected $fillable =
    [
        'user_id',
        'products_name',
        'company_id',
        'company_name',
        'price',
        'stock',
        'comment',
        'image',
        'status',
    ];

    /**
     *「商品(products)はカテゴリ(company)に属する」というリレーション関係を定義する
     *
     * @return
     */
    public function category()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * 画像のファイルパスを登録する
     *
     */
    public function getImageFilePath(Request $request)
    {
        // storage/app/public/images に割り振られたIDのファイル名で保存される
        $file_path = \Storage::put('/public', $request->file('image'));
        //ファイル名のみに分解
        $file_path = explode('/', $file_path);
        // DBにはファイルへのパスを登録
        $product_image = new Product();
        $product_image->image = $file_path[1];

        return $product_image->image;
    }
}
