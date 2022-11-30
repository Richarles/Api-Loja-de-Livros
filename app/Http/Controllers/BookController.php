<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Books;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class BookController extends Controller
{
     /**
     * @var Model
     */
    protected $model;

    /**
     * @param  Model $book
     * @return void
     */
    public function __construct(Books $book)
    {
        $this->model = $book;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = $this->model->with('authors', 'publisher')->get();

        return response(['data' => $items, 'status' => 200]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookRequest $request)
    {
        $Createrequest = $request->validated();
        //dd($Createrequest);
        $item = $this->model->create($Createrequest);

        $authors = $request->get('authors');
       // dd($item->authors()->sync([$authors]));                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              
        $item->authors()->sync([$authors]);

        return $this->index();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $item = $this->model->with('authors', 'publisher')->findOrFail($id);

            return response(['data' => $item, 'status' => 200]);

        } catch (ModelNotFoundException $e) {

            return response(['message' => 'Item Not Found!', 'status' => 404]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $item = $this->model->with('authors', 'publisher')->findOrFail($id);
            $item->update($request->all());

            $authors = $request->get('authors');
            $item->authors()->sync($authors);

            return response(['data' => $item, 'status' => 200]);

        } catch (ModelNotFoundException $e) {

            return response(['message' => 'Item Not Found!', 'status' => 404]);
        }
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $item = $this->model->with('authors', 'publisher')->findOrFail($id);
            $item->authors()->detach();
            $item->delete();

            return $this->index();

        } catch (ModelNotFoundException $e) {

            return response(['message' => 'Item Not Found!', 'status' => 404]);
        }
    }
}
