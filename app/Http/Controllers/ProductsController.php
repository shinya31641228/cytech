<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use \App\Http\Controllers\HomeController;
use \App\Models\Company;
use \App\Models\User;
use Illuminate\Routing\Matching\HostValidator;

class ProductsController extends Controller
{

    /**
     *商品登録画面を表示する
     *
     * @return view
     */
    public function showCreate()
    {    //メーカー名をcompaniesテーブルから取得
        $companies = Company::getLists();
        //ログインしているユーザー情報を渡す
        $user = \Auth::user();

        return view('products.create', ['user' => $user, 'companies' => $companies]);
    }

    /**
     *商品を登録する
     * @param $request
     * @return view
     */
    public function exeStore(Request $request)
    {
        //画像ファイルパスを格納
        $image_file_path = Product::getImageFilePath($request);
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

        return redirect(route('create'));
    }

    /**
     *商品詳細を表示する
     *  @param  int  $id
     *  @return view
     */
    public function showDetail($id)
    {
        $product = Product::find($id);

        //もしデータがなかったらエラーメッセージを表示する
        if (is_null($product)) {
            \Session::flush('flash_message', 'データがありません');
            return redirect(redirect('home'));
        }

        return view('products.detail', ['product' => $product]);
    }
    /**
     *商品編集画面を表示する
     *  @param  int  $id
     *  @return view
     */
    public function showEdit($id)
    {
        //メーカー名をcompaniesテーブルから取得
        $companies = Company::getLists();

        $product = Product::find($id);
        //もしデータがなかったらエラーメッセージを表示する
        if (is_null($product)) {
            \Session::flush('flash_message', 'データがありません');
            return redirect(redirect('detail'));
        }
        return view('products.edit', [
            'product' => $product,
            'companies' => $companies
        ]);
    }

    /**
     *商品を更新する
     * @param $request
     * @return view
     */
    public function exeUpdate(Request $request)
    {

        //画像ファイルパスを格納
        $image_file_path = Product::getImageFilePath($request);
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

        return redirect('/product/edit/' . $inputs['id']);
    }


    /**
     * 商品を削除する
     * @param $request
     * @return view
     */
    public function delete($id)
    {
        //商品を削除
        Product::where('id', $id)->update(['status' => 2]);
        return redirect(route('home'));
    }

    /**
     *商品検索する
     * @param $request
     * @return view
     */
    public function Search(Request $request)
    {
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

        return view('products.search', [
            'products' => $products,
            'companies' => $companies,
            'search_word' => $search_word,
            'company_id' => $company_id,
        ]);
    }
}
