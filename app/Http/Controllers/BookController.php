<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB; 
use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    function index(){
        $books=Book::orderByDesc('id')->where('status',true)->get();
        return view('welcome',compact('books'));
    }

    // public function searchm(Request $request)
    // {
    //     $query = $request->input('querym');
    //     $books = DB::table('books')
    //     ->join('type','type.id','=','books.category')
    //     ->select('books.*', 'type.type as category')
    //     ->where($field, 'like', "%{$query}%")
    //                       ->where('title', 'like', "%{$query}%")
    //                       ->orWhere('content', 'like', "%{$query}%")
    //                       ->orWhere('category', 'like', "%{$query}%")
    //                       ->orWhere('price', 'like', "%{$query}%")
    //                       ->paginate(5);

    //     return view('welcome', compact('books'));
    // }

    function detail($id){
        $book=Book::find($id);
        return view('detail',compact('book'));
    }

    public function searchm(Request $request)
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

    return view('welcome', compact('books'));
}
}
