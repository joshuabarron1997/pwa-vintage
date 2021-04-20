//check service worker
if ('serviceWorker' in navigator){
    console.log('Service Worker Supported');
    window.addEventListener('load', () => {
        navigator.serviceWorker
            .register('../swCachedPages.js')
            .then(reg => console.log('Service Worker: Registered'))
            .catch(err => console.log(`Service Worker: Error: ${err}`));

    })
}