@extends('layouts.app')

@section('content')
<div class="container">
    <h1>ประวัติการยืมหนังสือ</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @foreach ($borrows as $borrow)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">ชื่อหนังสือ: {{ $borrow->book->title }}</h5>
                <p class="card-text">สถานะ: {{ $borrow->status }}</p>
                <p class="card-text">วันที่ยืม: {{ $borrow->borrow_date }}</p>
                <p class="card-text">วันที่คืน: {{ $borrow->return_date }}</p>
                <p class="card-text">หมายเหตุ: {{ $borrow->note }}</p>
                @if ($borrow->status == 'approved')
                    <form action="{{ route('returnBook', $borrow->id) }}" method="post" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-primary">คืนหนังสือ</button>
                    </form>
                    @if (now()->greaterThan($borrow->return_date))
                        <div class="alert alert-warning mt-3">คุณได้เลยกำหนดเวลาส่งคืนหนังสือแล้ว</div>
                    @endif
                @endif
            </div>
        </div>
    @endforeach
</div>
@endsection
