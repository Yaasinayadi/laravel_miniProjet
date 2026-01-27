<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\Category;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    // Page d'accueil visiteur
    public function index()
    {
        return view('visitor.index');
    }

    // Liste des ressources en lecture seule
    public function resources(Request $request)
    {
        $query = Resource::where('state', 'active');
        $categories = Category::all();

        // Filtres
        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $resources = $query->orderBy('created_at', 'desc')->get();

        return view('visitor.resources', compact('resources', 'categories'));
    }

    // Détail d'une ressource
    public function showResource($id)
    {
        $resource = Resource::findOrFail($id);
        return view('visitor.resource-detail', compact('resource'));
    }
}
