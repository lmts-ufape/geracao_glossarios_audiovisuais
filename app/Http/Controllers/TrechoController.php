<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\File;

class TrechoController extends Controller
{   
    // Função de retorno para edição do trecho
    public function index($id) {
        $trecho = \App\Trecho::where('id', '=', $id)->first();
        return view('glossario.editar_trecho')->with(['trecho' => $trecho]);
    }

    // Função de atualização do trecho
    public function update(Request $request, $id) {
        //recuperando o trecho
        $arquivo = '';
        $trecho = \App\Trecho::find($id);
        $validated = $request->validate([
            'titulo_video' => 'required',
            'tipo_de_recurso' => 'required',
            'texto' => 'required',
            'tempo' => 'required',
            'endereco' => 'required',
            'arquivo_hd_video' => 'nullable|file|mimetypes:video/mp4,video/mkv,video/ogv,video/webm',
            'arquivo_sd_video' => 'nullable|file|mimetypes:video/mp4,video/mkv,video/ogv,video/webm',
            'arquivo_hd_audio' => 'nullable|file|mimetypes:audio/mp3,audio/mp4,audio/m4a,audio/ogg,audio/flac,audio/mpga',
            'arquivo_sd_audio' => 'nullable|file|mimetypes:audio/mp3,audio/mp4,audio/m4a,audio/ogg,audio/flac,audio/mpga',
        ]);

        //substituindo o texto e o titulo do $request no trecho
        $trecho->texto = $request->texto;
        $trecho->tipo_recurso = $request->tipo_de_recurso;
        $trecho->titulo_video = $request->titulo_video;
        $trecho->endereco_video = $request->endereco;
        $trecho->tempo = $request->tempo;
        
        //salvar o nome do arquivo para resetar as views
        $nome_antigo_hd = $trecho->arquivo_hd;
        $nome_antigo_sd = $trecho->arquivo_sd;

        //colocando os nomes dos arquivos como referencia

        if ($trecho->tipo_recurso == "áudio") {
            if (is_null($request->file('arquivo_hd_audio'))) {
                $trecho->arquivo_hd = $trecho->arquivo_hd;
            } else {
                $trecho->arquivo_hd = $this->nomeDoArquivo($request->file('arquivo_hd_audio'), $trecho->arquivo_hd);
            }
    
            if (is_null($request->file('arquivo_sd_audio'))) {
                $trecho->arquivo_hd = $trecho->arquivo_hd;
            } else {
                $trecho->arquivo_sd = $this->nomeDoArquivo($request->file('arquivo_sd_audio'), $trecho->arquivo_sd);
            }
        } else {
            if (is_null($request->file('arquivo_hd_video'))) {
                $trecho->arquivo_hd = $trecho->arquivo_hd;
            } else {
                $trecho->arquivo_hd = $this->nomeDoArquivo($request->file('arquivo_hd_video'), $trecho->arquivo_hd);
            }
    
            if (is_null($request->file('arquivo_sd_video'))) {
                $trecho->arquivo_hd = $trecho->arquivo_hd;
            } else {
                $trecho->arquivo_sd = $this->nomeDoArquivo($request->file('arquivo_sd_video'), $trecho->arquivo_sd);
            }
        }
        
        //checagem se mudou de arquivo para resetar as views
        //as views só seram resetadas se os dois arquivos forem mudados
        if ($nome_antigo_sd != $trecho->arquivo_sd && $nome_antigo_hd != $trecho->arquivo_hd) {
            $trecho->quant_views = 0;
        }

        //salva a edição
        $trecho->update();
        return redirect()->back()->with('mensagem', 'Trecho salvo com sucesso!');
    }

    // Função que retorna o nome do arquivo salvo
    public function nomeDoArquivo($file, $arquivo) {
        $nome = $file->store('multimidia', 'public');

        //Checa se o trecho já tem algum arquivo associado a ele e se foi enviado um novo arquivo
        if ($arquivo != '' && !(is_null($file))) {
            //deleta o arquivo que estava associado ao trecho
            Storage::delete($arquivo);
        }

        //retorna o novo nome do arquivo
        return $nome;
    }

    // Função que retorna a view para adicionar um novo trecho
    public function adicionar($id) {
        return view('glossario.adicionar_trecho')->with(['id' => $id]);
    }

