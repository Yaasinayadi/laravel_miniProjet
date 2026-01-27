
@extends('layouts.app')

@section('content')
<div style="margin-top: 20px;">
    <h1><i class="ri-user-add-line"></i> Gestion des Demandes d'Inscription</h1>

    @if($requests->isEmpty())
        <div class="card" style="text-align: center; margin-top: 20px;">
            <i class="ri-inbox-line" style="font-size: 3rem; color: #999;"></i>
            <p style="color: #666;">Aucune demande d'inscription pour le moment.</p>
        </div>
    @else
        <!-- Demandes en attente -->
        @php
            $pendingRequests = $requests->where('status', 'pending');
        @endphp
        
        @if($pendingRequests->count() > 0)
            <h2 style="margin-top: 30px;"><i class="ri-time-line"></i> Demandes en attente ({{ $pendingRequests->count() }})</h2>
            
            @foreach($pendingRequests as $request)
                <div class="card" style="border-left: 4px solid #f59e0b; margin-top: 15px;">
                    <div style="display: flex; justify-content: space-between; align-items: start; flex-wrap: wrap; gap: 15px;">
                        <div style="flex: 1; min-width: 300px;">
                            <h3>{{ $request->name }}</h3>
                            <p><i class="ri-mail-line"></i> <strong>Email :</strong> {{ $request->email }}</p>
                            <p><i class="ri-building-line"></i> <strong>Service :</strong> {{ $request->service }}</p>
                            <p><i class="ri-user-star-line"></i> <strong>Rôle demandé :</strong> 
                                <span style="color: #3b82f6; font-weight: bold;">{{ ucfirst($request->requested_role) }}</span>
                            </p>
                            <p><i class="ri-calendar-line"></i> <strong>Date :</strong> {{ $request->created_at->format('d/m/Y H:i') }}</p>
                            
                            <div style="margin-top: 15px; padding: 15px; background: #f3f4f6; border-radius: 8px;">
                                <strong>Justification :</strong>
                                <p style="line-height: 1.6; margin-top: 8px;">{{ $request->justification }}</p>
                            </div>
                        </div>
                        
                        <div style="min-width: 250px;">
                            <!-- Formulaire d'approbation -->
                            <form method="POST" action="{{ route('admin.registration-requests.approve', $request->id) }}" style="margin-bottom: 10px;">
                                @csrf
                                <label for="role_{{ $request->id }}">Attribuer le rôle :</label>
                                <select name="assigned_role" id="role_{{ $request->id }}" required style="margin-bottom: 10px;">
                                    <option value="user" {{ $request->requested_role === 'user' ? 'selected' : '' }}>Utilisateur</option>
                                    <option value="responsable" {{ $request->requested_role === 'responsable' ? 'selected' : '' }}>Responsable</option>
                                    <option value="admin">Administrateur</option>
                                </select>
                                
                                <textarea name="admin_comment" placeholder="Commentaire (optionnel)" rows="2" style="margin-bottom: 10px;"></textarea>
                                
                                <button type="submit" class="btn" style="background: #10b981; width: 100%;">
                                    <i class="ri-check-line"></i> Approuver
                                </button>
                            </form>
                            
                            <!-- Formulaire de rejet -->
                            <button onclick="toggleRejectForm({{ $request->id }})" class="btn" style="background: #ef4444; width: 100%;">
                                <i class="ri-close-line"></i> Rejeter
                            </button>
                            
                            <form id="reject_form_{{ $request->id }}" method="POST" action="{{ route('admin.registration-requests.reject', $request->id) }}" style="display: none; margin-top: 10px;">
                                @csrf
                                <textarea name="admin_comment" placeholder="Raison du rejet (obligatoire)" rows="3" required style="margin-bottom: 10px;"></textarea>
                                <button type="submit" class="btn" style="background: #dc2626; width: 100%;">
                                    Confirmer le rejet
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif

        <!-- Demandes traitées -->
        @php
            $processedRequests = $requests->whereIn('status', ['approved', 'rejected']);
        @endphp
        
        @if($processedRequests->count() > 0)
            <h2 style="margin-top: 40px;"><i class="ri-history-line"></i> Historique des demandes</h2>
            
            @foreach($processedRequests as $request)
                <div class="card" style="border-left: 4px solid {{ $request->status === 'approved' ? '#10b981' : '#ef4444' }}; margin-top: 15px; opacity: 0.8;">
                    <div style="display: flex; justify-content: space-between; align-items: start; flex-wrap: wrap;">
                        <div style="flex: 1;">
                            <h3>{{ $request->name }} 
                                <span style="color: {{ $request->status === 'approved' ? 'green' : 'red' }};">
                                    {{ $request->status === 'approved' ? '✓ Approuvée' : '✗ Rejetée' }}
                                </span>
                            </h3>
                            <p><strong>Email :</strong> {{ $request->email }}</p>
                            <p><strong>Service :</strong> {{ $request->service }}</p>
                            <p><strong>Date de traitement :</strong> {{ $request->processed_at?->format('d/m/Y H:i') }}</p>
                            
                            @if($request->processedBy)
                                <p><strong>Traité par :</strong> {{ $request->processedBy->name }}</p>
                            @endif
                            
                            @if($request->admin_comment)
                                <div style="margin-top: 10px; padding: 10px; background: #f9fafb; border-radius: 5px;">
                                    <strong>Commentaire :</strong> {{ $request->admin_comment }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    @endif
</div>

<script>
function toggleRejectForm(id) {
    const form = document.getElementById('reject_form_' + id);
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}
</script>
@endsection
