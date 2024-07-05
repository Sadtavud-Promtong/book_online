@extends('layouts.app')
@section('title', 'แก้ไข')
@section('content')
    <h2 class="text text-center py-2">แก้ไขหนังสือ</h2>
    <form method="POST" action="{{route('update',$book->id)}}">
        {{-- <form method="POST" action="{{ route('books.update', $book->id) }}"> --}}
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="title">ชื่อหนังสือ</label>
            <input type="text" name="title" class="form-control" value="{{$book->title}}">
        </div>
        @error('title')
            <div class="my-2">
                <span class="text text-danger">{{$message}}</span>
            </div>
        @enderror

        <div class="form-group">
            <label for="content">เนื้อหาหนังสือ</label>
            <textarea name="content" cols="30" rows="5" class="form-control">{{$book->content}}</textarea>
        </div>
        @error('content')
            <div class="my-2">
                <span class="text text-danger">{{$message}}</span>
            </div>
        @enderror

        <div class="form-group">
            <label for="category">ประเภทหนังสือหนังสือ</label>
            {{-- <input type="text" name="category" class="form-control" value="{{$book->category}}"> --}}
            <select name="category" class="form-control">
                <option value="1"{{ $book->category == 'Travel' ? 'selected' : '' }}>Travel</option>
                <option value="2"{{ $book->category == 'Cooking' ? 'selected' : '' }}>Cooking</option>
                <option value="3"{{ $book->category == 'Entertainment' ? 'selected' : '' }}>Entertainment</option>
                <option value="4"{{ $book->category == 'Comics' ? 'selected' : '' }}>Comics</option>
                <option value="5"{{ $book->category == 'Educational' ? 'selected' : '' }}>Educational</option>
            </select>
        </div>
        @error('category')
            <div class="my-2">
                <span class="text text-danger">{{$message}}</span>
            </div>
        @enderror

        <div class="form-group">
            <label for="price">ราคาเช่าหนังสือหนังสือ</label>
            <input type="number" name="price" class="form-control"value="{{$book->price}}">
        </div>
        @error('price')
            <div class="my-2">
                <span class="text text-danger">{{$message}}</span>
            </div>
        @enderror

        <input type="submit" value="อัปเดต" class="btn btn-primary my-3">
        <a href="book" class="btn btn-success">หนังสือทั้งหมด</a>
    </form>
@endsection
 