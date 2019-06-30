var home = {
    lista: function(){
        app.dialog.progress('Carregando...');
        app.request.get(api+'/mission/list?patient_id='+app.form.getFormData('user').id, (data) => {
            var data = JSON.parse(data);
            if(data.success){
                app.router.navigate('/home/', {
                    context: {
                        data: {
                            dados: data,
                            user: app.form.getFormData('user')
                        }
                    }
                });
            }else{
                alertErroRequest();
            }
        });
    }
}