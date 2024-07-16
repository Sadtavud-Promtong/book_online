@extends('layouts.app')
@section('title', 'หนังสือทั้งหมด')
@section('content')
    {{-- @if (count($books) > 0) --}}
    <h2 class=" text text-center py-2">หนังสือทั้งหมด</h2>

    <div class="card-body">
        {{-- <form method="GET" action="{{ route('search') }}"> --}}
        <div class="row mb-3">
            <div class="col-md-8">
                <input type="text" name="searchInput" id="searchInput" class="form-control" placeholder="ค้นหาหนังสือ...">
            </div>
            <div class="col-md-3">
                <select name="categoryFilter" id="categoryFilter" class="form-control">
                    <option value="">เลือกประเภทหนังสือ</option>
                    <option value="1"{{ request()->input('category') == 1 ? ' selected' : '' }}>Travel</option>
                    <option value="2"{{ request()->input('category') == 2 ? ' selected' : '' }}>Cooking</option>
                    <option value="3"{{ request()->input('category') == 3 ? ' selected' : '' }}>Entertainment
                    </option>
                    <option value="4"{{ request()->input('category') == 4 ? ' selected' : '' }}>Comics</option>
                    <option value="5"{{ request()->input('category') == 5 ? ' selected' : '' }}>Educational
                    </option>
                </select>
            </div>
        </div>
        {{-- </form> --}}

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ชื่อหนังสือ</th>
                    <th>เนื้อหาหนังสือ</th>
                    <th>ประเภทหนังสือ</th>
                    <th>จำนวนที่เหลือ</th>
                    <th>ราคาเช่า</th>
                    <th>สถานะ</th>
                    <th>แก้ไขหนังสือ</th>
                    <th>ลบหนังสือ</th>
                </tr>
            </thead>
            <tbody id='books_table'>
                {{-- @foreach ($books as $item)
                    <tr>
                        <td>{{ $item->title }}</td>
                        <td>{{ $item->content }}</td>
                        <td>{{ $item->category }}</td>
                        <td>{{ $item->stock }}</td>
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
                @endforeach --}}
            </tbody>
        </table>
        <a href="/create" class="btn btn-success">เขียนหนังสือ</a>
        {{-- {{ $books->links() }} --}}
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            $(document).ready(function() {
                search();
                $('#searchInput').on('keyup', function() {
                    search();
                });

                $('#categoryFilter').on('change', function() {
                    search();
                });
            });

            function search() {
                var searchInput = $('#searchInput').val();
                var categorysInput = $('#categoryFilter').val();

                $.ajax({
                    url: '{{ route('search') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        search: searchInput,
                        category: categorysInput
                    },
                    success: function(response) {
                        var books = response.book;
                        var html = '';
                        if (books.length === 0) {
                            html += '<tr><td colspan="6" class="text-center">ไม่พบข้อมูล</td></tr>';
                        } else {
                            books.forEach(function(book) {
                                html += '<tr>';
                                html += '<td>' + book.title + '</td>';
                                html += '<td>' + book.content + '</td>';
                                html += '<td>' + book.category + '</td>';
                                html += '<td>' + book.stock + '</td>';
                                html += '<td>' + book.price + '</td>';
                                html += '<td>';
                                if (book.status == true) {
                                    html +=
                                        '<a href="{{ route('change', ':id') }}" class="btn btn-success">เผยแพร่</a>'
                                        .replace(':id', book.id);
                                } else {
                                    html +=
                                        '<a href="{{ route('change', ':id') }}" class="btn btn-secondary">ฉบับร่าง</a>'
                                        .replace(':id', book.id);
                                }
                                html += '</td>';
                                html +=
                                    '<td><a href="{{ route('edit', ':id') }}" class="btn btn-warning">แก้ไข</a>'
                                    .replace(':id', book.id);
                                html += '</td>';

                                html += '<td>';
                                html += '<button class="btn btn-sm btn-danger" onclick="deletebook(' + book
                                    .id + ')">ลบ</button>';
                                html += '</td>';
                                html += '</tr>';
                            });
                        }

                        $('#books_table').html(html);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }

            function deletebook(bookid) {
                Swal.fire({
                    title: "คุณต้องการลบหนังสือหรือไม่?"
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('deletebook') }}',
                        type: 'GET',
                        data: {
                            bookid: bookid,
                        },
                        success: function(response) {
                            search();
                            Swal.fire("หนังสือถูกลบแล้ว");
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        }
                    });
                }
            });
            }
        </script>
    @endsection
