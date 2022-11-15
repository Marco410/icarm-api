<?php

namespace App\Http\Controllers;

use App\Models\UserContext;
use App\Models\ViewUserRelationshipWithClient;
use App\Models\User;
use App\Models\Evento;
use App\Models\EventoAsistencia;

use Illuminate\Http\Request;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;


class EventoController extends ApiController
{
    public function lista_eventos(Request $request)
    {

        $user = $this->getUserLoggedIn();

        $eventos['eventos'] = Evento::where('type','evento')->with('user')->get();

        return $this->ok($eventos);

    }

    public function lista_grupos(Request $request)
    {

        $user = $this->getUserLoggedIn();

        $eventos['eventos'] = Evento::where('type','grupo')->with('user')->get();

        return $this->ok($eventos);

    }

    public function create(Request $request)
    {

        $user = $this->getUserLoggedIn();

        $nameFoto = $this->storeFoto($request);

        $evento = Evento::create([
            'user_id' => $user->id,
            'nombre' => $request->nombre,
            'ubicacion' => $request->ubicacion,
            'fecha' => $request->fecha,
            'tipo_evento' => $request->tipo_evento,
            'sobre_de' => $request->sobre_de,
            'des_corta' => $request->des_corta,
            'link_form' => $request->link_form,
            'type' => $request->type,
            'foto' => $nameFoto
        ]);

        return $this->ok($evento);
    }

    public function registrar_asistencia(Request $request)
    {

        $user = $this->getUserLoggedIn();

        $asistencia = EventoAsistencia::where('user_id',$user->id)->where('evento_id',$request->evento_id)->first();

        if($asistencia){
            $evento['msj'] = "Ya registraste tu asistencia para este evento.";
        }else{
            $evento = EventoAsistencia::create([
                'user_id' => $user->id,
                'evento_id' => $request->evento_id
            ]);
        }
        return $this->ok($evento);
    }

    public function storeFoto($request)
    {

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $name = $file->getClientOriginalName();
            $nameResult = $this->generateNameFile($name);

           /*  request()->file("imagen")->storeAs('public', 'marcas/' . $nameResult); */

           $ruta = storage_path() .'/app/public/eventos/'.$request->bb_id;

            if (!file_exists($ruta)) {
                mkdir($ruta, 0775, true);
            }

           $path = $ruta ."/".$nameResult;

            Image::make($request->file('foto'))
                ->resize(768,449)->save($path);

            return $nameResult;
        } else {
            return null;
        }
    }

    public function generateNameFile($value)
    {
        $link = html_entity_decode($value);
        $link = $this->deleteAccents($link);
        $link = strtolower($link); 
        $link = preg_replace("/[^ A-Za-z0-9_.-]/", '', $link);
        $link = str_replace(' ', '-', $link);

        return $link;
    }

    public function deleteAccents($cadena)
    {
        $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿ';
        $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyyby';
        $cadena = utf8_decode($cadena);
        $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
        return utf8_encode($cadena);
    }


    public function get_peso(Request $request)
    {
        $user = $this->getUserLoggedIn();

        $peso = RegistroCrecimiento::where('bb_id',$request->bb_id)->select('fecha_registro','peso')->get();
        return $this->ok($peso);

    }

    public function get_talla(Request $request)
    {
        $user = $this->getUserLoggedIn();
        $talla = RegistroCrecimiento::where('bb_id',$request->bb_id)->select('fecha_registro','talla')->get();
        return $this->ok($talla);

    }

    public function get_toma_leche(Request $request)
    {
        $user = $this->getUserLoggedIn();
        $toma_leche = RegistroTomaLeche::where('bb_id',$request->bb_id)->select('fecha_registro','tiempo')->get();
        return $this->ok($toma_leche);

    }
}
