@extends('layouts.app')
@section('title', 'ยืมหนังสือ')
@section('content')
<div class="container">
    <h2 class="text-center py-2">ยืมหนังสือ: {{ $book->title }}</h2>
    <form method="POST" action="{{ route('storeBorrow') }}">
        @csrf
        <input type="hidden" name="book_id" value="{{ $book->id }}">

        <div class="form-group">
            <label for="first_name">ชื่อ</label>
            <input type="text" name="first_name" class="form-control" required>
        </div>
        @error('first_name')
            <div class="my-2">
                <span class="text-danger">{{ $message }}</span>
            </div>
        @enderror

        <div class="form-group">
            <label for="last_name">นามสกุล</label>
            <input type="text" name="last_name" class="form-control" required>
        </div>
        @error('last_name')
            <div class="my-2">
                <span class="text-danger">{{ $message }}</span>
            </div>
        @enderror

        <div class="form-group">
            <label for="phone_number">เบอร์โทรศัพท์</label>
            <input type="text" name="phone_number" class="form-control" required>
        </div>
        @error('phone_number')
            <div class="my-2">
                <span class="text-danger">{{ $message }}</span>
            </div>
        @enderror

        <div class="form-group">
            <label for="address">ที่อยู่</label>
            <textarea name="address" class="form-control" required></textarea>
        </div>
        @error('address')
            <div class="my-2">
                <span class="text-danger">{{ $message }}</span>
            </div>
        @enderror

        <div class="form-group">
            <label for="borrow_date">วันที่ยืมหนังสือ</label>
            <input type="date" name="borrow_date" class="form-control" required>
        </div>
        @error('borrow_date')
            <div class="my-2">
                <span class="text-danger">{{ $message }}</span>
            </div>
        @enderror

        <div class="form-group">
            <label for="return_date">วันที่คืนหนังสือ</label>
            <input type="date" name="return_date" class="form-control">
        </div>
        @error('return_date')
            <div class="my-2">
                <span class="text-danger">{{ $message }}</span>
            </div>
        @enderror

        <div class="form-group">
            <label for="note">หมายเหตุ</label>
            <textarea name="note" class="form-control"></textarea>
        </div>
        @error('note')
            <div class="my-2">
                <span class="text-danger">{{ $message }}</span>
            </div>
        @enderror

        <button type="submit" class="btn btn-primary my-3">ยืมหนังสือ</button>
    </form>
</div>
@endsection
