@extends('layouts.app')

@section('content')
<div class="container">
    <h1>รายการการยืมหนังสือที่รอการยืนยันหรือปฏิเสธ</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @foreach ($borrows as $borrow)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">ชื่อผู้ยืม: {{ $borrow->first_name }} {{ $borrow->last_name }}</h5>
                <p class="card-text">เบอร์โทรศัพท์: {{ $borrow->phone_number }}</p>
                <p class="card-text">ที่อยู่: {{ $borrow->address }}</p>
                <p class="card-text">วันที่ยืม: {{ $borrow->borrow_date }}</p>
                <p class="card-text">หมายเหตุ: {{ $borrow->note }}</p>
                <p class="card-text">ชื่อหนังสือที่ยืม: {{ $borrow->book->title }}</p>
                <form action="{{ route('approve', $borrow->id) }}" method="post" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success">ยืนยันการยืม</button>
                </form>
                <form action="{{ route('reject', $borrow->id) }}" method="post" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger">ปฏิเสธการยืม</button>
                </form>
            </div>
        </div>
    @endforeach
</div>
@endsection
