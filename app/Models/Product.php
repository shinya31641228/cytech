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

    /**
     * 商品をDBへ登録する
     * @param $request
     *
     */
    public function productRegistration(Request $request)
    {
        //画像ファイルパスを格納
        $image_file_path = $this->getImageFilePath($request);
        //商品データを受け取る
        $inputs = $request->all();
        //メーカー名をcompaniesテーブルから取得
        $company_name = Company::find($inputs['company_id']);
        \DB::beginTransaction();
        try {
            //商品を登録
            Product::create([
                'user_id' => $inputs['user_id'],
                'products_name' => $inputs['products_name'],
                'company_id' => $inputs['company_id'],
                'company_name' => $company_name['company_name'],
                'price' => $inputs['price'],
                'stock' => $inputs['stock'],
                'comment' => $inputs['comment'],
                'image' => $image_file_path,
            ]);
            \DB::commit();
        } catch (\Throwable $e) {
            \DB::rollback();
            abort(500);
        }
        \Session::flash('flash_message', '商品を登録しました');
    }

    /**
     * 商品を更新する
     * @param $request
     *
     */

    public function productUpdate(Request $request)
    {
        //画像ファイルパスを格納
        $image_file_path = $this->getImageFilePath($request);
        //商品データを受け取る
        $inputs = $request->all();
        //companiesテーブルからcompany_nameを取得
        $company_name = Company::find($inputs['company_id']);
        \DB::beginTransaction();
        try {
            //商品を登録
            $product = Product::find($inputs['id']);
            // dd($product);
            $product->fill([
                'products_name' => $inputs['products_name'],
                'company_id' => $inputs['company_id'],
                'company_name' => $company_name['company_name'],
                'price' => $inputs['price'],
                'stock' => $inputs['stock'],
                'comment' => $inputs['comment'],
                'image' => $image_file_path,
            ]);
            $product->save();
            \DB::commit();
        } catch (\Throwable $e) {
            \DB::rollback();
            abort(500);
        }
        \Session::flash('flash_message', '商品を更新しました');
    }

    /**
     * statusを2に更新する(削除する)
     * @param $request, $id
     */
    public function productDelete(Request $request, $id){
        //商品を削除
        \DB::beginTransaction();
        try {
            Product::where('id', $id)->update(['status' => 2]);
            \DB::commit();
        } catch (\Throwable $e) {
            \DB::rollback();
            abort(500);
        }
    }

    /**
     * statusを2に更新する(削除する)
     * @param $request
     * @return
     */
    public function productSearch(Request $request){
        //入力される値nameの中身を定義する
        $search_word = $request->input('search_word'); //商品名の値
        $company_id = $request->input('company_id'); //メーカーの値

        $query = Product::query();

        //商品名が入力された場合、productsテーブルから一致する商品を$queryに代入
        if (isset($search_word)) {
            $query->where('products_name', 'like', "%$search_word%");
        }
        //メーカーが選択された場合、productsテーブルからcompany_idが一致する商品を$queryに代入
        if (isset($category_id)) {
            $query->where('company_id', $company_id);
        }

        //$queryをcompany_idの昇順に並び替えて$productsに代入
        $products = $query->where('status', 1)->get();

        //m_categoriesテーブルからgetLists();関数でcategory_nameとidを取得する
        $company = new Company();
        $companies = $company->getLists();

        \Session::flash('flash_message', '「' . $search_word . '」の検索結果' . count($products) . '件');

        return [
            'products' => $products,
            'companies' => $companies,
            'search_word' => $search_word,
            'company_id' => $company_id,
        ];
    }
}
