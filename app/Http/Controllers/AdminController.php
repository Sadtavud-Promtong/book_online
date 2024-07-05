<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB; 
use Illuminate\Http\Request;
use App\Models\Book;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function index(){
        $books=Book::join('type','type.id','=','books.category')
        ->select('books.*', 'type.type as category')

            ->paginate(5);
        
        return view('/book',compact('books'));
    }

    function create(){
        return view('form');
    }

    function delete($id){
        DB::table('books')->where('id',$id)->delete();
        return redirect('/book');
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
            'price'=>'required|numeric',
        ],
        [
            'title.required'=>'กรุณาป้อนชื่อหนังสือ',
            'title.max'=>'ชื่อหนังสือไม่ควรเกิน50ตัวอักษร',
            'content.required'=>'กรุณาป้อนเนื้อหาหนังสือของคุณ',
            'category.required'=>'กรุณาป้อนประเภทหนังสือของคุณ',
            'price.required'=>'กรุณาป้อนราคาหนังสือของคุณ',
            'price.numeric' => 'ราคาหนังสือต้องเป็นตัวเลข',
        ]
    );
    $data=[
        'title'=>$request->title,
        'content'=>$request->content,
        'category'=>$request->category,
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
        'price'=>'required|numeric',
    ],
    [
        'title.required'=>'กรุณาป้อนชื่อหนังสือ',
        'title.max'=>'ชื่อหนังสือไม่ควรเกิน50ตัวอักษร',
        'content.required'=>'กรุณาป้อนเนื้อหาหนังสือของคุณ',
        'category.required'=>'กรุณาป้อนประเภทหนังสือของคุณ',
        'price.required'=>'กรุณาป้อนราคาหนังสือของคุณ',
        'price.numeric' => 'ราคาหนังสือต้องเป็นตัวเลข',
    ]
);
$data=[
    'title'=>$request->title,
    'content'=>$request->content,
    'category'=>$request->category,
    'price'=>$request->price,
];
DB::table('books')->where('id',$id)->update($data);
return redirect('/book');
}

// public function search(Request $request)
//     {
//         $query = $request->input('query');
//         $books = Book::join('type','type.id','=','books.category')
//         ->select('books.*', 'type.type as category')
//                           ->where('title', 'like', "%{$query}%")
//                           ->orWhere('content', 'like', "%{$query}%")
//                           ->orWhere('category', 'like', "%{$query}%")
//                           ->orWhere('price', 'like', "%{$query}%")
//                           ->paginate(5);

//         return view('book', compact('books'));
//     }

public function search(Request $request)
{
    $query = $request->input('query');
    $category = $request->input('category');

    $books = Book::join('type', 'type.id', '=', 'books.category')
                 ->where(function($q) use ($query, $category) {
                     if ($query) {
                         $q->where('title', 'like', "%{$query}%")
                           ->orWhere('content', 'like', "%{$query}%")
                           ->orWhere('type.type', 'like', "%{$query}%")
                           ->orWhere('price', 'like', "%{$query}%");
                     }
                     if ($category) {
                         $q->where('books.category', $category);
                     }
                 })
                 ->select('books.*', 'type.type as category')
                 ->paginate(5);

    return view('book', compact('books'));
}


    public function borrow()
    {
        return view('borrow');
    }
}
