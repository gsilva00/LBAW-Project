@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Notifications</h1>
                <ul>
                    @foreach($notifications as $notification)
                        @include('partials.notification_card', ['comment' => $notification])
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

@endsection