@extends('home')

@section('content')
<div class="container">
    @if (session('flash_message'))
    <div class="flash_message text-danger">
        {{ session('flash_message') }}
    </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="d-flex justify-content-between bd-highlight mb-3">
                <a class="btn btn-outline-success" href="{{ route('create') }}" role="button">商品登録</a>
                <form method="GET" action="{{ route('search') }}">
                    @csrf
                    <div class="input-group">
                        <select name="company_id" class="form-select" value="{{ $company_id }}">
                            <option value="">未選択</option>
                            @foreach($companies as $id => $company_name)
                            <option value="{{ $id }}">
                                {{ $company_name }}
                            </option>
                            @endforeach
                        </select>
                        <input type="text" class="form-control" name="search_word" value="{{ $search_word }}">
                        <button class="btn btn-outline-secondary" type="submit" id="inputGroupFileAddon04"><i class="fas fa-search"></i></button>
                    </div>
                </form>
            </div>
            @if(!empty($products))
            <div class="row">
                @foreach($products as $product)
                <div class="col-3 mb-5">
                    <div class="card" style="width: 18rem;">
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
                            <form method="POST" action="/product/delete/{{ $product->id }}" onsubmit="return checkSubmit()">
                                @csrf
                                <a href="/product/detail/{{ $product->id }}" class="btn btn-outline-primary">詳細</a>
                                <button type="submit" class="btn btn-outline-danger">削除</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>
</script>
@endsection
