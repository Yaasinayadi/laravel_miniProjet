@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h2><i class="ri-notification-3-line"></i> Vos Notifications</h2>
                @if(auth()->user()->unreadNotifications->count() > 0)
                    <form action="{{ route('notifications.readAll') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Tout marquer comme lu</button>
                    </form>
                @endif
            </div>

            <div class="card-body">
                @if($notifications->isEmpty())
                    <p>Aucune notification pour le moment.</p>
                @else
                    <ul  style="list-style: none; padding: 0;">
                        @foreach($notifications as $notification)
                            <li style="background: {{ $notification->read_at ? '#2d333b' : '#374151' }}; padding: 15px; margin-bottom: 10px; border-radius: 8px; border-left: 5px solid {{ $notification->read_at ? '#adb5bd' : '#3b82f6' }}; display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <p style="margin: 0; font-weight: {{ $notification->read_at ? 'normal' : 'bold' }};">
                                        {{ $notification->data['message'] ?? 'Nouvelle notification' }}
                                    </p>
                                    <small style="color: #9ca3af;">{{ $notification->created_at->diffForHumans() }}</small>
                                </div>
                                <div style="display: flex; gap: 10px; align-items: center;">
                                    @if(isset($notification->data['link']))
                                        @if($notification->read_at)
                                            <a href="{{ $notification->data['link'] }}" class="btn btn-sm btn-info" style="color: #60a5fa; text-decoration: none;">Voir</a>
                                        @else
                                            <a href="#" onclick="event.preventDefault(); document.getElementById('mark-read-{{ $notification->id }}').submit();" class="btn btn-sm btn-info" style="color: #60a5fa; text-decoration: none;">Voir</a>
                                        @endif
                                    @endif
                                    
                                    @if(!$notification->read_at)
                                        <form id="mark-read-{{ $notification->id }}" action="{{ route('notifications.read', $notification->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-secondary" style="margin-top: 5px;font-size: 20px;background: none; border: none; color: #9ca3af; cursor: pointer;" title="Marquer comme lu"><i class="ri-checkbox-circle-line"></i></button>
                                        </form>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>

                    <div style="margin-top: 20px;">
                        {{ $notifications->links('vendor.pagination.custom') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
