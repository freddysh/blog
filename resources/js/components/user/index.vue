<template>
    <div>
<div class="card">
        <!-- <div class="card-header"> </div> -->
        <div class="card-body">
            <div class="row">
                <div class="col col-12 text-right mb-4">
                    <div class="row">
                        <div class="col col-10 text-left">
                            <h4>Listado de Usuarios</h4>
                        </div>
                        <div class="col col-2">
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal" @click="mostrar_modal()">
                                <i class="fas fa-plus-circle"></i> Agregar
                            </button>
                        </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
                    <div class="modal-dialog modal-md" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Agregar Usuario</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="form-group text-left">
                                        <label for="nombre">Nombre</label>
                                        <input type="text" class="form-control" id="nombre" placeholder="Ingrese el nombre" v-model="user.name">
                                    </div>
                                    <div class="form-group text-left">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" placeholder="Ingrese el email" v-model="user.email">
                                    </div>
                                    <div class="form-group text-left">
                                        <label for="password">Password</label>
                                        <input type="text" class="form-control" id="password" placeholder="Ingrese el password" v-model="user.password">
                                    </div>
                                    <div class="form-group text-left">
                                        <label for="categoria">Categoria</label>
                                        <select class="form-control" id="categoria" v-model="user.rol">
                                            <option value="0">Escoja una opcion</option>
                                            <option  v-for="(rol,clave) in roles" :key="clave" :value="rol.id">{{ rol.nombre }}</option>
                                        </select>
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
                <table class="table table-striped table-hover table-condensed">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Email</th>
                        <th scope="col">Creado</th>
                        <th scope="col">Rol</th>
                        <th scope="col">Operaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(user_,clave) in users" :key="clave">
                        <td scope="row">{{clave+1}}</td>
                        <td>{{ user_.name }}</td>
                        <td>{{ user_.email }}</td>
                        <td>
                            {{moment(user_.created_at).format('dddd, Do MMMM YYYY, h:mm:ss a')}}
                        </td>
                        <td>
                            <span v-if="user_.rol=='admin'" class="badge bg-success">{{ user_.rol }}</span>
                            <span v-if="user_.rol=='editor'" class="badge bg-primary">{{ user_.rol }}</span>
                        </td>
                        <td>
                            <button type="button" class="btn btn-warning" @click="editar(user_)"><i class="fas fa-edit"></i></button>
                            <button type="button" class="btn btn-danger" @click="borrar(user_.id)"><i class="fas fa-trash-alt"></i></button>
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
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

export default {
    components: { },
    props:['user_id'],
    data() {
        return {
            roles:[{id:'admin',nombre:'Administrador'},{id:'editor',nombre:'Editor'}],
            users:[],
            user:{
                id:0,
                name:'',
                email:'',
                password:'',
                rol:0
            },user_inicial:{
                id:0,
                name:'',
                email:'',
                password:'',
                rol:0
            },
            modal:false,
            mostrr:'hide',
        }
    },
    created() {
        this.index();
        // this.listar_categorias();
    },
    methods: {
        // async listar_categorias(){
        //     let datos= await axios.get('/api/v1/categorias');
        //     this.categorias=datos.data
        // },
        async index(){

// id:0,
//                 titulo:'',
//                 detalle:'',
//                 user_id:0,
//                 categoria_id:0,
//                 imagen_miniatura:'',
//                 imagenes:[]

// respuestas: datos.f_respuesta_trivias.map(respuesta => ({
//               id: respuesta.id,
//               titulo: respuesta.titulo,
//               pos: respuesta.pos,
//               correcta: respuesta.correcta,
//               imagen: respuesta.f_imagen ? respuesta.f_imagen.src : ""
//             }))

            let datos= await axios.get('/api/v1/users');
            this.users=datos.data.map(datos=>({
                id:datos.id,
                name:datos.name,
                email:datos.email,
                password:datos.password2,
                rol:datos.rol
            }));
            console.log('rpt',datos.data);
        },
        async agregar(){
            console.log('agregar');
            if(this.user.name.trim().length==0)
                return;
            if(this.user.email.trim().length==0)
                return;
            if(this.user.password.trim().length==0)
                return;
            if(this.user.id>0){
                // Editamos
                let datos= await axios.put(`/api/v1/users/${this.user.id}`,this.user);
                console.log('rpt;',datos.data);
                if(datos.data.status==1){
                    // alert('datos editados')
                    this.user=this.post_inicial
                    this.ocultar();
                    this.index();
                }
            }else{
                // Agregamos
                // this.user.imagenes=this.imagenes
                // this.user.user_id=this.user_id
                let datos= await axios.post('/api/v1/users',this.user);
                console.log('rpt;',datos.data);
                if(datos.data.status==1){
                    // alert('datos guardados')
                    this.user=this.user_inicial
                    this.ocultar();
                    this.index();
                }
            }

        },
        mostrar_modal(){
            this.user=this.user_inicial
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
        editar(user){
            this.user=user;
            this.mostrar()
        },
        async delete(user_id){
            let datos= await axios.delete(`/api/v1/users/${user_id}`);
                console.log('rpt;',datos.data);
                if(datos.data.status==1){
                    // alert('datos guardados')
                    this.index();
                }
        },
        borrar(user_id){
            this.$confirm("Estas seguro de borra este dato?").then(() => {
                this.delete(user_id);
            });
        },
    },
}
</script>
