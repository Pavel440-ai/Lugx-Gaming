// File: js/preloader.js
window.addEventListener('load', function() {
    // При желании можно добавить задержку
    setTimeout(function() {
        document.getElementById('js-preloader').classList.add('loaded');
    }, 200);
});