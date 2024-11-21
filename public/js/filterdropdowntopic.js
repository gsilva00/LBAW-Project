document.addEventListener('DOMContentLoaded', function() {
    const topics = window.topics;
    const topicInput = document.getElementById('topic-input');
    const topicSuggestions = document.getElementById('topic-suggestions');
    const selectedtopics = document.getElementById('selected-topics');

    topicInput.addEventListener('input', function() {
        const query = topicInput.value.toLowerCase();
        topicSuggestions.innerHTML = '';

        if (query.length > 0) {
            const filteredtopics = topics.filter(topic => topic.name.toLowerCase().includes(query));
            filteredtopics.forEach(topic => {
                const suggestion = document.createElement('div');
                suggestion.classList.add('suggestion');
                const topicSpan = document.createElement('span');
                topicSpan.classList.add('small-text');
                topicSpan.innerText = topic.name;
                suggestion.appendChild(topicSpan);


                suggestion.addEventListener('click', function() {
                    event.preventDefault();
                    event.stopPropagation();
                    addtopic(topic);
                    topicInput.value = '';
                    topicSuggestions.innerHTML = '';
                });
                topicSuggestions.appendChild(suggestion);
            });
        }
    });

    function addtopic(topic) {

        const existingtopics = Array.from(selectedtopics.getElementsByClassName('topic-block'));
        if (existingtopics.some(topicBlock => topicBlock.querySelector('span').innerText.trim() === topic.name)) {
            return;
        }


        const topicBlock = document.createElement('div');
        topicBlock.classList.add('topic-block');
        tagBlock.classList.add('block');
        const topicSpan = document.createElement('span');
        topicSpan.classList.add('small-text');
        topicSpan.innerText = topic.name;
        topicBlock.appendChild(topicSpan);

        const removeButton = document.createElement('button');
        removeButton.classList.add('remove-topic');
        removeButton.innerHTML = '&times;';
        removeButton.addEventListener('click', function() {
            event.stopPropagation();
            selectedtopics.removeChild(topicBlock);
        });

        topicBlock.appendChild(removeButton);
        selectedtopics.appendChild(topicBlock);

        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'topics[]';
        hiddenInput.value = topic.id;
        topicBlock.appendChild(hiddenInput);
    }
});