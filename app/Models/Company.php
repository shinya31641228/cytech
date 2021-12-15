<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';

    //可変項目
    protected $fillable =
    [
        'id',
        'company_name',
    ];

    //companiesテーブルから::pluckでcompany_nameとidを抽出し、$companiesに返す関数を作る
    public function getLists()
    {
        $companies = Company::pluck('company_name', 'id');

        return $companies;
    }
    //「メーカー(company)はたくさんの商品(products)をもつ」というリレーション関係を定義する
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
