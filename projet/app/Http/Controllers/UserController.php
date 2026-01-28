<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    //affiche liste utilisateur pour l'admin
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    //change role(valider un utilisateur)
    //change role(valider un utilisateur ou changer son grade)
    public function promote(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Protection : Impossible de modifier le rôle du Super Admin
        if ($user->email === 'admin@gmail.com') {
            return back()->with('error', "Impossible de modifier le rôle de l'administrateur principal système.");
        }
        if ($user->email === 'respo@gmail.com') {
            return back()->with('error', "Impossible de modifier le rôle du responsable principal système.");
        }
        
        // Si la requête contient un rôle, on l'utilise, sinon 'interne' par défaut
        $targetRole = $request->input('role', 'interne');
        
        // Sécurité : On s'assure que le rôle est valide
        if(in_array($targetRole, ['interne', 'responsable', 'admin', 'invite'])) {
            $user->role = $targetRole;
            $user->save();
            return back()->with('success', "Le rôle de l'utilisateur a été mis à jour en : $targetRole !");
        }

        return back()->with('error', "Rôle invalide.");
    }

    //banne utilisateur (Desactiver)
    public function toggleBan($id)
    {
        $user = User::findOrFail($id);
        $user->is_active = !$user->is_active; //ivnverse true->false
        $user->save();

        return back()->with('success', "Statut de l'utilisateur modifié.");
    }
}
