document.querySelector('#password-form').addEventListener('submit', function (event) {
    event.preventDefault();

    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const feedbackId = urlParams.get('feedback-id');

    window.location.replace('/feedback/' + feedbackId);
});