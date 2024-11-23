document.addEventListener('DOMContentLoaded', function() {
    const topics = window.topics;
    const topicInput = document.getElementById('topic-input');
    const topicSuggestions = document.getElementById('topic-suggestions');
    const selectedTopics = document.getElementById('selected-topics');

    topicInput.addEventListener('input', function() {
        const query = topicInput.value.toLowerCase();
        topicSuggestions.innerHTML = '';

        if (query.length > 0) {
            const filteredTopics = topics.filter(topic => topic.name.toLowerCase().includes(query));
            filteredTopics.forEach(topic => {
                const suggestion = document.createElement('div');
                suggestion.classList.add('suggestion');
                const topicSpan = document.createElement('span');
                topicSpan.classList.add('small-text');
                topicSpan.innerText = topic.name;
                suggestion.appendChild(topicSpan);

                suggestion.addEventListener('click', function(event) {
                    event.preventDefault();
                    event.stopPropagation();
                    addTopic(topic);
                    topicInput.value = '';
                    topicSuggestions.innerHTML = '';
                });

                topicSuggestions.appendChild(suggestion);
                if (topicSuggestions.children.length > 0) {
                    topicSuggestions.classList.add('show');
                }
            });
        }
    });

    function addTopic(topic) {
        const existingTopics = Array.from(selectedTopics.getElementsByClassName('topic-block'));
        if (existingTopics.some(topicBlock => topicBlock.querySelector('span').innerText.trim() === topic.name)) {
            return;
        }

        const topicBlock = document.createElement('div');
        topicBlock.classList.add('topic-block');
        topicBlock.classList.add('block');
        const topicSpan = document.createElement('span');
        topicSpan.classList.add('small-text');
        topicSpan.innerText = topic.name;
        topicBlock.appendChild(topicSpan);

        const removeButton = document.createElement('button');
        removeButton.classList.add('remove');
        removeButton.innerHTML = '&times;';
        removeButton.addEventListener('click', function(event) {
            event.stopPropagation();
            selectedTopics.removeChild(topicBlock);
            updateHiddenInputs();
        });

        topicBlock.appendChild(removeButton);
        selectedTopics.appendChild(topicBlock);

        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'topics[]';
        hiddenInput.value = topic.name;
        topicBlock.appendChild(hiddenInput);

        updateHiddenInputs();
    }

    function updateHiddenInputs() {
        const hiddenInputs = selectedTopics.querySelectorAll('input[type="hidden"]');
        hiddenInputs.forEach(input => input.remove());

        const topicBlocks = selectedTopics.getElementsByClassName('topic-block');
        Array.from(topicBlocks).forEach(topicBlock => {
            const topicName = topicBlock.querySelector('span').innerText.trim();
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'topics[]';
            hiddenInput.value = topicName;
            selectedTopics.appendChild(hiddenInput);
        });
    }
});