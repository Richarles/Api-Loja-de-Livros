<?php

namespace App\Http\Controllers;

use App\Http\Requests\PublisherRequest;
use App\Models\Publishers;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * __construct
     *
     * @param  Publisher $publisher
     * @return void
     */
    public function __construct(Publishers $publisher)
    {
        $this->model = $publisher;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = $this->model->with('books')->get();

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
    public function store(PublisherRequest $request)
    {
        $request = $request->validated();

        $this->model->create($request);

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
    public function update(PublisherRequest $request, $id)
    {
        try {
            $request = $request->validated();

            $item = $this->model->with('books')->findOrFail($id);
            //dd($item);
            $item->update($request);

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
            $item->delete();

            return $this->index();

        } catch (ModelNotFoundException $e) {

            return response(['message' => 'Item Not Found!', 'status' => 404]);
        }
    }
}
