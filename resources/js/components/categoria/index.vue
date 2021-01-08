<template>
    <div>
<div class="card">
        <!-- <div class="card-header"> </div> -->
        <div class="card-body">
            <div class="row">
                <div class="col col-12 text-right mb-4">
                    <div class="row">
                        <div class="col col-10 text-left">
                            <h4>Listado de Categorias</h4>
                        </div>
                        <div class="col col-2">
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal" @click="mostrar_modal()">
                                <i class="fas fa-plus-circle"></i> Agregar
                            </button>
                        </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Agregar Categoria</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="form-group text-left">
                                        <label for="nombre">Nombre</label>
                                        <input type="text" class="form-control" id="nombre" placeholder="Ingrese el nombre" v-model="categoria.nombre">
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="button" class="btn btn-primary" @click="agregar()"><i class="fas fa-save"></i> Guardar</button>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="col col-12 text-right">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Creado</th>
                        <th scope="col">Operaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(categoria_,clave) in categorias" :key="clave">
                        <td scope="row">{{clave+1}}</td>
                        <td>{{ categoria_.nombre }}</td>
                        <td>

                            {{moment(categoria_.created_at).format('dddd, Do MMMM YYYY, h:mm:ss a')}}
                        </td>
                        <td>
                            <button type="button" class="btn btn-warning" @click="editar(categoria_)"><i class="fas fa-edit"></i></button>
                            <button type="button" class="btn btn-danger" @click="borrar(categoria_.id)"><i class="fas fa-trash-alt"></i></button>
                            </td>
                        </tr>


                    </tbody>
                </table>
                </div>
            </div>

        </div>
    </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            categorias:[],
            categoria:{
                id:0,
                nombre:''
            },categoria_inicial:{
                id:0,
                nombre:''
            },
            modal:false,
            mostrr:'hide'
        }
    },
    created() {
        this.index();
    },
    methods: {
        async index(){
            let datos= await axios.get('/api/v1/categorias');
            this.categorias=datos.data
        },
        async agregar(){
            console.log('agregar');
            if(this.categoria.nombre.trim().length==0)
                return false;
            if(this.categoria.id>0){
                // Editamos
                let datos= await axios.put(`/api/v1/categorias/${this.categoria.id}`,this.categoria);
                console.log('rpt;',datos.data);
                if(datos.data.status==1){
                    // alert('datos editados')
                    this.categoria=this.categoria_inicial
                    this.ocultar();
                    this.index();
                }
            }else{
                // Agregamos
                let datos= await axios.post('/api/v1/categorias',this.categoria);
                console.log('rpt;',datos.data);
                if(datos.data.status==1){
                    // alert('datos guardados')
                    this.categoria=this.categoria_inicial
                    this.ocultar();
                    this.index();
                }
            }

        },
        mostrar_modal(){
            this.categoria=this.categoria_inicial
        },
        mostrar(){
            if(this.mostrr=='hide')
                this.mostrr='show';
            $('#exampleModal').modal(this.mostrr)
            console.log('mensa',this.mostrr)
        },
        ocultar(){
            this.mostrr='hide';
            $('#exampleModal').modal(this.mostrr)
        },
        editar(categoria){
            this.categoria=categoria;
            this.mostrar()
        },
        async delete(categoria_id){
            let datos= await axios.delete(`/api/v1/categorias/${categoria_id}`);
                console.log('rpt;',datos.data);
                if(datos.data.status==1){
                    // alert('datos guardados')
                    this.index();
                }
        },
        borrar(categoria_id){
            this.$confirm("Estas seguro de borra este dato?").then(() => {
                this.delete(categoria_id);
            });
        }
    },
}
</script>
