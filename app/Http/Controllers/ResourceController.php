<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Resource;
use Illuminate\Http\Request;


class ResourceController extends Controller
{
    //1.liste materiel pour l'admin
    public function index() {
        $resources = Resource::with('category')->get();
        return view('admin.resources.index', compact('resources'));
    }

    //2.formulaire de creation
    public function create() {
        $categories = Category::all();
        return view('admin.resources.create', compact('categories'));
    }


    //3. Enregistrer dans la base
    public function store(Request $request) {
        //validation simple
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required',
            'specs' => 'nullable|string'
        ]);

        Resource::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'specs' => $request->specs,
            'state' => 'active'
        ]);

        return redirect()->route('resources.index')->with('succes', 'Matériel ajouté avec succès !');
    }

    // 4. Formulaire d'édition
    public function edit($id) {
        $resource = Resource::findOrFail($id);
        $categories = Category::all();
        return view('admin.resources.edit', compact('resource', 'categories'));
    }

    // 5. Mise à jour
    public function update(Request $request, $id) {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required',
            'specs' => 'nullable|string'
        ]);

        $resource = Resource::findOrFail($id);
        
        $resource->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'specs' => $request->specs,
            // 'state' => $request->state // On garde l'état actuel ou on l'ajoute plus tard
        ]);

        return redirect()->route('resources.index')->with('succes', 'Matériel modifié avec succès !');
    }

}
