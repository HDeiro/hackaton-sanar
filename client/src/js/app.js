moment.locale('pt-BR');
const api = 'http://loreweb.com.br/janbook/api';

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
    // app.router.navigate('/login/');
      authInfo.open();
  }, 2000);
});


var authInfo = app.dialog.create({
  title: 'Olá Gamer, eu sou o Léo',
  text: `
    <p>
      Vejo que você não tem registro do COMBATE J neste dispositivo.
    </p>
    <p>
      Você tem duas opções.
    </p>
    <div class="row" style="padding-top: 20px;">
      <button onclick="game.modalAuth(2);" class="col button button-fill">Cadastre-se</button>
      <button onclick="game.modalAuth(3);" class="col button button-fill">Fazer Login</button>
    </div>
  `
});




