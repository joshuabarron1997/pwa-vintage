const cacheName = 'v1';

const cacheAssets = [
    '/images',
    '/photos',
    '/js/main.js',
    //'contact.php',
    'coopTemplateStyle.css',
    //'email.class.php',
    'floor-plans.html',
    'gallery.html',
    'index.html',
    'ourStory.html'
    //'tour.php'
];

//installing
self.addEventListener('install', e => {
    console.log('Service Worker: Installed');

    // e.waitUntil(
    //     caches
    //         .open(cacheName)
    //         .then(cache => {
    //             console.log('Service Worker: Caching Files');
    //             cache.addAll(cacheAssets);
    //         })
    //         .then(() => self.skipWaiting())
    // );
});

//activation
self.addEventListener('activate', e => {
    console.log('Service Worker: Activated');
    //cache cleanup
    e.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames.map(cache => {
                    if (cache != cacheName){
                        console.log('Service Worker: Clearing Old Cache');
                        return caches.delete(cache);
                    }
                })
            )
        })
    );

});
//call fetch event
self.addEventListener('fetch', e => {
    console.log('Service Worker: Fetching');
    e.respondWith(
        fetch(e.request)
        .then(res => {
            //make copy of response
            const resClone = res.clone();
            //open cache
            caches
                .open(cacheName)
                .then(cache => {
                    //add response to cache
                    cache.put(e.request, resClone);
                });
        return res;
        }).catch(err => caches.match(e.request).then(ress => res))
    );
});