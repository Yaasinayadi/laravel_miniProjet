<?php

namespace App\Http\Controllers;

use App\Models\RegistrationRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegistrationRequestController extends Controller
{
    // Formulaire de demande d'inscription
    public function create()
    {
        return view('visitor.request-account');
    }

    // Soumission de la demande
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:registration_requests,email|unique:users,email',
            'service' => 'required|string|max:255',
            'requested_role' => 'required|in:user,responsable',
            'justification' => 'required|string|min:50|max:1000',
        ], [
            'email.unique' => 'Cet email existe déjà ou a déjà une demande en cours.',
            'justification.min' => 'La justification doit contenir au moins 50 caractères.',
        ]);

        RegistrationRequest::create($validated);

        return redirect()->route('visitor.index')->with('success', 'Votre demande a été envoyée avec succès. Vous recevrez une réponse par email.');
    }

    // Liste des demandes (Admin)
    public function index()
    {
        $requests = RegistrationRequest::with('processedBy')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.registration-requests', compact('requests'));
    }

    // Approuver une demande
    public function approve(Request $request, $id)
    {
        $registrationRequest = RegistrationRequest::findOrFail($id);

        $validated = $request->validate([
            'assigned_role' => 'required|in:user,responsable,admin',
            'admin_comment' => 'nullable|string|max:500',
        ]);

        // Créer l'utilisateur
        $user = User::create([
            'name' => $registrationRequest->name,
            'email' => $registrationRequest->email,
            'service' => $registrationRequest->service,
            'role' => $validated['assigned_role'],
            'password' => Hash::make('password123'), // Mot de passe temporaire
            'is_active' => true,
        ]);

        // Mettre à jour la demande
        $registrationRequest->update([
            'status' => 'approved',
            'admin_comment' => $validated['admin_comment'],
            'processed_by' => Auth::id(),
            'processed_at' => now(),
        ]);

        return redirect()->back()->with('success', "Demande approuvée. L'utilisateur {$user->name} a été créé avec le rôle {$user->role}.");
    }

    // Rejeter une demande
    public function reject(Request $request, $id)
    {
        $registrationRequest = RegistrationRequest::findOrFail($id);

        $validated = $request->validate([
            'admin_comment' => 'required|string|max:500',
        ]);

        $registrationRequest->update([
            'status' => 'rejected',
            'admin_comment' => $validated['admin_comment'],
            'processed_by' => Auth::id(),
            'processed_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Demande rejetée.');
    }
}
