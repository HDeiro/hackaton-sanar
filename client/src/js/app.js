moment.locale('pt-BR');
const api = '';

// Dom7
const $$ = Dom7;

// Init App
var app = new Framework7({
  name: 'JANBOOK',
  id: 'br.com.janbook',
  root: '#app',
  theme: 'auto',
  routes: routes
});


document.addEventListener("deviceready", function(){
  document.addEventListener('backbutton', f.onBackKeyDown, false);
}, false);


$$('#logoIntro').animationEnd(function(){  
  setTimeout(function(){
    auth.verif();
  }, 1000);
});







