//This is the service worker with the Cache-first network

var CACHE = 'pre-cache';
var precacheFiles = [
      /* Add an array of files to precache for your app */
      'index.php',
      './css/principal.css',
      './css/font-awesome.min.css',
      'serviceWorker.js',
      'serviceWorker-register.js'
    ];

//Install stage sets up the cache-array to configure pre-cache content
self.addEventListener('install', function(evt) {
    evt.waitUntil(precache().then(function() {
        return self.skipWaiting();
    })
    );
});


//allow sw to control of current page
self.addEventListener('activate', function(event) {
      return self.clients.claim();
});

self.addEventListener('fetch', function(evt) {
  evt.respondWith(fromCache(evt.request).catch(fromServer(evt.request)));
  evt.waitUntil(update(evt.request));
});


function precache() {
  return caches.open(CACHE).then(function (cache) {
    return cache.addAll(precacheFiles);
  });
}


function fromCache(request) {
  //we pull files from the cache first thing so we can show them fast
  return caches.open(CACHE).then(function (cache) {
    return cache.match(request).then(function (matching) {
      return matching || Promise.reject('no-match');
    });
  });
}


function update(request, updated) {
  //this is where we call the server to get the newest version of the 
  //file to use the next time we show view
  if(updated === true){
  return caches.open(CACHE).then(function (cache) {
    return fetch(request).then(function (response) {
      return cache.put(request, response);
    });
  });
  } 
}

function fromServer(request){
  //this is the fallback if it is not in the cahche to go to the server and get it
return fetch(request).then(function(response){ return response})
}



/* ======== OFFILINE COPY PAGES ==========
//Install stage sets up the index page (home page) in the cahche and opens a new cache
self.addEventListener('install', function(event) {
  var indexPage = new Request('index.php');
  event.waitUntil(
    fetch(indexPage).then(function(response) {
      return caches.open('cached-offline').then(function(cache) {
        console.log('[PWA Builder] Cached index page during Install'+ response.url);
        return cache.put(indexPage, response);
      });
  }));
});

//If any fetch fails, it will look for the request in the cache and serve it from there first
self.addEventListener('fetch', function(event) {
  var updateCache = function(request){
    return caches.open('pwabuilder-offline').then(function (cache) {
      return fetch(request).then(function (response) {
        console.log('[PWA Builder] add page to offline'+response.url)
        return cache.put(request, response);
      });
    });
  };

  event.waitUntil(updateCache(event.request));

  event.respondWith(
    fetch(event.request).catch(function(error) {
      console.log( '[PWA Builder] Network request Failed. Serving content from cache: ' + error );

      //Check to see if you have it in the cache
      //Return response
      //If not in the cache, then return error page
      return caches.open('pwabuilder-offline').then(function (cache) {
        return cache.match(event.request).then(function (matching) {
          var report =  !matching || matching.status == 404?Promise.reject('no-match'): matching;
          return report
        });
      });
    })
  );
});
*/
/*
 
//"Offline page" service worker cache custom
var cacheName     = "Cache-Default";
var filesToCache = [
  '/',
  'pwa.php',
  './css/inline.css'
 
]; 

self.addEventListener('install', function(e) {
  console.log('[ServiceWorker] Install');
  e.waitUntil(
    caches.open(cacheName).then(function(cache) {
      console.log('[ServiceWorker] Caching app shell');
      return cache.addAll(filesToCache);
    })
  );
});  

 ======== / OFFILINE COPY PAGES ========== */


//Cache debug//
/*
    var CACHE_NAME = 'cache-login.php';
    var cacheFiles = [
    './',
    './css/basico2.css',
    './images/cabecalho.png',
    'login.php'

    ];
         
    self.addEventListener('install', function(event) {
      event.waitUntil(
       caches
       .open(CACHE_NAME)
       .then(function (cache){
           return cache.addAll(cacheFiles);
       })
       .then(function (){
        return self.skipWaiting();
        })
        );
    });
 
 */
/*
 ===========sw.js backup===========


//Instalando SW e fazendo cache dos arquivos
self.addEventListener('install', function(event){
    console.log('Service Worker Instalado.');
    event.waitUntil(
   
        caches.open('static-cache')
        .then(function(cache){
            cache.addAll([
                './',
                'index.php',
                'app/app.js',
                'css/principal.css',
                'images/abr.png'
            ]);
        })
    );
});

//Ativa o SW para Browser
self.addEventListener('activate', function(){
    console.log('Service Worker Ativado');
});

//Busca os arquivos no index para funcionamento offline
self.addEventListener('fetch', function(event){
    event.respondWith(
       //Recebendo a resposta direto do cache, sem rede.     
        caches.match(event.request)
        .then(function(response){
            if(response) {
              return response;
        //Se não houver cache, requisita a rede.
            } else {
              return fetch(event.request); 
            }
        })
    ); 
});

 */
