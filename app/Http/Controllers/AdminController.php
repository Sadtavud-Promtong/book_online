<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB; 
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Borrow;

class AdminController extends Controller
    {
    public function __construct()
    {
        $this->middleware('auth');
    }

    function index(){
        $books=Book::join('type','type.id','=','books.category')
        ->select('books.*', 'type.type as category');

            // ->paginate(8);
        
        return view('/book',compact('books'));
    }

    function create(){
        return view('form');
    }

    function delete(Request $request){
        // dd($request->input('bookid'));
        DB::table('books')->where('id',$request->input('bookid'))->delete();
        return response()->json(200);
    }

    function change($id){
        $book=DB::table('books')->where('id',$id)->first();
        $data=[
            'status'=>!$book->status
        ];
        $book=DB::table('books')->where('id',$id)->update($data);
        return redirect('/book');
    }

    function edit($id){
        $book=DB::table('books')->where('id',$id)->first();
        return view('edit',compact('book'));
    }

    function insert(Request $request){
        $request->validate([
            'title'=>'required|max:50',
            'content'=>'required',
            'category'=>'required',
            'stock'=>'required|integer|min:0',
            'price'=>'required|numeric',
        ],
        [
            'title.required'=>'กรุณาป้อนชื่อหนังสือ',
            'title.max'=>'ชื่อหนังสือไม่ควรเกิน50ตัวอักษร',
            'content.required'=>'กรุณาป้อนเนื้อหาหนังสือของคุณ',
            'category.required'=>'กรุณาป้อนประเภทหนังสือของคุณ',
            'stock.required'=>'กรุณาป้อนจำนวนหนังสือในสต็อก',
            'stock.integer'=>'จำนวนหนังสือต้องเป็นตัวเลขจำนวนเต็ม',
            'stock.min'=>'จำนวนหนังสือต้องไม่น้อยกว่า 0',
            'price.required'=>'กรุณาป้อนราคาหนังสือของคุณ',
            'price.numeric' => 'ราคาหนังสือต้องเป็นตัวเลข',
        ]
    );
    $data=[
        'title'=>$request->title,
        'content'=>$request->content,
        'category'=>$request->category,
        'stock'=>$request->stock,
        'price'=>$request->price,
    ];
    Book::insert($data);
    return redirect('/book');
    }
    function update(Request $request,$id){
        $request->validate([
            'title'=>'required|max:50',
            'content'=>'required',
            'category'=>'required',
            'stock'=>'required|integer|min:0',
            'price'=>'required|numeric',
        ],
        [
            'title.required'=>'กรุณาป้อนชื่อหนังสือ',
            'title.max'=>'ชื่อหนังสือไม่ควรเกิน50ตัวอักษร',
            'content.required'=>'กรุณาป้อนเนื้อหาหนังสือของคุณ',
            'category.required'=>'กรุณาป้อนประเภทหนังสือของคุณ',
            'stock.required'=>'กรุณาป้อนจำนวนหนังสือในสต็อก',
            'stock.integer'=>'จำนวนหนังสือต้องเป็นตัวเลขจำนวนเต็ม',
            'stock.min'=>'จำนวนหนังสือต้องไม่น้อยกว่า 0',
            'price.required'=>'กรุณาป้อนราคาหนังสือของคุณ',
            'price.numeric' => 'ราคาหนังสือต้องเป็นตัวเลข',
        ]
    );
    $data=[
    'title'=>$request->title,
    'content'=>$request->content,
    'category'=>$request->category,
    'stock'=>$request->stock,
    'price'=>$request->price,
    ];
    DB::table('books')->where('id',$id)->update($data);
    return redirect('/book');
    }

    public function search(Request $request)
{
    $books['book'] = DB::table('books')
        ->leftjoin('type', 'type.id', '=', 'books.category')
        ->when($request->input('search'), function ($query, $search) {
            return $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                ->orWhere('content', 'like', '%' . $search . '%')
                ->orWhere('type.type', 'like', '%' . $search . '%')
                ->orWhere('price', 'like', '%' . $search . '%');
            });
        })
        ->when($request->input('category'), function ($query, $category) {
            return $query->where('books.category', $category);
        })
        ->select('books.*', 'type.type as category')
        ->get();
        // dd($books);

    return response()->json($books);
}


    public function borrow($id)
    {
        $book = Book::findOrFail($id);
        return view('borrow', compact('book'));
    }

    public function storeBorrow(Request $request)
    {
    $request->validate([
        'first_name' => 'required',
        'last_name' => 'required',
        'phone_number' => 'required',
        'address' => 'required',
        'borrow_date' => 'required|date',
        'return_date' => 'nullable|date',
        'note' => 'nullable',
    ],
    [
        'first_name.required'=>'กรุณาป้อนชื่อของคุณ',
        'last_name.required'=>'กรุณาป้อนนามสกุลของคุณ',
        'phone_number.required'=>'กรุณาป้อนเบอร์โทรศัพท์ของคุณ',
        'address.required'=>'กรุณาป้อนอีเมลของคุณ',
        'borrow_date.required'=>'กรุณาเลือกวันที่ยืมหนังสือ',
        'borrow_date.date'=>'กรุณาป้อนวันให้ถูกต้อง',
        'return_date.required'=>'กรุณาเลือกวันที่คืนหนังสือ',
        'return_date.date'=>'กรุณาป้อนวันให้ถูกต้อง',
    ]);

    $borrow = Borrow::create([
        'book_id' => $request->book_id,
        'user_id' => auth()->id(),
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'phone_number' => $request->phone_number,
        'address' => $request->address,
        'borrow_date' => $request->borrow_date,
        'return_date' => $request->return_date,
        'note' => $request->note,
    ]);
    $book = Book::findOrFail($request->book_id);
    $book->stock = $book->stock - 1;
    $book->save();

    return redirect('/welcome')->with('success', 'ยืมหนังสือสำเร็จ');
    }

    public function pending()
    {
        $borrows = Borrow::where('status', 'pending')->get();
        return view('pending', compact('borrows'));
    }

    public function approve($id)
    {
        $borrow = Borrow::findOrFail($id);
        $borrow->status = 'approved';
        $borrow->save();

        return redirect('/pending')->with('success', 'ยืนยันการยืมหนังสือเรียบร้อย');
    }

    public function reject($id)
    {
        $borrow = Borrow::findOrFail($id);
        $borrow->status = 'rejected';
        $borrow->save();

        $book = Book::findOrFail($borrow->book_id);
        $book->stock += 1;
        $book->save();

        return redirect('/pending')->with('success', 'ปฏิเสธการยืมหนังสือเรียบร้อย');
    }

    public function history()
    {
    $borrows = Borrow::where('user_id', auth()->id())
                     ->orderByDesc('borrow_date')
                     ->get();

    return view('history', compact('borrows'));
    }

    public function returnBook($id)
{
    $borrow = Borrow::findOrFail($id);

    if ($borrow->user_id != auth()->id()) {
        return redirect()->route('history')->with('error', 'คุณไม่มีสิทธิ์คืนหนังสือเล่มนี้');
    }

    $borrow->status = 'return';
    $borrow->save();

    return redirect()->route('history')->with('success', 'คำขอคืนหนังสือของคุณถูกส่งแล้ว');
}

public function return()
{
    $return = Borrow::where('status', 'return')->get();
    return view('return', compact('return'));
}

public function approveReturn($id)
{
    $borrow = Borrow::findOrFail($id);

    $borrow->status = 'success';
    $borrow->save();

    $book = Book::findOrFail($borrow->book_id);
    $book->stock += 1;
    $book->save();

    return redirect()->route('return')->with('success', 'ยืนยันการคืนหนังสือสำเร็จ');
}






}
