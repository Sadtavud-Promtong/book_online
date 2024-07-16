@extends('layouts.app')
@section('title', 'เพิ่มหนังสือ')
@section('content')
    <h2 class="text text-center py-2">แบบฟอร์มเพิ่มหนังสือ</h2>
    <form method="POST" action="/insert">
        @csrf

        <div class="form-group">
            <label for="title">ชื่อหนังสือ</label>
            <input type="text" name="title" class="form-control">
        </div>
        @error('title')
            <div class="my-2">
                <span class="text text-danger">{{$message}}</span>
            </div>
        @enderror

        <div class="form-group">
            <label for="content">เนื้อหาหนังสือ</label>
            <textarea name="content" cols="30" rows="5" class="form-control"></textarea>
        </div>
        @error('content')
            <div class="my-2">
                <span class="text text-danger">{{$message}}</span>
            </div>
        @enderror

        <div class="form-group">
            <label for="category">ประเภทหนังสือหนังสือ</label>
            {{-- <input type="text" name="category" class="form-control"> --}}
            <select name="category" class="form-control">
                <option value="">เลือกประเภทหนังสือ</option>
                <option value="1">Travel</option>
                <option value="2">Cooking</option>
                <option value="3">Entertainment</option>
                <option value="4">Comics</option>
                <option value="5">Educational</option>
            </select>
        </div>
        @error('category')
            <div class="my-2">
                <span class="text text-danger">{{$message}}</span>
            </div>
        @enderror

        <div class="form-group">
            <label for="stock">จำนวนหนังสือ</label>
            <input type="number" name="stock" class="form-control">
        </div>
        @error('price')
            <div class="my-2">
                <span class="text text-danger">{{$message}}</span>
            </div>
        @enderror

        <div class="form-group">
            <label for="price">ราคาเช่าหนังสือหนังสือ</label>
            <input type="number" name="price" class="form-control">
        </div>
        @error('price')
            <div class="my-2">
                <span class="text text-danger">{{$message}}</span>
            </div>
        @enderror

        <input type="submit" value="บันทึก" class="btn btn-primary my-3">
        <a href="book" class="btn btn-success">หนังสือทั้งหมด</a>
    </form>
@endsection
 