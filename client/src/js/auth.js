var auth = {
  verif() {
    if(!window.localStorage.getItem('user')) {
      app.router.navigate('/login');
    } else {
      app.router.navigate('/home');
    }
  }
}