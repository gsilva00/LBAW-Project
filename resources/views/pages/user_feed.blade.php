@extends('layouts.homepage')

@section('content')
    <div class="container mt-5">
        <div class="btn-group btn-group-toggle" data-toggle="buttons">
            <label class="btn btn-secondary active">
                <input type="radio" name="options" id="option1" autocomplete="off" checked> Follow Tags
            </label>
            <label class="btn btn-secondary">
                <input type="radio" name="options" id="option2" autocomplete="off"> Follow Topics
            </label>
            <label class="btn btn-secondary">
                <input type="radio" name="options" id="option3" autocomplete="off"> Follow Authors
            </label>
        </div>

        <div id="articles" class="mt-4">
            @if($articles->isNotEmpty())
                <div class="recent-news-container">
                    @foreach($articles as $article)
                        @include('partials.long_news_tile', [
                            'article' => $article,
                        ])
                    @endforeach
                </div>
            @else
                <p>No article available.</p>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
    function loadArticles(url) {
        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(data => {
            document.getElementById('articles').innerHTML = data;
        })
        .catch(error => {
            alert('Failed to load articles.');
        });
    }

    // Load default articles on page load
    loadArticles('{{ route('followingTags') }}');

    document.querySelectorAll('input[type=radio][name=options]').forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.id === 'option1') {
                loadArticles('{{ route('followingTags') }}');
            } else if (this.id === 'option2') {
                loadArticles('{{ route('followingTopics') }}');
            } else if (this.id === 'option3') {
                loadArticles('{{ route('followingAuthors') }}');
            }
        });
    });
});
    </script>
@endsection