<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreImageRequest;
use App\Http\Requests\UpdateImageRequest;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;

class ImageController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum', except: ['index', 'show'])
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Album $album)
    {
        return $album->comments;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Album $album)
    {
        $input = $request -> validate([
            'image_url'=>['required', 'max:255']
        ]);

        $comment = $request->user()->images()->create([
            'image_url'=>$input['image_url'], 'album_id'=>$album->id
        ]);
        return [$comment, 'message'=>'Image been save to ' .  $album->title];
    }

    /**
     * Display the specified resource.
     */
    public function show(Image $image)
    {
        return $image;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Image $image)
    {
        Gate::authorize('modifyImages', $image);
        $input=$request->validate([
            'image_url'=>['required', 'max:255'],
        ]);
        $image->update($input);
        return [$image, 'message'=>'Image updated'];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Album $album, Image $image)
    {
        Gate::authorize('modifyImage', $image);
        $image->delete();
        return [$image, 'message'=>'Image from ' . $album->title . ' has been deleted'];
    }
}
