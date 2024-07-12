@extends('layouts.app')
@section('title')
    {{$book->title}}
    @endsection
@section('content')
    <h2>หนังสือล่าสุด</h2>
    <hr>
        <h2>{{ $book->title }}</h2>
        <p>{{ $book->content }}</p>
        <p>ประเภทหนังสือ {{ $book->category }}</p>
        <p>ราคาเช่า {{ $book->price }}</p>
        <hr>
        <a href="/borrow/{{$item->id}}" class="btn btn-success">ยืมหนังสือ</a>
@endsection
