// Event listener for window.onload
window.onload = function () {
    loadCustomIframe();
};

function loadCustomIframe() {
    var iframeContainer = document.getElementById('iframeContainer');

    // Create iframe element
    var iframe = document.createElement('iframe');
    iframe.width = '1500';
    iframe.height = '500';
    iframe.src = 'https://www.youtube.com/embed/N4opxiuN92c?autoplay=1&controls=0&mute=1&loop=1&playlist=N4opxiuN92c';
    iframe.title = 'YouTube video player';
    iframe.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share';
    iframe.allowFullscreen = true;
    iframe.frameBorder = '0';
    iframe.referrerPolicy = 'strict-origin-when-cross-origin';
    iframe.loading = 'lazy';

    // Append iframe to the container
    iframeContainer.appendChild(iframe);
}

