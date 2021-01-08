<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\Imagen;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('post.index');
    }
    public function api_index()
    {
        //
        $datos= Post::with(['user','categoria','imagenes'])->get();
        return $datos;
        // return Post::with(['user','categoria','imagenes'])->get();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        ini_set("memory_limit", "100M");
        ini_set('post_max_size', '50M');
        ini_set('upload_max_filesize', '50M');

        // return response()->json($request->all());
        $titulo=$request->titulo;
        $detalle=$request->detalle;
        $categoria_id=$request->categoria_id;
        $user_id=$request->user_id;
        $imagen=$request->imagen_miniatura;

        $objeto=new Post();
        $objeto->titulo=$titulo;
        $objeto->detalle=$detalle;
        $objeto->categoria_id=$categoria_id;
        $objeto->user_id=$user_id;
        $objeto->save();

        if ($imagen) {
            $imagen_explode = explode(',', $imagen);
            $imagen_decode = base64_decode($imagen_explode[1]);
            $src = 'miniatura_' . $objeto->id . '.jpg';
            Storage::disk('post')->put($src,  $imagen_decode);
            $objeto->imagen_miniatura=$src;
            $objeto->save();
        }

        foreach ($request->imagenes as $imagen) {
            $imagen_ = $imagen['imgSrc'];
            if ($imagen_) {
                $img=new Imagen();
                $img->nombre='';
                $img->miniatura=0;
                $img->post_id=$objeto->id;
                $img->save();
                $imagen_explode = explode(',', $imagen_);
                $imagen_decode = base64_decode($imagen_explode[1]);
                $src = 'post_' . $objeto->id . '.jpg';
                Storage::disk('post')->put($src,  $imagen_decode);

                $img->nombre=$src;
                $img->save();
            }
        }
        return response()->json(['status'=>'1']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        {
            //
            ini_set("memory_limit", "100M");
            ini_set('post_max_size', '50M');
            ini_set('upload_max_filesize', '50M');

            // return response()->json($request->all());
            $titulo=$request->titulo;
            $detalle=$request->detalle;
            $categoria_id=$request->categoria_id;
            $user_id=$request->user_id;
            $imagen=$request->imagen_miniatura;

            $objeto= Post::findorfail($id);
            $objeto->titulo=$titulo;
            $objeto->detalle=$detalle;
            $objeto->categoria_id=$categoria_id;
            $objeto->user_id=$user_id;
            $objeto->save();

            if ($imagen) {
                $imagen_explode = explode(',', $imagen);
                if(count($imagen_explode)>1){
                    $imagen_decode = base64_decode($imagen_explode[1]);
                    $src = 'miniatura_' . $objeto->id . '.jpg';
                    Storage::disk('post')->put($src,  $imagen_decode);
                    $objeto->imagen_miniatura=$src;
                    $objeto->save();
                }
            }
            else{
                $objeto->imagen_miniatura='';
                $objeto->save();
                Storage::disk('post')->delete($imagen);
            }
            // limpiamos la db de imagenes que se borraron
            $todas_imagenes=Imagen::where('post_id',$objeto->id)->get();

            $arregloNoBorrado=Array();
            $i=0;
            foreach ($request->imagenes as $imagen) {
                if($imagen['id']>0){
                    $arregloNoBorrado[$i] = $imagen['id'];
                    $i++;
                }
            }

            foreach ($todas_imagenes as $imagenEnDb) {
                if(!in_array($imagenEnDb->id,$arregloNoBorrado)){
                    $temp=Imagen::findorfail($imagenEnDb->id);
                    $temp->delete();
                    Storage::disk('post')->delete($imagenEnDb->nombre);
                }
            }
            // procedemos a agregar las nuevas imagenes

            foreach ($request->imagenes as $imagen) {
                $imagen_ = $imagen['imgSrc'];
                $imagen_id = $imagen['id'];

                if ($imagen_) {
                    if($imagen_id==0){
                        $imagen_explode = explode(',', $imagen_);
                        if(count($imagen_explode)>1){
                            $img=new Imagen();
                            $img->miniatura=0;
                            $img->nombre='';
                            $img->post_id=$objeto->id;
                            $img->save();
                            $imagen_decode = base64_decode($imagen_explode[1]);
                            $src = 'post_' . $img->id . '.jpg';
                            Storage::disk('post')->put($src,  $imagen_decode);
                            $img->nombre=$src;
                            $img->save();
                        }
                    }
                }
            }
            return response()->json(['status'=>'1']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $objeto= Post::findorfail($id);
        $objeto->delete();
        return response()->json(['status'=>'1']);
    }
    public function get_imagen($filename)
    {
        $file = Storage::disk('post')->get($filename);
        return response($file, 200);
    }
}
