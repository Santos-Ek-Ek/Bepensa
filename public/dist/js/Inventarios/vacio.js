var urlVacios = "http://localhost/Bepensa/public/apiVacio";
var urlCategorias = "http://localhost/Bepensa/public/apiCategoria";
var urlProductos = "http://localhost/Bepensa/public/apiProductoVacio";

new Vue({

    http: {
        headers: {
            "X-CSRF-TOKEN": document
                .querySelector("#token")
                .getAttribute("value"),
        },
    },

    el: "#vacio",

    data:{
        vacios:[],
        id:'',
        paletas:'',
        saldos_c_tarimas:'',
        saldos_s_tarimas:'',
        total:'',
        agregando:true,

        productos:[],
        id_producto:'',
    },

        created: function(){
        this.obtenerVacios();
        this.obtenerProductos();
    },

    methods:{
        obtenerVacios:function(){
            this.$http.get(urlVacios).then(function(respuesta){
                this.vacios = respuesta.data;
                console.log(respuesta.data);

                $(function () {
                    $("#vacioTable").DataTable({
                      "responsive": true, "lengthChange": false, "autoWidth": false,
                      "buttons": [{
                        extend: "copy",
                        exportOptions: {
                            columns: ":not(.no-export)" // Excluir columnas con la clase "no-export"
                        }
                    },
                    {
                        extend: "csv",
                        exportOptions: {
                            columns: ":not(.no-export)"
                        }
                    },
                    {
                        extend: "excel",
                        exportOptions: {
                            columns: ":not(.no-export)"
                        }
                    },
                    {
                        extend: "pdf",
                        exportOptions: {
                            columns: ":not(.no-export)"
                        }
                    },
                    {
                        extend: "print",
                        exportOptions: {
                            columns: ":not(.no-export)"
                        }
                    }],
                      'paging'      : true,
                      'lengthChange': true,
                      'searching'   : true,
                      'ordering'    : true,
                      'info'        : true,
                    }).buttons().container().appendTo('#vacioTable_wrapper .col-md-6:eq(0)');
                });

            }).catch(function(error){
                console.log(error);
            })
        },
        obtenerProductos:function(){
            this.$http.get(urlProductos).then(function(respuesta){
                this.productos = respuesta.data;
                console.log(respuesta.data);
            }).catch(function(error){
                console.log(error);
            })
        },

        mostrarModal:function(){
            this.agregando=true;
            this.paletas="";
            this.saldos_c_tarimas="";
            this.saldos_s_tarimas="";
            this.total="";
            this.id_producto="";

            $('#ModalVacio').modal('show');
        },

        agregarVacios:function(){
            var vacio={
                paletas:this.paletas,
                saldos_c_tarimas:this.saldos_c_tarimas,
                saldos_s_tarimas:this.saldos_s_tarimas,
                total:this.total,
                id_producto:this.id_producto
              };

              console.log(vacio)

            //se envian los datos en json al controlador
            this.$http.post(urlVacios,vacio).then(function(j){
                $("#vacioTable").DataTable().destroy();
                this.obtenerVacios();
                this.paletas='';
                this.saldos_c_tarimas='';
                this.saldos_s_tarimas='';
                this.total='';
                this.id_producto='';


            }).catch(function(j){
                console.log(j);
            })

            $('#ModalVacio').modal('hide');


        },

        eliminarVacios:function(id){
            var confir= confirm('¿Estás seguro de que deseas eliminarlo?')

            if (confir)
            {
                this.$http.delete(urlVacios + '/' + id).then(function(json){
                    $("#vacioTable").DataTable().destroy();
                    this.obtenerVacios();
                }).catch(function(json){

                });

            }
        },

        // editarVacios:function(id){
        //     this.agregando=false;
        //     this.id=id;

        //     this.$http.get(urlVacios + '/' + id).then(function(json){
        //         // console.log(json.data);
        //         this.paletas=json.data.paletas;
        //         this.saldos_c_tarimas=json.data.saldos_c_tarimas;
        //         this.saldos_s_tarimas=json.data.saldos_s_tarimas;
        //         this.total=json.data.total;
        //         this.id_producto=json.data.id_producto;
        //     })

        //     $('#ModalVacio').modal('show');
        // },

        // actualizarVacios:function(){
        //     var jsonVacio={
        //                         paletas:this.paletas,
        //                         saldos_c_tarimas:this.saldos_c_tarimas,
        //                         saldos_s_tarimas:this.saldos_s_tarimas,
        //                         total:this.total,
        //                         id_producto:this.id_producto,
        //                     };
        //                     // console.log(jsonProducto);
        //     this.$http.patch(urlVacios + '/' + this.id, jsonVacio).then(function(json){
        //         $("#vacioTable").DataTable().destroy();
        //         this.obtenerVacios();
        //         $('#ModalVacio').modal('hide');
        //     });

        // },

        editarVacios:function(id){
            this.agregando=false;
            this.id=id;

            this.$http.get(urlVacios + '/' + id).then(function(json){
                // console.log(json.data);
                this.paletas=json.data.paletas;
                this.saldos_c_tarimas=json.data.saldos_c_tarimas;
                this.saldos_s_tarimas=json.data.saldos_s_tarimas;
                this.total=json.data.total;
                this.id_producto=json.data.id_producto;
            })

            $('#ModalVacio').modal('show');
        },

        actualizarVacios:function(){
            var jsonVacio={
                                paletas:this.paletas,
                                saldos_c_tarimas:this.saldos_c_tarimas,
                                saldos_s_tarimas:this.saldos_s_tarimas,
                                total:this.total,
                                id_producto:this.id_producto,
                            };
                            // console.log(jsonProducto);
            this.$http.patch(urlVacios + '/' + this.id, jsonVacio).then(function(json){
                $("#vacioTable").DataTable().destroy();
                this.obtenerVacios();
                $('#ModalVacio').modal('hide');
            });

        },


    }
});
