<form id="createTopicForm" class="large-rectangle yellow" method="POST" action="{{ route('adminCreateTopic') }}">
    <br>
    @csrf
    <div class="profile-info">
        <label for="topic_name"><span>Topic Name</span></label>
        <input
            type="text"
            name="name"
            id="topic_name"
            placeholder="Enter topic name"
            required
            maxlength="30"
        >
    </div>
    <br>
    <div class="profile-info">
        <button type="submit" class="large-rectangle small-text greener">Create Topic</button>
    </div>
    <br>
</form>