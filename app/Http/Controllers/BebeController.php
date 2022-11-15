<?php

namespace App\Http\Controllers;

use App\Models\UserContext;
use App\Models\ViewUserRelationshipWithClient;
use App\Models\User;
use App\Models\Bebe;
use App\Models\RegistroTomaLeche;
use App\Models\RegistroPanales;
use App\Models\RegistroCrecimiento;

use Illuminate\Http\Request;

use Intervention\Image\Facades\Image;


class BebeController extends ApiController
{
    public function index(Request $request)
    {
        return "Todos los bebes";
    }

    public function create(Request $request)
    {

        $user = $this->getUserLoggedIn();

        $bebe = Bebe::create([
            'user_id' => $user->id,
            'nombre' => $request->nombre,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'sexo' => $request->sexo,
            'peso' => $request->peso,
            'talla' => $request->talla,
            'perimetro' => $request->perimetro
        ]);

        return $this->ok($bebe);

    }

    public function get_bebes(Request $request)
    {

        $user = $this->getUserLoggedIn();

        $bebes['bebes'] = Bebe::where('user_id',$user->id)->get();

        return $this->ok($bebes);

    }

    public function registro_crecimiento(Request $request)
    {

        $user = $this->getUserLoggedIn();

        $registro_crecimiento = RegistroCrecimiento::create([
            'user_id' => $user->id,
            'bb_id' => $request->bb_id,
            'fecha_registro' => $request->fecha_registro,
            'peso' => $request->peso,
            'talla' => $request->talla,
            'notas' => $request->notas
        ]);

        return $this->ok($registro_crecimiento);

    }

    public function registro_toma_leche(Request $request)
    {

        $user = $this->getUserLoggedIn();

        $registro_toma_leche = RegistroTomaLeche::create([
            'user_id' => $user->id,
            'bb_id' => $request->bb_id,
            'fecha_registro' => $request->fecha_registro,
            'pecho' => $request->pecho,
            'hora' => $request->hora,
            'tiempo' => $request->tiempo,
            'notas' => $request->notas
        ]);

        return $this->ok($registro_toma_leche);

    }

    public function registro_panales(Request $request)
    {

        $user = $this->getUserLoggedIn();

        $nameFoto = $this->storeFoto($request);

        $registro_panales = RegistroPanales::create([
            'user_id' => $user->id,
            'bb_id' => $request->bb_id,
            'fecha_registro' => $request->fecha_registro,
            'textura' => $request->textura,
            'cantidad' => $request->cantidad,
            'foto' => $nameFoto,
            'notas' => $request->notas
        ]);

        return $this->ok($registro_panales);

    }

    public function storeFoto($request)
    {

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $name = $file->getClientOriginalName();
            $nameResult = $this->generateNameFile($name);

           /*  request()->file("imagen")->storeAs('public', 'marcas/' . $nameResult); */

           $ruta = storage_path() .'/app/public/panales/'.$request->bb_id;

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
