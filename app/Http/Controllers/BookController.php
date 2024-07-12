<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB; 
use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    function index(){
        $books = Book::join('type', 'type.id', '=', 'books.category')
                     ->select('books.*', 'type.type as category')
                     ->where('books.status', true)
                     ->where('books.stock', '!=', 0)
                     ->orderByDesc('books.id')
                     ->get();
    
        return view('welcome', compact('books'));
    }

    function detail($id){
        $book=Book::find($id);
        return view('detail',compact('book'));
    }

//     public function searchm(Request $request)
// {
//     $query = $request->input('query');
//     $category = $request->input('category');

//     $books = Book::join('type', 'type.id', '=', 'books.category')
//                  ->where(function($q) use ($query, $category) {
//                      if ($query) {
//                          $q->where('title', 'like', "%{$query}%")
//                            ->orWhere('content', 'like', "%{$query}%")
//                            ->orWhere('type.type', 'like', "%{$query}%")
//                            ->orWhere('price', 'like', "%{$query}%");
//                      }
//                      if ($category) {
//                          $q->where('books.category', $category);
//                      }
//                  })
//                  ->select('books.*', 'type.type as category')
//                  ->paginate(10);

//     return view('welcome', compact('books'));
// }

public function searchm(Request $request)
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

    return response()->json($books);
}




}
