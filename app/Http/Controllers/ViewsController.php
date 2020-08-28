<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewsController extends Controller
{
    // Função que retorna a view inicial do site
    public function glossario() {
        return view('glossario.glossario');
    }

    // Função que retorna a view de lista de palavras
    public function listarPalavras() {
        return view('glossario.lista_de_palavras');
    }
    
    // Função que retorna a view de pesquisa
    public function pesquisa() {
        return view('glossario.pesquisa');
    }

    // Função que conta a view do trecho de vídeo ou áudio
    public function contarView($id) {
        $trecho = \App\Trecho::find($id);
        $trecho->quant_views = $trecho->quant_views + 1;
        $trecho->update();
    }

}
