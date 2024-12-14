@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Notifications</h1>
                <ul class="nav nav-tabs" id="notificationTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="new-tab" data-bs-toggle="tab" data-bs-target="#new" type="button" role="tab" aria-controls="new" aria-selected="true">New</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="archived-tab" data-bs-toggle="tab" data-bs-target="#archived" type="button" role="tab" aria-controls="archived" aria-selected="false">Archived</button>
                    </li>
                </ul>
                <div class="tab-content" id="notificationTabsContent">
                    @include('partials.notification_list', ['notifications' => $notifications])
                </div>
            </div>
        </div>
    </div>
@endsection

