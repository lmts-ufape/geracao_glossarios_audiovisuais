<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VerbeteController extends Controller
{
    // Função que retorna a view para adicionar o verbete
    public function exibir() {
        return view('glossario.adicionar_verbete');
    }

    // Função que salva o novo verbete
    public function adicionar(Request $request) {
        $validated = $request->validate([
            'nome' => 'required',
        ]);

        $verbete = new \App\Verbete();

        $verbete->descricao = $request->nome;
        $verbete->save();

        return redirect( route('glossario') )->with('mensagem', 'Verbete salvo com sucesso!');
    }

    // Função que deleta o verbete
    public function deletar($id) {
        $verbete = \App\Verbete::find($id);
        
        $trechos = \App\Trecho::where('verbete_id', $id)->get();

        foreach ($trechos as $trecho) {
            if ($trecho->arquivo_hd != '' && Storage::disk()->exists($trecho->arquivo_hd)) {
                Storage::delete($trecho->arquivo_hd);
            }
    
            if ($trecho->arquivo_sd != '' && Storage::disk()->exists($trecho->arquivo_sd)) {
                Storage::delete($trecho->arquivo_sd);
            }
            $trecho->delete();
        }

        $verbete->delete();
        return redirect( route('glossario') )->with('mensagem', 'Verbete excluido com sucesso!');
    }

    // Função que salva a edição do verbete
    public function editar(Request $request, $id) {
        $validated = $request->validate([
            'descricao' => 'required',
        ]);

        $verbete = \App\Verbete::find($id);

        $verbete->descricao = $request->descricao;
        $verbete->update();

        return redirect()->back()->with('mensagem', 'Verbete editado com sucesso!');;
    }
}
