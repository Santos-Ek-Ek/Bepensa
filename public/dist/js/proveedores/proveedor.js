var urlProveedores = "http://localhost/Bepensa/public/apiProveedor";

new Vue({

    http: {
        headers: {
            "X-CSRF-TOKEN": document
                .querySelector("#token")
                .getAttribute("value"),
        },
    },

    el: "#proveedor",

    data:{
        proveedores:[],
        id:'',
        proveedor:'',
        direccion:'',
        tipo_producto:'',
        agregando:true,
    },

    created: function(){
        this.obtenerProveedores();
    },

    methods:{
        obtenerProveedores:function(){
            this.$http.get(urlProveedores).then(function(respuesta){
                this.proveedores = respuesta.data;
                console.log(respuesta.data);
            }).catch(function(error){
                console.log(error);
            })
        },

        mostrarModal:function(){
            this.agregando=true;
            this.proveedor="";
            this.direccion="";
            this.tipo_producto="";
            $('#ModalProveedor').modal('show');
        },

        agregarProveedores:function(){
            var proveedor={proveedor:this.proveedor,direccion:this.direccion,tipo_producto:this.tipo_producto};

            //se envian los datos en json al controlador
            this.$http.post(urlProveedores,proveedor).then(function(j){
                this.obtenerProveedores();
                this.proveedor='';
                this.direccion='';
                this.tipo_producto='';

            }).catch(function(j){
                console.log(j);
            })

            $('#ModalProveedor').modal('hide');


        },

        eliminarProveedores:function(id){
            var confir= confirm('¿Estás seguro de que deseas eliminarlo?')

            if (confir)
            {
                this.$http.delete(urlProveedores + '/' + id).then(function(json){
                    this.obtenerProveedores();
                }).catch(function(json){

                });

            }
        },

        editarProveedores:function(id){
            this.agregando=false;
            this.id=id;

            this.$http.get(urlProveedores + '/' + id).then(function(json){
                // console.log(json.data);
                this.proveedor=json.data.proveedor;
                this.direccion=json.data.direccion;
                this.tipo_producto=json.data.tipo_producto;
            })

            $('#ModalProveedor').modal('show');
        },
        actualizarProveedores:function(){
            var jsonProveedor={ proveedor:this.proveedor,
                                direccion:this.direccion,
                                tipo_producto:this.tipo_producto
                            };
                            // console.log(jsonProveedor);
            this.$http.patch(urlProveedores + '/' + this.id, jsonProveedor).then(function(json){
                this.obtenerProveedores();
                $('#ModalProveedor').modal('hide');
            });

        }


    },
});

// Agregar proveedores


