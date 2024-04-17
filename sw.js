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