<?php

namespace App\Http\Controllers;

use App\Models\UserContext;
use App\Models\ViewUserRelationshipWithClient;
use App\Models\User;
use App\Models\Denuncia;

use App\Mail\DenunciaMail;

use Illuminate\Support\Facades\Mail;

use Illuminate\Http\Request;

class DenunciaController extends ApiController
{
    public function index(Request $request)
    {
        return $this->ok(User::all());
    }

    public function create(Request $request)
    {
        $denuncia = Denuncia::create([
            'nombre' => $request->nombre,
            'ciudad' => $request->ciudad,
            'estado' => $request->estado,
            'pais' => $request->pais,
            'email' => $request->email,
            'msj' => $request->msj
        ]);

        Mail::to('app.LLL.Int@gmail.com')->send(new DenunciaMail($denuncia));

        return $this->ok($denuncia);
    }
}
