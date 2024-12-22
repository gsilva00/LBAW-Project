@extends('layouts.app')

@section('title', 'Admin Panel')

@section('content')
    <div class="recent-news-wrapper">
        <h1 class="large-rectangle">Administrator Panel</h1>
        <h2 class="large-rectangle light-green">List of User Accounts</h2>
        <div id="users-section">
            @if(!$usersPaginated->isEmpty())
                <div id="user-list">
                    @include('partials.user_tile_list', ['users' => $usersPaginated, 'isAdminPanel' => true])
                </div>
                <button id="load-more-users"
                        class="large-rectangle small-text greener"
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
            @else
                <div class="not-available-container">
                    <p>No user accounts to list.</p>
                </div>
            @endif
        </div>
        <h2 class="large-rectangle light-green">Create New User</h2>
        <div id="user-form-section">
            @include('partials.create_user_form')
        </div>
        <br>
        <br>
        <h2 class="large-rectangle light-green">List of Topics</h2>
        <div id="topics-section">
            @if(!$topicsPaginated->isEmpty())
                <div id="topic-list">
                    @include('partials.topic_tile_list', ['topics' => $topicsPaginated])
                </div>
                <button id="load-more-topics"
                        class="large-rectangle small-text greener"
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
            @else
                <div class="not-available-container">
                    <p>No topics exist to list.</p>
                </div>
            @endif
        </div>
        <h2 class="large-rectangle light-green">Create a New Topic</h2>
        <div id="topic-form-section">
            @include('partials.create_topic_form')
        </div>
        <br>
        <br>
        <h2 class="large-rectangle light-green">List of Tags</h2>
        <div id="tags-section">
            @if(!$tagsPaginated->isEmpty())
                <div id="tag-list">
                    @include('partials.tag_tile_list', ['tags' => $tagsPaginated])
                </div>
                <button id="load-more-tags"
                        class="large-rectangle small-text greener"
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
            @else
                <div class="not-available-container">
                    <p>No tags exist to list.</p>
                </div>
            @endif
        </div>
        <h2 class="large-rectangle light-green">Create a New Tag</h2>
        <div id="tag-form-section">
            @include('partials.create_tag_form')
        </div>
        <br>
        <br>
        <h2 class="large-rectangle light-green">List of Pending Tag Proposals</h2>
        <div id="tag-proposals-section">
            @if(!$tagProposalsPaginated->isEmpty())
                <div id="tag-proposal-list">
                    @include('partials.propose_tag_tile_list', ['tagProposalsPaginated' => $tagProposalsPaginated])
                </div>
                <button id="load-more-tag-proposals"
                        class="large-rectangle small-text greener"
                        data-entity="tag-proposal"
                        data-page-num="{{ $tagProposalCurrPageNum+1 }}"
                        data-url="{{ route('moreTagProposals') }}"
                        @if(!$tagProposalHasMorePages)
                            style="display: none"
                        @else
                            style="display: block"
                        @endif
                >
                    Load More
                </button>
                <br>
                <br>
            @else
                <div class="not-available-container">
                    <p>No pending tag proposals to list.</p>
                </div>
            @endif
        </div>
        <br>
        <h2 class="large-rectangle light-green">List of Pending Unban Appeals</h2>
        <div id="unban-appeals-section">
            @if(!$unbanAppealsPaginated->isEmpty())
                <div id="unban-appeal-list">
                    @include('partials.unban_appeal_tile_list', ['unbanAppealsPaginated' => $unbanAppealsPaginated])
                </div>
                <button id="load-more-unban-appeals"
                        class="large-rectangle small-text greener"
                        data-entity="unban-appeal"
                        data-page-num="{{ $unbanAppealCurrPageNum+1 }}"
                        data-url="{{ route('moreUnbanAppeals') }}"
                        @if(!$unbanAppealHasMorePages)
                            style="display: none"
                        @else
                            style="display: block"
                        @endif
                >
                    Load More
                </button>
            @else
                <div class="not-available-container">
                    <p>No pending unban appeals to list.</p>
                </div>
            @endif
        </div>
    </div>
@endsection