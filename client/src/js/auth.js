var auth = {
  verif: function() {
    if(!window.localStorage.getItem('user')) {
      app.router.navigate('/login');
    } else {
      app.router.navigate('/home');
    }
  },
  processLogin: function(){
    app.dialog.progress('Carregando...');
      
      app.request.post(api+'/login', $d('#formLogin').serialize(), (data) => {
        var data = JSON.parse(data);
        app.dialog.close();
        if(data.success){
          app.form.storeFormData('user', data.data);
          home.lista();
        }
      }, (err) => {
          app.dialog.close();
          app.dialog.alert('Ocorreu um erro ao acessar o servidor, verifique sua conexão ou seu usuário e senha. Se o erro persistir entre em contato com o suporte!');
          console.log(err);
      });
  },
  processCadastro: function(){
    app.request.post(api+'/user', $d('#formCadastro').serialize(), (data) => {
      var data = JSON.parse(data);
      if(data.success){
        app.form.storeFormData('user', data.data);
        home.lista();
      }
    });
  },
  logout: function(){
    app.form.storeFormData('user', '');
    app.dialog.progress('Carregando...');
    setTimeout(function(){
      app.dialog.close();
      app.router.navigate('/login/');
    }, 1000);
  }
}


// $d('#formLogin').submit(function( event ) {
//   event.preventDefault();
//   auth.processLogin(this);
// });