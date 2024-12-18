@extends('layouts.app')

@section('title', 'Admin Panel')

@section('content')
    <div class="recent-news-wrapper">
        <h1 class="large-rectangle">Administrator Panel</h1>
        <h2 class="large-rectangle">List of User Accounts</h2>
        <div id="users-section">
            <div id="user-list">
                @include('partials.user_tile_list', ['users' => $usersPaginated])
            </div>
            <button id="load-more-users"
                    class="large-rectangle small-text greyer"
                    data-entity="user"
                    data-page-num="{{ $userCurrPageNum+1 }}"
                    data-url="{{ route('moreUsers') }}"
                    @if(!$userHasMorePages)
                        style="display: none"
                    @else
                        style="display: block"
                    @endif
            >
                Load More
            </button>
        </div>
        <h2 class="large-rectangle">Create New User</h2>
        @include('partials.create_user_form')
        <br>
        <br>
        <h2 class="large-rectangle">List of Topics</h2>
        <div id="topics-section">
            <div id="topic-list">
                @include('partials.topic_tile_list', ['topics' => $topicsPaginated])
            </div>

            <button id="load-more-topics"
                    class="large-rectangle small-text greyer"
                    data-entity="topic"
                    data-page-num="{{ $topicCurrPageNum+1 }}"
                    data-url="{{ route('moreTopics') }}"
                    @if(!$topicHasMorePages)
                        style="display: none"
                    @else
                        style="display: block"
                    @endif
            >
                Load More
            </button>
        </div>
        <h2 class="large-rectangle">Create a New Topic</h2>
        <div id="topic-form-section">
            @include('partials.create_topic_form')
        </div>
        <br>
        <br>
        <h2 class="large-rectangle">List of Tags</h2>
        <div id="tags-section">
            <div id="tag-list">
                @include('partials.tag_tile_list', ['tags' => $tagsPaginated])
            </div>
            <button id="load-more-tags"
                    class="large-rectangle small-text greyer"
                    data-entity="tag"
                    data-page-num="{{ $tagCurrPageNum+1 }}"
                    data-url="{{ route('moreTags') }}"
                    @if(!$tagHasMorePages)
                        style="display: none"
                    @else
                        style="display: block"
                    @endif
            >
                Load More
            </button>
        </div>
        <h2 class="large-rectangle">Create a New Tag</h2>
        <div id="tag-form-section">
            @include('partials.create_tag_form')
        </div>
        <br>
        <h2 class="large-rectangle">List of Pending Tag Proposals</h2>
        <div id="another-section">

        </div>
        <br>
        <h2 class="large-rectangle">List of Pending Unban Appeals</h2>
        <div id="another-section">

        </div>
        <br>
        <h2 class="large-rectangle">List of Pending Fact Checker Requests</h2>
        <div id="another-section">
            <!-- TODO maybe -->
        </div>
    </div>
@endsection