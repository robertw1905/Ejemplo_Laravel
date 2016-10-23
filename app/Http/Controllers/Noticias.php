<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Noticia;

use Storage;

class Noticias extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function mostrar()
    {
        //a
        $noticias = Noticia::all();
        return view('welcome')->with('noticias', $noticias);
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
        //Validacion del formulario

        $this->validate($request, [
            'titulo' => 'required',
            'descripcion' => 'required',
        ]);

        //
        $noticia = New Noticia();

        $noticia->titulo = $request->titulo;
        $noticia->descripcion = $request->descripcion;

        // echo "<pre>insert\n";var_dump($request->file());exit;
        if ( $request->file('urlImg') != null )
        {
            $img = $request->file('urlImg');
            $file_route = time().'_'.$img->getClientOriginalName();

            Storage::disk('imgNoticias')->put($file_route, file_get_contents($img->getRealPath()));
            Storage::disk('imgNoticias')->delete($request->img);
            $noticia->urlImg  = $file_route;
        }

        if($noticia->save()){
            return back()->with('msj', 'Datos Guardados');
        }else{
            return back()->with('errormsj', 'Error al guardar los datos');
        }



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
        //dd('edit');
        $noticia = Noticia::find($id);
        return view('home')->with(['edit' => true, 'noticia' => $noticia]);
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
        //Validacion del formulario

        $this->validate($request, [
            'titulo' => 'required',
            'descripcion' => 'required',
            'urlImg' => 'required'
        ]);

        //
        $noticia = Noticia::find($id);

        $noticia->titulo = $request->titulo;
        $noticia->descripcion = $request->descripcion;
        // echo "<pre>modificar\n";var_dump($request->file());exit;
        if ( $request->file('urlImg') != null )
        {
            $img = $request->file('urlImg');
            $file_route = time().'_'.$img->getClientOriginalName();

            Storage::disk('imgNoticias')->put($file_route, file_get_contents($img->getRealPath()));
            Storage::disk('imgNoticias')->delete($request->img);
            $noticia->urlImg  = $file_route;
        }else{
            $noticia->urlImg  = null;
        }

        if($noticia->save()){
            //return back()->with('msj', 'Datos Modificados');
            return redirect('home');
        }else{
            return back()->with('errormsj', 'Error al guardar los datos');
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
        Noticia::destroy($id);
        return back();
    }
}
