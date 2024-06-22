<?php

namespace App\Http\Controllers;

use App\Http\Repositories\SuggestionRepository;
use App\Http\Requests\StoreSuggestionRequest;
use Illuminate\Http\Request;

class SuggestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, SuggestionRepository $repository)
    {
        return $repository->getSuggestions(
            page: $request->get('page')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(StoreSuggestionRequest $request, SuggestionRepository $repository)
    {
        return $repository->createSuggestion($request->validated());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function vote(Request $request, SuggestionRepository $repository, int $suggestionId)
    {
        $vote = $repository->vote($suggestionId);
        if($vote) {
            return response()->json(['message' => 'Voto computado com sucesso!']);
        } else {
            return response()->json(['message' => 'Você já votou nesta sugestão!'], 422);
        }
    }


}
