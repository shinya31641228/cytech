@extends('home')
@section('content')
<div class="container">
    @if (session('flash_message'))
    <div class="flash_message text-danger">
        {{ session('flash_message') }}
    </div>
    @endif
    <div class="row justify-content-center">
        <form method="POST" action="{{ route('update')}}" onsubmit="return checkSubmit()" class="card p-4" enctype="multipart/form-data">
            @csrf
            <div class="col-md-4 mb-3">
                <input type="hidden" name="id" value="{{ $product->id }}">
                <p>商品ID:{{ $product->id }}</p>
                <label for="products_name" class="form-label">商品名</label>
                <input id="products_name" name="products_name" type="text" class="form-control" id="productName" value="{{ $product->products_name }}">
                @if ($errors->has('products_name'))
                <div class="text-danger">
                    {{ $errors->first('products_name')}}
                </div>
                @endif
            </div>
            <div class="col-md-4 mb-3">
                <p>メーカー</p>
                {{ Form::select('company_id', $companies, null, ['class' => 'form-select']) }}
            </div>
            <div class="col-md-4 mb-3">
                <label for="price" class="form-label">価格</label>
                <input id="price" name="price" type="number" class="form-control" value="{{ $product->price }}">
                @if ($errors->has('price'))
                <div class="text-danger">
                    {{ $errors->first('price')}}
                </div>
                @endif
            </div>
            <div class="col-md-4 mb-3">
                <label for="stock" class="form-label">在庫数</label>
                <input id="stock" name="stock" type="number" class="form-control" value="{{ $product->stock }}">
                @if ($errors->has('stock'))
                <div class="text-danger">
                    {{ $errors->first('stock')}}
                </div>
                @endif
            </div>
            <div class="col-mb-4 mb-3" style="width: 33%;">
                <label for="comment" class="form-label">コメント</label>
                <textarea id="comment" name="comment" class="form-control" id="exampleFormControlTextarea1" rows=" 5">{{ $product->comment }}</textarea>
                @if ($errors->has('comment'))
                <div class="text-danger">
                    {{ $errors->first('comment')}}
                </div>
                @endif
            </div>
            <div class="mb-3" style="width: 33%;">
                <label for="image" class="form-label">画像登録</label>
                <input id="image" name="image" class="form-control" type="file">
                @if ($errors->has('image'))
                <div class="text-danger">
                    {{ $errors->first('image')}}
                </div>
                @endif
            </div>
            <div class="col-mb-4">
                <button type="submit" class="btn btn-primary">更新</button>
                <a href="/product/detail/{{ $product->id }}" class="btn btn-success">戻る</a>
            </div>
        </form>
    </div>
</div>
<script>
    function checkSubmit() {
        if (window.confirm('更新してよろしいですか?')) {
            return true;
        } else {
            return false;
        }
    }
</script>
@endsection
