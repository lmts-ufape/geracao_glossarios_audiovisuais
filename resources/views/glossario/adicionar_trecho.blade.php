@extends('layouts.app')

@section('content')
<div class="row">
        <div class="col-sm-12" style="margin-bottom: 25px; margin-top: 25px;">
            <div style="margin-left: 12%; align-items: left;"><a style="font-size: 25px; font-family: 'Segoe-ui', 'Segoe-ui-ie', serif;">@lang('mensagens.Adicionar trecho')</a></div>
        <div class="col-sm-12">
        {{-- @if ($errors->any())
            <div class="col-md-12" style="margin-top: 5px;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li class="alert alert-danger" role="alert">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif --}}
        </div>
            <div class="col-sm-12">
                <ul class="list-group" style="align-items: center;">
                    <li class="list-group-item div_container" style="width: 80%;">
                        <form action="{{ route('trecho.add.save', ['id' => $id])}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row" style="margin-top:10px;">
                                <div class="col-sm-8">
                                    <label for="titulo" style="width: 100%; word-wrap: break-word; font-weight: bolder;">@lang('mensagens.Titulo'):</label>
                                    <input autofocus type="text" class="form-control @error('título') is-invalid @enderror" id="titulo" name="título" value="@if(old('título') != null) {{old('título')}} @endif">                                    
                                
                                    @error('título')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-sm-4" style="font-weight: bolder;">
                                    <label for="tipo">Tipo de recurso:</label>
                                    <select id="tipo" class="custom-select custom-select-sm-3 @error('tipo_de_recurso') is-invalid @enderror" name="tipo_de_recurso" onchange="mudar()">
                                        <option value="" selected>Selecione o tipo de recurso</option>
                                        <option @if(old('tipo_de_recurso') == "áudio") selected @endif value="áudio">Áudio</option>
                                        <option @if(old('tipo_de_recurso') == "vídeo") selected @endif value="vídeo">Vídeo</option>
                                    </select>
                                    @error('tipo_de_recurso')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row" style="margin-top:10px;">
                                <div class="col-sm-12">
                                    <label for="texto" style="width: 100%; word-wrap: break-word; font-weight: bolder;">@lang('mensagens.Texto'):</label>
                                    <textarea id="texto" name="texto" class="form-control @error('texto') is-invalid @enderror" rows="8" cols="90" style="width: 100%; word-wrap: break-word;">@if(old('texto') != null) {{old('texto')}} @endif</textarea>
                                    
                                    @error('texto')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div id="paragrafoAudio" style="display: none;">
                                <div class=row style="margin-top:10px;">
                                    <div class="col-sm-6">
                                        <span style="font-weight: bolder;">@lang('mensagens.audioHD'):</span> 
                                    </div>
                                    <div class="col-sm-6">
                                        <span style="font-weight: bolder;">@lang('mensagens.audioSD'):</span>
                                    </div>
                                </div>
                                <div class="row" style="margin-top:10px;">
                                    <div class="col-sm-6 form-control-file">
                                        <input id="arquivo_hd_audio" type="file" accept=".mp3,.mp4,.m4a,.ogg,.flac" name="arquivo_hd_audio" style="width: 93%; left: 15px;">
                                        {{-- <label class="custom-file-label @error('arquivo_hd_audio') is-invalid @enderror" for="arquivo_hd_audio" style="width: 93%; left: 15px;">@lang('mensagens.SelecioneHD')...</label> --}}
                                        
                                        @error('arquivo_hd_audio')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6 form-control-file">
                                        <input id="arquivo_sd_audio" type="file" accept=".mp3,.mp4,.m4a,.ogg,.flac" name="arquivo_sd_audio" style="width: 93%; left: 15px;">
                                        {{-- <label class="custom-file-label @error('arquivo_sd_audio') is-invalid @enderror" for="arquivo_sd_audio" style="width: 93%; left: 15px;">@lang('mensagens.SelecioneSD')...</label> --}}
                                    
                                        @error('arquivo_sd_audio')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div id="paragrafoVideo" style="display: none;">
                                <div class=row style="margin-top:10px;">
                                    <div class="col-sm-6">
                                        <span style="font-weight: bolder;">@lang('mensagens.HD'):</span> 
                                    </div>
                                    <div class="col-sm-6">
                                        <span style="font-weight: bolder;">@lang('mensagens.SD'):</span> 
                                    </div>
                                </div>
                                <div class="row" style="margin-top:10px;">
                                    <div class="col-sm-6 form-control-file">
                                        <input id="arquivo_hd_video" type="file" accept=".mp4,.mkv,.ogv,.webm" name="arquivo_hd_video" style="width: 93%; left: 15px;">
                                        {{-- <label class="custom-file-label @error('arquivo_hd_video') is-invalid @enderror" for="arquivo_hd_video" style="width: 93%; left: 15px;">@lang('mensagens.SelecioneHD')...</label> --}}
                                    
                                        @error('arquivo_hd_video')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6 form-control-file">
                                        <input id="arquivo_sd_video" type="file" accept=".mp4,.mkv,.ogv,.webm" name="arquivo_sd_video" style="width: 93%; left: 15px;">
                                        {{-- <label @error('arquivo_sd_video') is-invalid @enderror" for="arquivo_sd_video" style="width: 93%; left: 15px;">@lang('mensagens.SelecioneSD')...</label> --}}
                                        
                                        @error('arquivo_sd_video')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top:10px;">
                                <div class="col-sm-6">
                                    <label for="tempo" style="width: 100%; word-wrap: break-word; font-weight: bolder;">@lang('mensagens.Tempo'):</label>
                                    <input id="tempo" class="form-control @error('tempo') is-invalid @enderror" name="tempo" type="text" size="50px" value="@if(old('tempo') != null) {{old('tempo')}} @endif">
                                    
                                    @error('tempo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-sm-6">
                                    <label id="endereco_label" for="endereco" style="width: 100%; word-wrap: break-word; font-weight: bolder;">@lang('mensagens.Link do arquivo completo'):</label>
                                    <input id="endereco" name="endereço" class="form-control @error('endereço') is-invalid @enderror" type="text" size="50px" value="@if(old('endereço') != null) {{old('endereço')}} @endif">
                                    
                                    @error('endereço')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row" style="padding: 2rem 0rem 2rem 0rem;">
                                <div class="col-sm-6">
                                    <a href="javascript:history.back()"><button type="button" class="btn" style="border-color:#d5d5d5; border-width:2px; height: 40px; background-color: white; width: 100%;"><label class="campo_compartilhar_texto">@lang('mensagens.Cancelar')</label></button></a>                            
                                </div>
                                <div class="col-sm-6">
                                    <button type="submit" class="btn btn-atualizar" style="border-width:2px; height: 40px;">@lang('mensagens.Salvar')</button>
                                </div>
                                
                            </div>
                        </form>
                    </li>   
                </ul>
            </div>
        </div>
</div>

<script>
    var combobox = document.getElementById('tipo');
    var labelEndereco = document.getElementById('endereco_label');

    if (combobox.value == "áudio") {
        document.getElementById('paragrafoAudio').style.display = 'inline';
        document.getElementById('paragrafoVideo').style.display = 'none';
        labelEndereco.innerText = "@lang('mensagens.Link do áudio completo')";
    } else if (combobox.value == "vídeo") {
        document.getElementById('paragrafoAudio').style.display = 'none';
        document.getElementById('paragrafoVideo').style.display = 'inline';
        labelEndereco.innerText = "@lang('mensagens.Link do vídeo completo')";
    } else {
        document.getElementById('paragrafoAudio').style.display = 'none';
        document.getElementById('paragrafoVideo').style.display = 'none';
        labelEndereco.innerText = "@lang('mensagens.Link do arquivo completo')";
    }

    // função para esconder e exibir as imagens e inputs dos videos e audios pelo combobox
    function mudar() {
        var combobox = document.getElementById('tipo');
        var labelEndereco = document.getElementById('endereco_label');

        if (combobox.value == "áudio") {
            document.getElementById('paragrafoAudio').style.display = 'inline';
            document.getElementById('paragrafoVideo').style.display = 'none';
            labelEndereco.innerText = "@lang('mensagens.Link do áudio completo')";
        } else if (combobox.value == "vídeo") {
            document.getElementById('paragrafoAudio').style.display = 'none';
            document.getElementById('paragrafoVideo').style.display = 'inline';
            labelEndereco.innerText = "@lang('mensagens.Link do vídeo completo')";
        } else {
            document.getElementById('paragrafoAudio').style.display = 'none';
            document.getElementById('paragrafoVideo').style.display = 'none';
            labelEndereco.innerText = "@lang('mensagens.Link do arquivo completo')";
        }
    }
</script>
@endsection