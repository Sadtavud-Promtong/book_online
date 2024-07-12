@extends('layouts.app')
@section('title', 'หน้าแรกของเว็บไซต์')
@section('content')
    <h2>หนังสือล่าสุด</h2>
    <div class="card-body">
        {{-- <form id="search-form"> --}}
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
        <hr>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ชื่อหนังสือ</th>
                    <th>เนื้อหา</th>
                    <th>ประเภทหนังสือ</th>
                    <th>จำนวนที่มี</th>
                    <th>ราคาเช่า</th>
                    <th>การดำเนินการ</th>
                </tr>
            </thead>
            <tbody id="books-table">
                {{-- @include('books_table', ['books' => $books]) --}}
            </tbody>
        </table>
    </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            searchm();
            $('#searchInput').on('keyup', function() {
                searchm();
            });

            $('#categoryFilter').on('change', function() {
                searchm();
            });
        });

        function searchm() {
            var searchInput = $('#searchInput').val();
            var categorysInput = $('#categoryFilter').val();

            $.ajax({
                url: '{{ route('searchm') }}',
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
                            if (book.status == true && book.stock > 0) { // ตรวจสอบค่า status
                                html += '<tr>';
                                html += '<td>' + book.title + '</td>';
                                html += '<td>' + book.content + '</td>';
                                html += '<td>' + book.category + '</td>';
                                html += '<td>' + book.stock + '</td>';
                                html += '<td>' + book.price + '</td>';
                                html += '<td>';
                                html += '<a href="/borrow/' + book.id +
                                    '" class="btn btn-success">ยืมหนังสือ</a>';
                                html += '</td>';
                                html += '</tr>';
                            }
                        });
                    }

                    $('#books-table').html(html);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
    </script>
@endsection
