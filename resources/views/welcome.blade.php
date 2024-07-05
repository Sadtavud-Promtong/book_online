@extends('layouts.app')
@section('title', 'หน้าแรกของเว็บไซต์')
@section('content')
    <h2>หนังสือล่าสุด</h2>
    <div class="card-body">
        <form method="GET" action="{{ route('searchm') }}">
            <div class="row mb-3">
                <div class="col-md-8">
                    <input type="text" name="query" class="form-control" placeholder="ค้นหาหนังสือ..." value="{{ request()->input('query') }}">
                </div>
                <div class="col-md-3">
                    <select name="category" class="form-control">
                        <option value="">เลือกประเภทหนังสือ</option>
                        <option value="1"{{ request()->input('category') == 1 ? ' selected' : '' }}>Travel</option>
                        <option value="2"{{ request()->input('category') == 2 ? ' selected' : '' }}>Cooking</option>
                        <option value="3"{{ request()->input('category') == 3 ? ' selected' : '' }}>Entertainment</option>
                        <option value="4"{{ request()->input('category') == 4 ? ' selected' : '' }}>Comics</option>
                        <option value="5"{{ request()->input('category') == 5 ? ' selected' : '' }}>Educational</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary">ค้นหา</button>
                </div>
            </div>
        </form>
    <hr>
    @foreach ($books as $item)
        <h2>{{ $item->title }}</h2>
        <p>{{ Str::limit($item->content, 30) }}</p>
        <p>ประเภทหนังสือ {{ $item->category }}</p>
        <p>ราคาเช่า {{ $item->price }}</p>
        <a href="/detail/{{$item->id}}" class="btn btn-success">อ่านเพิ่มเติม</a>
        <hr>
    @endforeach
@endsection
