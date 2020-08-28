<?php

use Illuminate\Database\Seeder;

class VerbeteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		\App\Verbete::create(['descricao' => 'Verbete 1'] ); 
		\App\Trecho::create([
			"verbete_id" => 1,
			"titulo_video" => "Palestra do evento teste",
			"tipo_recurso" => "vídeo", 
			"tempo" => "03h10min34s a 03h12min08s", 
			"endereco_video" => "#", 
			"texto" => "Aqui deve ser colocado o texto do trecho.", 
			"arquivo_hd" => "",
			"arquivo_sd" => "",
            "quant_views" => 0]);
		\App\Verbete::create(['descricao' => 'Verbete 2'] ); 
		\App\Trecho::create([
			"verbete_id" => 2,
			"titulo_video" => "Palestra do evento teste",
			"tipo_recurso" => "vídeo", 
			"tempo" => "00h04min29s a 00h05min01s", 
			"endereco_video" => "#", 
			"texto" => "Aqui deve ser colocado o texto do trecho.", 
			"arquivo_hd" => "",
			"arquivo_sd" => "",
            "quant_views" => 0]);
		\App\Verbete::create(['descricao' => 'Verbete 3'] ); 
		\App\Trecho::create([
			"verbete_id" => 3,
			"titulo_video" => "Palestra do evento teste",
			"tipo_recurso" => "vídeo", 
			"tempo" => "01h50min51s a 01h50min26s", 
			"endereco_video" => "#", 
			"texto" => "Aqui deve ser colocado o texto do trecho.", 
			"arquivo_hd" => "",
			"arquivo_sd" => "",
            "quant_views" => 0]);
		\App\Trecho::create([
			"verbete_id" => 3,
			"titulo_video" => "Entrevista do evento teste",
			"tipo_recurso" => "áudio", 
			"tempo" => "01h32min27s a 01h32min54s", 
			"endereco_video" => "#", 
			"texto" => "Aqui deve ser colocado o texto do trecho.", 
			"arquivo_hd" => "",
			"arquivo_sd" => "",
            "quant_views" => 0]);
		\App\Trecho::create([
			"verbete_id" => 1,
			"titulo_video" => "Entrevista do evento teste",
			"tipo_recurso" => "áudio", 
			"tempo" => "00h42min46s a 00h44min54s", 
			"endereco_video" => "#", 
			"texto" => "Aqui deve ser colocado o texto do trecho.", 
			"arquivo_hd" => "",
			"arquivo_sd" => "",
            "quant_views" => 0]);
		\App\Trecho::create([
			"verbete_id" => 2,
			"titulo_video" => "Entrevista do evento teste",
			"tipo_recurso" => "áudio", 
			"tempo" => "00h47min22s a 00h47min41s", 
			"endereco_video" => "#", 
			"texto" => "Aqui deve ser colocado o texto do trecho.", 
			"arquivo_hd" => "",
			"arquivo_sd" => "",
            "quant_views" => 0]);

    }
}
