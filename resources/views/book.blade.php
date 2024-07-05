@extends('layouts.app')
@section('title', 'หนังสือทั้งหมด')
@section('content')
    {{-- @if (count($books) > 0) --}}
        <h2 class=" text text-center py-2">หนังสือทั้งหมด</h2>

        <div class="card-body">
            <form method="GET" action="{{ route('search') }}">
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

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ชื่อหนังสือ</th>
                    <th>เนื้อหาหนังสือ</th>
                    <th>ประเภทหนังสือ</th>
                    <th>ราคาเช่า</th>
                    <th>สถานะ</th>
                    <th>แก้ไขหนังสือ</th>
                    <th>ลบหนังสือ</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($books as $item)
                    <tr>
                        <td>{{ $item->title }}</td>
                        <td>{{ $item->content }}</td>
                        <td>{{ $item->category }}</td>
                        <td>{{ $item->price }}</td>
                        <td>
                            @if ($item->status == true)
                                <a href="{{ route('change', $item->id) }}" class="btn btn-success">เผยแพร่</a>
                            @else
                                <a href="{{ route('change', $item->id) }}" class="btn btn-secondary">ฉบับร่าง</a>
                            @endif
                        </td>
                        <td><a href="{{ route('edit', $item->id) }}" class="btn btn-warning">แก้ไข</a></td>
                        <td><a href="{{ route('delete', $item->id) }}" class="btn btn-danger"
                                onclick="return confirm('คุณต้องการลบหนังสือ {{ $item->title }} หรือไม่ ?')">ลบ</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <a href="/create" class="btn btn-success">เขียนหนังสือ</a>
        {{ $books->links() }}
    {{-- @else
        <h2 class=" text text-center py-2">ไม่มีหนังสือในระบบ</h2>
    @endif --}}
@endsection
