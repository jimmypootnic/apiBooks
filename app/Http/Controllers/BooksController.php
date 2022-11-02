<?php

namespace App\Http\Controllers;

use App\Models\Books;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class BooksController extends Controller
{

    public function index()
    {
        return Books::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required']
        ]);

        $oBook = new Books();
        $oBook->title = $request->input('title');
        $oBook->save();

        return $oBook;
    }

    public function show($bookId)
    {
        return Books::findOrfail($bookId);
    }

    public function update(Request $request, $BookId)
    {
        $request->validate([
            'title' => ['required']
        ]);

        $oBook = Books::findOrfail($BookId);
        $oBook->title = $request->input('title');
        $oBook->save();

        return $oBook;
    }

    public function destroy(Request $request, $BookId)
    {
        $oBook = Books::findOrfail($BookId);
        $oBook->delete();

        return \response()->json([], Response::HTTP_NO_CONTENT);
    }
}
