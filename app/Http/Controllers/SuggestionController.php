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

}
