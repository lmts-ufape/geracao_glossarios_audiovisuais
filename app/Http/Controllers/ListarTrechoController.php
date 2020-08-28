<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ListarTrechoController extends Controller
{
    /* 
        Retorna os trecho de acordo com o verbete selecionado
    */
    public function listar($id) {
        $verbete = \App\Verbete::find($id);
        $descricao = $this->tirarAcentos($verbete->descricao);
        $l = str_split($descricao)[0];

        // Ignora acentos na descrição do verbete para a listagem dos verbetes ficar em ordem alfabetica
        $verbetes = DB::select("SELECT * FROM verbetes as V WHERE unaccent(V.descricao) ILIKE '" . $l . "%' ORDER BY unaccent(V.descricao);");
        
        $trechosVideos = \App\Trecho::where([['verbete_id', '=', $id], ['tipo_recurso', '=', 'vídeo']])->get();
        $trechosAudios = \App\Trecho::where([['verbete_id', '=', $id], ['tipo_recurso', '=', 'áudio']])->get();
        return View('glossario.glossario')->with(['trechosVideos' => $trechosVideos, 'trechosAudios' => $trechosAudios, 'verbeteSelecionado' => $verbete, 'verbetes' => $verbetes, 'letraSelecionada' => $l]);
    }

    // Tira os acentos de uma string
    public static function tirarAcentos($string){
        return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$string);
    }
}
