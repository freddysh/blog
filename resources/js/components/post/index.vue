<template>
    <div>
<div class="card">
        <!-- <div class="card-header"> <h3>Listado de Post</h3></div> -->
        <div class="card-body">
            <div class="row">
                <div class="col col-12 text-right mb-4">
                    <div class="row">
                        <div class="col col-10 text-left">
                            <h4>Listado de Post</h4>
                        </div>
                        <div class="col col-2">
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal" @click="mostrar_modal()">
                                <i class="fas fa-plus-circle"></i> Agregar
                            </button>
                        </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Agregar Post</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="form-group text-left">
                                        <label for="titulo">Titulo</label>
                                        <input type="text" class="form-control" id="titulo" placeholder="Ingrese el titulo" v-model="post.titulo">
                                    </div>
                                    <div class="form-group text-left">
                                        <label for="detalle">Detalle</label>
                                        <ckeditor :editor="editor" v-model="post.detalle" :config="editorConfig"></ckeditor>
                                    </div>
                                    <div class="form-group text-left">
                                        <label for="categoria">Categoria</label>
                                        <select class="form-control" id="categoria" v-model="post.categoria_id">
                                            <option value="0">Ingrese una opcion</option>
                                            <option  v-for="(categoria_,clave) in categorias" :key="clave" :value="categoria_.id">{{ categoria_.nombre }}</option>
                                        </select>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col col-12 text-left">
                                            <label for="miniatura">Miniatura <span class="text-danger">(150x150)</span></label>
                                        </div>
                                        <div class="col col-4">
                                            <croppa v-model="myCroppa"
                                                :width="150"
                                                :height="150"
                                                :canvas-color="'default'"
                                                :placeholder="'Escoja una imagen'"
                                                :placeholder-font-size="0"
                                                :placeholder-color="'default'"
                                                :accept="'image/*'"
                                                :file-size-limit="0"
                                                :quality="2"
                                                :zoom-speed="3"
                                            ></croppa>
                                        </div>
                                        <div class="col col-2">
                                            <button type="button" class="btn btn-primary" @click="generateImage()"> <i class="fas fa-arrow-circle-right"></i> </button>
                                        </div>
                                        <div class="col col-4">
                                            <div v-if="post.imagen_miniatura"  class="card">
                                                <div class="card-header">
                                                    <div class="row">
                                                        <div class="col-10 text-left">Miniatura</div>
                                                        <div class="col-2">
                                                            <button type="button" class="btn btn-danger" @click="borrar_miniatura()"><i class="fas fa-trash-alt"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                        <img class="output w-100" :src="post.imagen_miniatura">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col col-12 text-left">
                                            <label for="imagenes">Imagenes <span class="text-danger">(350x250)</span></label>
                                        </div>
                                        <div class="col col-6">
                                            <croppa v-model="myCroppa1"
                                                :width="350"
                                                :height="250"
                                                :canvas-color="'default'"
                                                :placeholder="'Escoja una imagen'"
                                                :placeholder-font-size="0"
                                                :placeholder-color="'default'"
                                                :accept="'image/*'"
                                                :file-size-limit="0"
                                                :quality="2"
                                                :zoom-speed="3"
                                            ></croppa>
                                        </div>
                                        <div class="col col-6 text-left" >
                                            <button type="button" class="btn btn-primary" @click="generateImagenes()"><i class="fas fa-arrow-circle-right"></i></button>
                                        </div>
                                        <hr>
                                        <div v-if="post.imagenes.length>0" class="col-12 text-left"><h4>Imagenes agregadas</h4></div>
                                        <div v-for="(imagen,clave) in post.imagenes" :key="clave" class="col col-4 mt-1">
                                            <div v-if="imagen.imgSrc" class="card">
                                                <div class="card-header">
                                                    <div class="row">
                                                        <div class="col-10 text-left">Imagen {{clave+1}}</div>
                                                        <div class="col-2">
                                                            <button type="button" class="btn btn-danger" @click="borrar_imagen(imagen)"><i class="fas fa-trash-alt"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <img :src="imagen.imgSrc" class="output1 w-100">
                                                </div>
                                            </div>
                                        </div>
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
                    <!-- <div class="form-group text-left">
                        <input type="text" class="form-control" id="buscar" placeholder="Ingrese el titulo" v-model="searchLangs">
                    </div> -->
                <table class="table table-striped table-hover table-condensed">
                    <thead>
                        <tr class="text-left">
                        <th scope="col">#</th>
                        <th scope="col">Titulo</th>
                        <th scope="col">Creado</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Categoria</th>
                        <th scope="col">Operaciones</th>
                        </tr>
                    </thead>
                    <paginate
                    name="posts"
                    :list="posts"
                    :per="10"
                    tag="tbody">
                    <tr class="text-left" v-for="(post_,clave) in paginated('posts')" :key="clave">
                            <td scope="row">{{clave+1}}</td>
                            <td>{{ post_.titulo }}</td>
                            <td>{{ post_.user.name }}</td>
                            <td>
                                {{moment(post_.created_at).format('dddd, Do MMMM YYYY, h:mm:ss a')}}
                            </td>
                            <td><span class="badge bg-primary">{{ post_.categoria.nombre }}</span></td>
                            <td>
                                <button type="button" class="btn btn-warning" @click="editar(post_)"><i class="fas fa-edit"></i></button>
                                <button type="button" class="btn btn-danger" @click="borrar(post_.id)"><i class="fas fa-trash-alt"></i></button>
                            </td>
                        </tr>
                    </paginate>
                    <paginate-links  for="posts" :classes="{'ul': 'pagination', 'li': 'page-item', 'a': 'page-link'}"  :async="true"
                    :show-step-links="true"
                    :step-links="{
                                    next: 'Next',
                                    prev: 'Preview'
                                }"
                    ></paginate-links>
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
            searchLangs:'',
            myCroppa: {},
            imgUrl: '',
            myCroppa1:{},
            categorias:[],
            posts:[],
            paginate: ['posts'],
            post:{
                id:0,
                titulo:'',
                detalle:'',
                user_id:0,
                categoria_id:0,
                imagen_miniatura:'',
                imagenes:[]
            },post_inicial:{
                id:0,
                titulo:'',
                detalle:'',
                user_id:0,
                categoria_id:0,
                imagen_miniatura:'',
                imagenes:[]
            },
            modal:false,
            mostrr:'hide',
            editor: ClassicEditor,
            editorConfig: {
                // The configuration of the editor.
            }
        }
    },
    created() {
        this.index();
        this.listar_categorias();
    },
    methods: {
        async listar_categorias(){
            let datos= await axios.get('/api/v1/categorias');
            this.categorias=datos.data
        },
        async index(){
            let datos= await axios.get('/api/v1/posts');

            // console.log('posts:',datos.data.);
            this.posts=datos.data.map(datos=>({
                id:datos.id,
                titulo:datos.titulo,
                detalle:datos.detalle,
                user_id:datos.user_id,
                user:datos.user,
                categoria:datos.categoria,
                categoria_id:datos.categoria_id,
                created_at:datos.created_at,
                imagenes:datos.imagenes.map(ima=>({
                    id:ima.id,
                    imgSrc:ima.nombre
                    ?`/storage/post/${ima.nombre}`
                    : "",
                })),
                imagen_miniatura:datos.imagen_miniatura
                ? `/storage/post/${datos.imagen_miniatura}`
                : "",
            }));
            this.posts.sort((a, b) => b.id - a.id)
        },
        async agregar(){
            console.log('agregar');
            if(this.post.titulo.trim().length==0)
                return;
            if(this.post.detalle.trim().length==0)
                return;
            if(this.post.categoria_id==0)
                return;
            if(this.post.id>0){
                // Editamos
                let datos= await axios.put(`/api/v1/posts/${this.post.id}`,this.post);
                console.log('rpt;',datos.data);
                if(datos.data.status==1){
                    // alert('datos editados')
                    this.post=this.post_inicial
                    this.ocultar();
                    this.index();
                }
            }else{
                // Agregamos
                // this.post.imagenes=this.imagenes
                this.post.user_id=this.user_id
                let datos= await axios.post('/api/v1/posts',this.post);
                console.log('rpt;',datos.data);
                if(datos.data.status==1){
                    // alert('datos guardados')
                    this.post=this.post_inicial
                    this.ocultar();
                    this.index();
                }
            }

        },
        mostrar_modal(){
            this.post=this.post_inicial
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
        editar(post){
            this.post=post;
            this.mostrar()
        },
        async delete(post_id){
            let datos= await axios.delete(`/api/v1/posts/${post_id}`);
                console.log('rpt;',datos.data);
                if(datos.data.status==1){
                    // alert('datos guardados')
                    this.index();
                }
        },
        borrar(post_id){
            this.$confirm("Estas seguro de borra este dato?").then(() => {
                this.delete(post_id);
            });
        },

        // saveImage(type, compressionRate) {
        //     this.myCroppa.generateBlob((blob) => {
        //         var url = URL.createObjectURL(blob);
        //         var a = document.createElement('a');
        //         a.download = 'filename';
        //         a.href = url;
        //         a.click();
        //         URL.revokeObjectURL(url);
        //     }, type, compressionRate)
        // },
        generateImage: function() {
            let url = this.myCroppa.generateDataUrl()
            if (!url) {
                alert('no image')
                return
            }
            // this.imgUrl = url
            this.post.imagen_miniatura=url

            // this.myCroppa={}
        },
        borrar_miniatura(){
            this.post.imagen_miniatura=''
            // this.imgUrl=''
        },
        generateImagenes(){
            let url = this.myCroppa1.generateDataUrl()
            if (!url) {
                alert('no image')
                return
            }
            // this.imgUrl = url
            this.post.imagenes.push({id:0,imgSrc:url})
            // this.myCroppa1={}
        }
        ,borrar_imagen(value){
            var indice = this.post.imagenes.indexOf(value);
            if (indice != -1)
                this.post.imagenes.splice(indice, 1);
        }
    },
    computed: {
    fLangs () {
        const re = new RegExp(this.searchLangs, 'i')
        return this.posts.filter(lang => lang.match(re))
    }
}
}
</script>
