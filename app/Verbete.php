<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Verbete extends Model
{
    protected $fillable = ['descricao'];
    public static $rules= ['descricao' => 'required|min:5|max:100'];
    public static $messages = ['descricao.*' => 'O campo descrição é obrigatório e deve ter entre 5 e 100 caracteres'];

    public function trechos() {
        return $this->hasMany('\App\Trechos');
    }
}
