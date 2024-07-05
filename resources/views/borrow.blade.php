@extends('layouts.app')
@section('title', 'ยืมหนังสือ')
@section('content')
    <h2 class="text text-center py-2">ยืมหนังสือ</h2>
    {{-- <form method="POST" action="{{ route('borrow.store') }}"> --}}
        @csrf
        <div class="form-group">
            <label for="book_id">เลือกหนังสือที่ต้องการยืม</label>
            <select name="book_id" class="form-control">
                {{-- @foreach($books as $book)
                    <option value="{{ $book->id }}">{{ $book->title }}</option>
                @endforeach --}}
            </select>
        </div>
        @error('book_id')
            <div class="my-2">
                <span class="text text-danger">#</span>
            </div>
        @enderror

        <div class="form-group">
            <label for="borrow_date">วันที่ยืม</label>
            <input type="date" name="borrow_date" class="form-control" value="{{ old('borrow_date') }}">
        </div>
        @error('borrow_date')
            <div class="my-2">
                <span class="text text-danger">#</span>
            </div>
        @enderror

        <div class="form-group">
            <label for="return_date">วันที่คืน</label>
            <input type="date" name="return_date" class="form-control" value="{{ old('return_date') }}">
        </div>
        @error('return_date')
            <div class="my-2">
                <span class="text text-danger">#</span>
            </div>
        @enderror

        <input type="submit" value="ยืมหนังสือ" class="btn btn-primary my-3">
    </form>
@endsection