    // Função que salva o novo trecho
    public function salvar(Request $request, $id) {
        $validated = $request->validate([
            'texto' => 'required',
            'título' => 'required',
            'tipo_de_recurso' => 'required',
            'tempo' => 'required',
            'endereço' => 'required',
            'arquivo_hd_video' => 'nullable|file|mimetypes:video/mp4,video/mkv,video/ogv,video/webm',
            'arquivo_sd_video' => 'nullable|file|mimetypes:video/mp4,video/mkv,video/ogv,video/webm',
            'arquivo_hd_audio' => 'nullable|file|mimetypes:audio/mp3,audio/mp4,audio/m4a,audio/ogg,audio/flac,audio/mpga',
            'arquivo_sd_audio' => 'nullable|file|mimetypes:audio/mp3,audio/mp4,audio/m4a,audio/ogg,audio/flac,audio/mpga',
        ]);

        $trecho = new \App\Trecho();

        $trecho->verbete_id = $id;
        $trecho->texto = $request->texto;
        $trecho->titulo_video = $request->título;
        $trecho->tipo_recurso = $request->tipo_de_recurso;
        $trecho->tempo = $request->tempo;
        $trecho->endereco_video = $request->endereço;
        $trecho->quant_views = 0;
        
        if ($request->tipo_de_recurso == "áudio") {
            //colocando os nomes dos arquivos como referencia
            if (is_null($request->file('arquivo_hd_audio'))) {
                $trecho->arquivo_hd = '';
            } else {
                $trecho->arquivo_hd = $this->nomeDoArquivo($request->file('arquivo_hd_audio'), '');
            }

            if (is_null($request->file('arquivo_sd_audio'))) {
                $trecho->arquivo_sd = '';
            } else {
                $trecho->arquivo_sd = $this->nomeDoArquivo($request->file('arquivo_sd_audio'), '');
            }
        } else {
            //colocando os nomes dos arquivos como referencia
            if (is_null($request->file('arquivo_hd_video'))) {
                $trecho->arquivo_hd = '';
            } else {
                $trecho->arquivo_hd = $this->nomeDoArquivo($request->file('arquivo_hd_video'), '');
            }

            if (is_null($request->file('arquivo_sd_video'))) {
                $trecho->arquivo_sd = '';
            } else {
                $trecho->arquivo_sd = $this->nomeDoArquivo($request->file('arquivo_sd_video'), '');
            } 
        }

        $trecho->save();
        
        return redirect( route('verbete', ['id' => $id]) )->with('mensagem', 'Trecho salvo com sucesso!');
    }

    // Função que deleta o trecho e seus respectivos arquivos
    public function deletar($id) {
        $trecho = \App\Trecho::find($id);

        if ($trecho->arquivo_hd != '') {
            Storage::delete($trecho->arquivo_hd);
        }

        if ($trecho->arquivo_sd != '') {
            Storage::delete($trecho->arquivo_sd);
        }

        $trecho->delete();

        return redirect()->back()->with('mensagem', 'Trecho excluido com sucesso!');
    }

    // Função para download do arquivo SD do trecho
    public function baixarSD($id) {
        $trecho = \App\Trecho::find($id);

        if (Storage::disk()->exists($trecho->arquivo_sd)) {
            return Storage::download($trecho->arquivo_sd, "TrechoSD.".explode(".", $trecho->arquivo_sd)[1]);
        }
      
        return abort(404);
    }

    // Função para download do arquivo HD do trecho
    public function baixarHD($id) {
        $trecho = \App\Trecho::find($id);

        if (Storage::disk()->exists($trecho->arquivo_hd)) {
            return Storage::download($trecho->arquivo_hd, "TrechoHD.".explode(".", $trecho->arquivo_sd)[1]);
        }
      
        return abort(404);
    }

    // Função para apenas exclusão do arquivo SD do trecho
    public function excluirSD($id) {
        $trecho = \App\Trecho::find($id);

        if (Storage::disk()->exists($trecho->arquivo_sd)) {
            Storage::delete($trecho->arquivo_sd);
        } 

        $trecho->arquivo_sd = '';
        $trecho->update();
        return redirect()->back()->with(['mensagem' => 'Arquivo de video excluido com sucesso.']);
    }

    // Função para apenas exclusão do arquivo HD do trecho
    public function excluirHD($id) {
        $trecho = \App\Trecho::find($id);

        if (Storage::disk()->exists($trecho->arquivo_hd)) {
            Storage::delete($trecho->arquivo_hd);
        } 

        $trecho->arquivo_hd = '';
        $trecho->update();
        return redirect()->back()->with(['mensagem' => 'Arquivo de video excluido com sucesso.']);
    }
}