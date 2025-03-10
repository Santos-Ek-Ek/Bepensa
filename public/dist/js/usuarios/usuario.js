var route = document.querySelector("[name=url_route]").getAttribute("value");
var urlUsuarios = route + "/apiUsuario";

new Vue({

    http: {
        headers: {
            "X-CSRF-TOKEN": document
                .querySelector("#token")
                .getAttribute("value"),
        },
    },

    el: "#usuario",

    data:{
        usuarios:[],
        id:'',
        nombre:'',
        apellidos:'',
        usuario:'',
        password:'',
        agregando:true,
    },

    created: function(){
        this.obtenerUsuarios();
    },

    methods:{
        obtenerUsuarios:function(){
            this.$http.get(urlUsuarios).then(function(respuesta){
                this.usuarios = respuesta.data;
                console.log(respuesta.data);
            }).catch(function(error){
                console.log(error);
            })
        },

        mostrarModal:function(){
            this.agregando=true;
            this.nombre="";
            this.apellidos="";
            this.usuario="";
            this.password="";

            $('#ModalUsuario').modal('show');
        },

        // agregarUsuarios:function(){
        //     var usuario={nombre:this.nombre,apellidos:this.apellidos,usuario:this.usuario, password:this.password};

        //     //se envian los datos en json al controlador
        //     this.$http.post(urlUsuarios,usuario).then(function(j){
        //         this.obtenerUsuarios();
        //         this.nombre='';
        //         this.apellidos='';
        //         this.usuario='';
        //         this.password='';

        //     }).catch(function(j){
        //         console.log(j);
        //     })

        //     $('#ModalUsuario').modal('hide');


        // },

        agregarUsuarios:function(){
            var usuario={nombre:this.nombre,apellidos:this.apellidos,usuario:this.usuario,password:this.password};

            //se envian los datos en json al controlador
            this.$http.post(urlUsuarios,usuario).then(function(j){
                this.obtenerUsuarios();
                this.nombre='';
                this.apellidos='';
                this.usuario='';
                this.password='';

            }).catch(function(j){
                console.log(j);
            })

            $('#ModalUsuario').modal('hide');


        },

        // eliminarUsuarios:function(id){
        //     var confir= confirm('¿Estás seguro de que deseas eliminarlo?')

        //     if (confir)
        //     {
        //         this.$http.delete(urlUsuarios + '/' + id).then(function(json){
        //             $("#usuarioTable").DataTable().destroy();
        //             this.obtenerUsuarios();
        //         }).catch(function(json){

        //         });

        //     }
        // },

        eliminarUsuarios:function(id){
            var confir= confirm('¿Estás seguro de que deseas eliminarlo?')

            if (confir)
            {
                this.$http.delete(urlUsuarios + '/' + id).then(function(json){
                    this.obtenerUsuarios();
                }).catch(function(json){

                });

            }
        },

    }
});
