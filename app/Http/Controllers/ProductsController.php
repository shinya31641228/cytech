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

        return view('products.create', [
            'user' => $user,
            'companies' => $companies
        ]);
    }

    /**
     *商品を登録する
     * @param $request
     * @return view
     */
    public function exeStore(Request $request)
    {
        $product = new Product;
        $product->productRegistration($request);

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
        $inputs = $request->all();

        $update = new Product;
        $update->productUpdate($request);

        return redirect('/product/edit/' . $inputs['id']);
    }

    /**
     * 商品を削除する
     * @param $request
     * @return view
     */
    public function delete(Request $request, $id)
    {
        $product = new Product;
        $product->productDelete($request,$id);

        return redirect(route('home'));
    }

    /**
     *商品検索する
     * @param $request
     * @return view
     */
    public function searchList(Request $request)
    {
        $product = new Product;
        $searchProducts = $product->productSearch($request);

        return view('products.search', [
            'products' => $searchProducts['products'],
            'companies' => $searchProducts['companies'],
            'search_word' => $searchProducts['search_word'],
            'company_id' => $searchProducts['company_id'],
        ]);
    }
}
