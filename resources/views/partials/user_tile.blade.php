@if(!$user->is_deleted)
    <div class="profile-container-admin">
        <img src="{{ asset('images/profile/' . $user->profile_picture) }}" alt="profile_picture" class="user-profile-picture-admin">

        <div class="profile-info">
            <h2>
                <a href="{{ route('profile', ['username' => $user->username]) }}">
                    {{ $user->display_name }}
                </a>
            </h2>
            @if(!$isAdminPanel)
                <div>
                    @csrf
                    @if (Auth::user()->isFollowing($user))
                        <button type="button"
                                class="unfollow-user-button-profile large-rectangle small-text greener"
                                data-user-id="{{ Auth::id() }}"
                                data-profile-id="{{ $user->id }}"
                                data-url="{{route('unfollowUserAction')}}"
                        >
                            Unfollow User
                        </button>
                    @endif
                </div>
            @endif
            @if(Auth::user()->is_admin)
                <a href="{{ route('editProfile', ['username' => $user->username]) }}">
                    <button class="large-rectangle small-text greener">Edit Profile</button>
                </a>
                <form action="{{ $user->is_banned ? route('adminUnbanUser', ['id' => $user->id]) : route('adminBanUser', ['id' => $user->id]) }}" method="POST" data-action="{{ $user->is_banned ? 'unban' : 'ban' }}" style="display:inline;">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <button type="submit" class="large-rectangle small-text greener">{{ $user->is_banned ? 'Unban User' : 'Ban User' }}</button>
                </form>
                <form action="{{ route('deleteProfile', ['id' => $user->id]) }}" method="POST" data-action="delete" style="display:inline;">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <button type="submit" class="large-rectangle small-text greener">Delete This Account</button>
                </form>
            @endif
        </div>
    </div>
@endif