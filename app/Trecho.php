<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trecho extends Model
{
    protected $fillable = [ "verbete_id",
                            "titulo_video",
                            "tipo_recurso",
                            "tempo",
                            "endereco_video",
                            "texto",
                            "arquivo"];
    public static $rules= [
        "verbete_id" => "required",
        "titulo_video" => "required",
        "tipo_recurso" => "required",
        "tempo" => "required",
        "endereco_video" => "required",
        "texto" => "required",
        "arquivo" => "required"
        ];

    public static $messages = [
        "verbete_id.*" => "Selecione o verbete ao qual este trecho pertence",
        "titulo_video.*" => "O título do vídeo é um campo obrigatório",
        "tipo_recurso.*" => "O tipo de recurso é um campo obrigatório",
        "tempo.*" => "O tempo é um campo obrigatório",
        "endereco_video.*" => "O endereço do vídeo é um campo obrigatório",
        "texto.*" => "O texto do vídeo é um campo obrigatório",
        "arquivo.*" => "O arquivo é um campo obrigatório"
        ];

    public function verbete() {
        return $this->belongsTo('\App\Verbete');
    }
}
