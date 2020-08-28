@extends('layouts.app')

@section('content')
<div class="row" style="justify-content: center; margin-top: 2rem; margin-bottom: 2rem;">
    <div class="col-sm-5">
        <h3>@lang('mensagens.Adicionar um verbete')</h3>
        <div class="card">
            <div class="row">
                <div class="card-body">
                    <form action="{{ route('verbete.add.save') }}" method="POST">
                        @csrf
                        <div class="col-sm-12" style="padding: 1rem;">
                            <label for="nome" style="width: 100%; word-wrap: break-word; font-weight: bolder;">@lang('mensagens.Nome'):</label>
                            <input autofocus type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" value="@if(old('nome') != null) {{old('nome')}} @endif">

                            @error('nome')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-6" style="padding: 1rem;">
                                    <a href="javascript:history.back()"><button type="button" class="btn" style="border-color:#d5d5d5; border-width:2px; height: 40px; width: 100%; background-color: white; color: #acabab;">@lang('mensagens.Cancelar')</button></a>                                 
                                </div>
                                <div class="col-sm-6" style="padding: 1rem;">
                                    <button type="submit" class="btn" style="border-color:#d5d5d5; border-width:2px; height: 40px; width: 100%; background-color: white; color: white; background-color: rgb(10, 173, 64);">@lang('mensagens.Adicionar')</button>                                
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection