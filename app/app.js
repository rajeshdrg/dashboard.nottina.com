
//Add this below content to your HTML page, or add the js file to your page at the very top to register sercie worker
if (navigator.serviceWorker.controller) {
  console.log('Service Worker foi registrado');
} else {
  //Register the ServiceWorker
  navigator.serviceWorker.register('/sw.js', {
    scope: './'
  }).then(function(reg) {
    console.log('Service worker has been registered for scope:'+ reg.scope);
  });
}