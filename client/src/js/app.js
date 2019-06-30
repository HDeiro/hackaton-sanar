moment.locale('pt-BR');
const api = 'https://api.sanar.hugodeiro.com/api/v1';

var dataCategory;
var demoGauge;

// Dom7
const $$ = Dom7;

// Init App
var app = new Framework7({
  name: 'Health Track',
  id: 'br.com.healthtrack',
  root: '#app',
  theme: 'auto',
  routes: routes
});

$d = (selector) => {
	return $(`div[data-name="`+$(app.view.main.router.currentPageEl).attr('data-name')+`"] `+selector);
}

document.addEventListener("deviceready", function(){
  document.addEventListener('backbutton', f.onBackKeyDown, false);
}, false);

$$('#logoIntro').animationEnd(function(){  
  setTimeout(function(){
    if(app.form.getFormData('user') == undefined || app.form.getFormData('user') == ''){
      app.router.navigate('/login/');
    }else{
      home.lista();
    }
    
  }, 500);
});

function alertErroRequest(){
  app.dialog.close();
  app.dialog.alert('Ocorreu um erro ao acessar o servidor, verifique sua conexão ou seu usuário e senha. Se o erro persistir entre em contato com o suporte!');
}



