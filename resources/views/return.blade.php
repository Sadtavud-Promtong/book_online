@extends('layouts.app')

@section('content')
<div class="container">
    <h1>คำขอคืนหนังสือ</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @foreach ($return as $request)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">ชื่อหนังสือ: {{ $request->book->title }}</h5>
                <p class="card-text">ชื่อผู้ยืม: {{ $request->first_name }} {{ $request->last_name }}</p>
                <p class="card-text">เบอร์โทรศัพท์: {{ $request->phone_number }}</p>
                <p class="card-text">ที่อยู่: {{ $request->address }}</p>
                <p class="card-text">วันที่ยืม: {{ $request->borrow_date }}</p>
                <p class="card-text">วันที่คืน: {{ $request->return_date }}</p>
                <p class="card-text">หมายเหตุ: {{ $request->note }}</p>
                <form action="{{ route('approveReturn', $request->id) }}" method="post" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success">ยืนยันการคืนหนังสือ</button>
                </form>
            </div>
        </div>
    @endforeach
</div>
@endsection
