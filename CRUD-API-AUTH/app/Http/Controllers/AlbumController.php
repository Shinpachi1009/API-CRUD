<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAlbumRequest;
use App\Http\Requests\UpdateAlbumRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;

class AlbumController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum', except:['index', 'show'])
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Album::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request -> validate([
            'title'=>['required', 'max:25'],
        ]);

        $album = $request->user()->albums()->create($input);
        return [$album, 'message'=>'Album Have been created'];
    }

    /**
     * Display the specified resource.
     */
    public function show(Album $album)
    {
        return $album;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Album $album)
    {
        Gate::authorize('modifyAlbum', $album);
        $input = $request -> validate([
            'title'=>['required', 'max:25'],
        ]);

        $album->update($input);
        return [$album, 'message'=>'Title have been updated'];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Album $album)
    {
        Gate::authorize('modifyAlbum', $album);
        $album->delete();
        return [$album, 'message'=>'Album have been deleted'];
    }
}
