<?php

namespace App\Http\Controllers;

use App\Joke;
use Response;
use Illuminate\Http\Request;

class JokesController extends Controller
{
    public function index()
    {
        $jokes = Joke::all();

        return Response::json([
            'data' => $this->transformCollection($jokes)
        ], 200);
    }

    public function show($id)
    {
        $joke = Joke::findOrFail($id);

        if(!$joke) {
            return Response::json([
                'error' => [
                        'message' => 'Joke does not exist'
                    ]
                ], 404);
        }

        return Response::json([
                'data' => $this->transform($joke)
            ], 200);
    }

    private function transformCollection($jokes)
    {
        return array_map([$this, 'transform'], $jokes->toArray());
    }

    private function transform($joke)
    {
        return [
               'joke_id' => $joke['id'],
               'joke' => $joke['body']
            ];
    }
}
