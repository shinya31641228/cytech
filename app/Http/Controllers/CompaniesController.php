<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Companies;

class CompaniesController extends Controller
{
        // public function showCompanies(){
        //     //メーカー名をcompaniesテーブルから取得
        //     $companies = Companies::orderBy('id', 'asc')->pluck('company_name', 'id');
        //     $companies = $companies->prepend('未選択', '');

        //     return view('products.list', ['companies' => $companies]);
        // }
}
