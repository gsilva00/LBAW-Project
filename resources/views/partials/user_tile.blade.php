<div class="profile-container-admin">
    <img src="{{ asset('images/profile/' . $user->profile_picture) }}" alt="profile_picture" class="user-profile-picture-admin">

    <div class="profile-info">
        <h2>{{ $user->display_name }}</h2>
        <form  method="POST" style="display:inline;">
            @csrf
            @if (Auth::user()->isFollowing($user))
                <button type="submit" class="large-rectangle small-text greyer">Unfollow User</button>
            @else
                <button type="submit" class="large-rectangle small-text greyer">Follow User</button>
            @endif
        </form>
        <a href="{{ route('editProfile', ['username' => $user->username]) }}">
            <button class="large-rectangle small-text greyer">Edit Profile</button>
        </a>
        <form action="{{ route('deleteProfile', ['id' => $user->id]) }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="large-rectangle small-text greyer">Delete This Account</button>
        </form>
    </div>
</div>