@extends('home')
@section('content')
<div class="container">
    @if (session('flash_message'))
    <div class="flash_message text-danger">
        {{ session('flash_message') }}
    </div>
    @endif
    <div class="justify-content-center">
        <form method="POST" action="{{ route('store')}}" onsubmit="return checkSubmit()" class="p-4 card" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="user_id" value="{{ $user->id }}">
            <div class="col-md-4 mb-3">
                <label for="products_name" class="form-label">商品名</label>
                <input id="products_name" name="products_name" type="text" class="form-control" id="productName">
                @if ($errors->has('products_name'))
                <div class="text-danger">
                    {{ $errors->first('products_name')}}
                </div>
                @endif
            </div>
            <div class="col-md-4 mb-3">
                <p>メーカー</p>
                {{ Form::select('company_id', $companies, null, ['class' => 'form-select']) }}
                @if ($errors->has('company_id'))
                <div class="text-danger">
                    {{ $errors->first('company_id')}}
                </div>
                @endif
            </div>
            <div class="col-md-4 mb-3">
                <label for="price" class="form-label">価格:円</label>
                <input id="price" name="price" type="number" class="form-control">
                @if ($errors->has('price'))
                <div class="text-danger">
                    {{ $errors->first('price')}}
                </div>
                @endif
            </div>
            <div class="col-md-4 mb-3">
                <label for="stock" class="form-label">在庫数</label>
                <input id="stock" name="stock" type="number" class="form-control">
                @if ($errors->has('stock'))
                <div class="text-danger">
                    {{ $errors->first('stock')}}
                </div>
                @endif
            </div>
            <div class="col-mb-4 mb-3" style="width: 33%;">
                <label for="comment" class="form-label">コメント</label>
                <textarea id="comment" name="comment" class="form-control" id="exampleFormControlTextarea1" rows="5"></textarea>
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
                <button type="submit" class="btn btn-primary">登録</button>
                <a href="{{ route('home') }}" class="btn btn-success">戻る</a>
            </div>
        </form>
    </div>
</div>
<script>
    function checkSubmit() {
        if (window.confirm('登録してよろしいですか?')) {
            return true;
        } else {
            return false;
        }
    }
</script>
@endsection
