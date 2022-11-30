<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorRequest;
use App\Models\Authors;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * @param  Model $author
     * @return void
     */
    public function __construct(Authors $author)
    {
        $this->model = $author;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = $this->model->with('books')->get();
        
        return response(['data' => $items], 200);
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
    public function store(AuthorRequest $request)
    {
        $Createrequest = $request->validated();

        $this->model->create($Createrequest);

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
            $item = $this->model->with('books')->findOrFail($id);

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
            $item = $this->model->with('books')->findOrFail($id);
            $item->update($request->all());

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
            $item = $this->model->with('books')->findOrFail($id);
            $item->books()->detach();
            $item->delete();

            return $this->index();

        } catch (ModelNotFoundException $e) {

            return response(['message' => 'Item Not Found!', 'status' => 404]);
        }
    }
}
