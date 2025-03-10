var route = document.querySelector("[name=url_route]").getAttribute("value");
var urlRetornables = route + "/apiRetornable";
var urlCategorias = route + "/apiCategoria";
var urlProductos = route + "/apiProductoRetornable";
var urlTipos= route + "/apiTipo";

new Vue({

    http: {
        headers: {
            "X-CSRF-TOKEN": document
                .querySelector("#token")
                .getAttribute("value"),
        },
    },

    el: "#retornable",

    data:{
        retornables:[],
        tipos:[],
        id:'',
        paletas:'',
        saldos_c_tarimas:'',
        saldos_s_tarimas:'',
        total:'',
        agregando:true,

        productos:[],
        id_producto:'',
        id_tipo:'',

    },

    created: function(){
        this.obtenerRetornables();
        this.obtenerProductos();
        this.obtenerTipos();
    },

    methods:{
        obtenerRetornables:function(){
            this.$http.get(urlRetornables).then(function(respuesta){
                this.retornables = respuesta.data;
                console.log(respuesta.data);

                $(function () {
                    $("#retornableTable").DataTable({
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
                    }).buttons().container().appendTo('#retornableTable_wrapper .col-md-6:eq(0)');
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
        obtenerTipos:function(){
            this.$http.get(urlTipos).then(function(respuesta){
                this.tipos = respuesta.data;
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

            $('#ModalRetornable').modal('show');
        },

        agregarRetornables:function(){
            var retornable={
                paletas:this.paletas,
                saldos_c_tarimas:this.saldos_c_tarimas,
                saldos_s_tarimas:this.saldos_s_tarimas,
                total:this.total,
                id_producto:this.id_producto,
              };

              console.log(retornable)

            //se envian los datos en json al controlador
            this.$http.post(urlRetornables,retornable).then(function(j){
                $("#retornableTable").DataTable().destroy();
                this.obtenerRetornables();
                this.paletas='';
                this.saldos_c_tarimas='';
                this.saldos_s_tarimas='';
                this.total='';
                this.id_producto='';


            }).catch(function(j){
                console.log(j);
            })

            $('#ModalRetornable').modal('hide');


        },

        eliminarRetornables:function(id){
            var confir= confirm('¿Estás seguro de que deseas eliminarlo?')

            if (confir)
            {
                this.$http.delete(urlRetornables + '/' + id).then(function(json){
                    $("#retornableTable").DataTable().destroy();
                    this.obtenerRetornables();
                }).catch(function(json){

                });

            }
        },

        editarRetornables:function(id){
            this.agregando=false;
            this.id=id;

            this.$http.get(urlRetornables + '/' + id).then(function(json){
                // console.log(json.data);
                this.paletas=json.data.paletas;
                this.saldos_c_tarimas=json.data.saldos_c_tarimas;
                this.saldos_s_tarimas=json.data.saldos_s_tarimas;
                this.total=json.data.total;
                this.id_producto=json.data.id_producto;
            })

            $('#ModalRetornable').modal('show');
        },

        actualizarRetornables:function(){
            var jsonRetornable={
                                paletas:this.paletas,
                                saldos_c_tarimas:this.saldos_c_tarimas,
                                saldos_s_tarimas:this.saldos_s_tarimas,
                                total:this.total,
                                id_producto:this.id_producto,
                            };
                            // console.log(jsonProducto);
            this.$http.patch(urlRetornables + '/' + this.id, jsonRetornable).then(function(json){
                $("#retornableTable").DataTable().destroy();
                this.obtenerRetornables();
                $('#ModalRetornable').modal('hide');
            });

        },


    }
});
