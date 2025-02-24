var urlProductos = "http://localhost/Bepensa/public/apiProducto";
var urlCategorias = "http://localhost/Bepensa/public/apiCategoria";



new Vue({

    http: {
        headers: {
            "X-CSRF-TOKEN": document
                .querySelector("#token")
                .getAttribute("value"),
        },
    },

    el: "#producto",

    data:{
        productos:[],
        id:'',
        codigo:'',
        nombre:'',
        descripcion:'',
        agregando:true,

        categorias:[],
        id_categoria:'',

    },

    created: function(){
        this.obtenerProductos();
        this.obtenerCategorias();
    },

    methods:{
        obtenerProductos:function(){
            this.$http.get(urlProductos).then(function(respuesta){
                this.productos = respuesta.data;
                console.log(respuesta.data);
            }).catch(function(error){
                console.log(error);
            })
        },

        obtenerCategorias:function(){
            this.$http.get(urlCategorias).then(function(respuesta){
                this.categorias = respuesta.data;

                console.log(respuesta.data);
            }).catch(function(error){
                console.log(error);
            })
        },

        mostrarModal:function(){
            this.agregando=true;
            this.codigo="";
            this.nombre="";
            this.id_categoria="";

            $('#ModalProducto').modal('show');
        },

        agregarProductos:function(){
            var producto={
                codigo:this.codigo,
                nombre:this.nombre,
                id_categoria:this.id_categoria,
              };

            //se envian los datos en json al controlador
            this.$http.post(urlProductos,producto).then(function(j){
                this.obtenerProductos();
                this.codigo='';
                this.nombre='';
                this.id_categoria='';


            }).catch(function(j){
                console.log(j);
            })

            $('#ModalProducto').modal('hide');


        },

        // editarProductos:function(id){
        //     this.agregando=false;
        //     this.id=id;

        //     this.$http.get(urlProductos + '/' + id).then(function(json){
        //         // console.log(json.data);
        //         this.codigo=json.data.codigo;
        //         this.nombre=json.data.nombre;
        //         this.categoria=json.data.categoria;
        //         this.id_categoria=json.data.id_categoria;

        //     })

        //     $('#ModalProducto').modal('show');
        // },

        editarProductos:function(id){
            this.agregando=false;
            this.id=id;

            this.$http.get(urlProductos + '/' + id).then(function(json){
                // console.log(json.data);
                this.codigo=json.data.codigo;
                this.nombre=json.data.nombre;
                this.categoria=json.data.categoria;
                this.id_categoria=json.data.id_categoria;

            })

            $('#ModalProducto').modal('show');
        },

        actualizarProductos:function(){
            var jsonProducto={ codigo:this.codigo,
                                nombre:this.nombre,
                                categoria:this.categoria,
                                tipo:this.tipo,
                                id_categoria:this.id_categoria,
                            };
                            // console.log(jsonProducto);
            this.$http.patch(urlProductos + '/' + this.id, jsonProducto).then(function(json){
                this.obtenerProductos();
                $('#ModalProducto').modal('hide');
            });

        },

        eliminarProductos:function(id){
            var confir= confirm('¿Estás seguro de que deseas eliminarlo?')

            if (confir)
            {
                this.$http.delete(urlProductos + '/' + id).then(function(json){
                    this.obtenerProductos();
                }).catch(function(json){

                });

            }
        },
    }
});
