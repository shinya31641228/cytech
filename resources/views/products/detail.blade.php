@extends('home')

@section('content')
<div class="container d-flex justify-content-center">
    <div class="card" style="width: 25rem;">
        <img src="{{ '/storage/'. $product->image }}" class="card-img-top" alt="...">
        <div class="card-body">
            <table class="table">
                <tbody>
                    <tr class="border-bottom">
                        <td>商品ID</td>
                        <td>{{ $product->id }}</td>
                    </tr>
                    <tr class="border-bottom">
                        <td>商品名</td>
                        <td>{{ $product->products_name }}</td>
                    </tr>
                    <tr class="border-bottom">
                        <td>メーカー</td>
                        <td>{{ $product->company_name }}</td>
                    </tr>
                    <tr class="border-bottom">
                        <td>価格</td>
                        <td>{{ $product->price }}円</td>
                    </tr>
                    <tr class="border-bottom">
                        <td>在庫</td>
                        <td>{{ $product->stock }}</td>
                    </tr>
                </tbody>
            </table>
            <p>コメント：{{ $product->comment }}</p>
            <a href="/product/edit/{{ $product->id }}" class="btn btn-outline-primary">編集</a>
            <a href="{{ route('home') }}" class="btn btn-outline-success">戻る</a>
        </div>
    </div>
</div>
@endsection
