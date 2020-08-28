<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ListarVerbeteController extends Controller
{
    // Busca o verbete de acordo com a letra selecionada
    public function listar($l) {
        $verbetes = DB::select("SELECT * FROM verbetes as V WHERE unaccent(V.descricao) ILIKE '" . $l . "%' ORDER BY unaccent(V.descricao);");
        return View('glossario.glossario')->with(['verbetes' => $verbetes, 'letraSelecionada' => $l]);
    }
}
