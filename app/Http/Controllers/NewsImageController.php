<?php

namespace App\Http\Controllers;

use App\Models\NewsImage;
use Illuminate\Http\Request;

class NewsImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = NewsImage::all();
        return response()->json([
            'success' => true,
            'message' => 'Success',
            'news_image' => $news
        ],201);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $news = new NewsImage();
        $path = public_path('/uploads/news_image');
        $uploadPath = 'uploads/news_image/';

        if ($request->hasFile('news_image')) {
            $image = $request->file('news_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move($path, $imageName);

            $news->news_image = url($uploadPath . $imageName);
        }

        $news->news_text = $request->news_text;
        $news->status = 'active';
        $news->save();

        return response()->json([
            'success' => true,
            'message' => 'Record Store Successfully',
            'news'    => $news
        ], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
