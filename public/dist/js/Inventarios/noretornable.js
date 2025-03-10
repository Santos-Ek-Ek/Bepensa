var route = document.querySelector("[name=url_route]").getAttribute("value");
var urlNoRetornables = route + "/apiNoRetornable";
var urlCategorias = route + "/apiCategoria";
var urlProductos = route + "/apiProductoNoRetornable";

new Vue({

    http: {
        headers: {
            "X-CSRF-TOKEN": document
                .querySelector("#token")
                .getAttribute("value"),
        },
    },

    el: "#noretornable",

    data:{
        noretornables:[],
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
        this.obtenerNoRetornables();
        this.obtenerProductos();
    },

    methods:{
        obtenerNoRetornables:function(){
            this.$http.get(urlNoRetornables).then(function(respuesta){
                this.noretornables = respuesta.data;
                console.log(respuesta.data);

                $(function () {
                    $("#noretornableTable").DataTable({
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
                    }).buttons().container().appendTo('#noretornableTable_wrapper .col-md-6:eq(0)');
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

            $('#ModalNoRetornable').modal('show');
        },

        agregarNoRetornables:function(){
            var noretornable={
                paletas:this.paletas,
                saldos_c_tarimas:this.saldos_c_tarimas,
                saldos_s_tarimas:this.saldos_s_tarimas,
                total:this.total,
                id_producto:this.id_producto
              };

              console.log(noretornable)

            //se envian los datos en json al controlador
            this.$http.post(urlNoRetornables,noretornable).then(function(j){
                $("#noretornableTable").DataTable().destroy();
                this.obtenerNoRetornables();
                this.paletas='';
                this.saldos_c_tarimas='';
                this.saldos_s_tarimas='';
                this.total='';
                this.id_producto='';


            }).catch(function(j){
                console.log(j);
            })

            $('#ModalNoRetornable').modal('hide');


        },

        eliminarNoRetornables:function(id){
            var confir= confirm('¿Estás seguro de que deseas eliminarlo?')

            if (confir)
            {
                this.$http.delete(urlNoRetornables + '/' + id).then(function(json){
                    $("#noretornableTable").DataTable().destroy();
                    this.obtenerNoRetornables();
                }).catch(function(json){

                });

            }
        },

        editarNoRetornables:function(id){
            this.agregando=false;
            this.id=id;

            this.$http.get(urlNoRetornables + '/' + id).then(function(json){
                // console.log(json.data);
                this.paletas=json.data.paletas;
                this.saldos_c_tarimas=json.data.saldos_c_tarimas;
                this.saldos_s_tarimas=json.data.saldos_s_tarimas;
                this.total=json.data.total;
                this.id_producto=json.data.id_producto;
            })

            $('#ModalNoRetornable').modal('show');
        },

        actualizarNoRetornables:function(){
            var jsonNoRetornable={
                                paletas:this.paletas,
                                saldos_c_tarimas:this.saldos_c_tarimas,
                                saldos_s_tarimas:this.saldos_s_tarimas,
                                total:this.total,
                                id_producto:this.id_producto,
                            };
                            // console.log(jsonProducto);
            this.$http.patch(urlNoRetornables + '/' + this.id, jsonNoRetornable).then(function(json){
                $("#noretornableTable").DataTable().destroy();
                this.obtenerNoRetornables();
                $('#ModalNoRetornable').modal('hide');
            });

        },


    }
});
