// Clicking on the X icon on the user feedback closes it
function closeMessage() {
    const messageButton = document.getElementById("close-message-button");
    if (messageButton) {
      const message = messageButton.parentElement;
      message.style.display = "none";
    }
}

function showReportUserPopup(userId) {
    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    var url = `/report-user-modal/${userId}`;

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    })
        .then(response => response.text())
        .then(html => {
            var popupContainer = document.createElement('div');
            popupContainer.innerHTML = html;
            document.body.appendChild(popupContainer);
            openPopup();
            submitReportUser();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to load report user popup. See console for details.');
        });
}

function submitReportUser() {
    var reportReason = document.getElementById('reportReason');
    var reportCategory = document.getElementById('reportCategory');
    var submitButton = document.getElementById('submitReportButton');
    var maxLength = 300;

    reportReason.addEventListener('input', function () {
        var charCount = reportReason.value.length;
        if (charCount > maxLength) {
            reportReason.value = reportReason.value.substring(0, maxLength);
        }
        document.getElementById('charCountFeedback').textContent = `${charCount}/${maxLength} characters`;
    });

    submitButton.addEventListener('click', function () {
        var charCount = reportReason.value.length;
        if (charCount > maxLength) {
            alert('Reason for reporting cannot exceed 300 characters.');
            return;
        }

        var description = reportReason.value;
        var type = reportCategory.value;
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var url = submitButton.getAttribute('data-action-url');

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                description: description,
                type: type
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closePopup();
                } else {
                    alert('Failed to submit report. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to submit report. See console for details.');
            });
    });
}

document.querySelector('.profile-wrapper').addEventListener('click', function() {
    var userId = this.getAttribute('data-user-id');
    showReportUserPopup(userId);
});


function openPopup() {
    var popup = document.getElementById('reportArticlePopup');
    if (popup) {
        popup.style.display = 'flex';
    } else {
        console.error('Popup element not found');
    }
}

function closePopup() {
    var popup = document.getElementById('reportArticlePopup');
    if (popup) {
        popup.style.display = 'none';
        popup.remove();
    } else {
        console.error('Popup element not found');
    }
}
