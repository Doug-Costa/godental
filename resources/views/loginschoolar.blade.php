<?php
$tipoTopo = 'topoPreto';
?>

@extends('layouts.master')

@section('content')

<div class="container" style="padding-top: 30px;">
	<div class="row">
		<div class="col-sm-4"></div>
		<div class="col-sm-4">
			<div class="text-center mb-4">
				<h3>Login Escolar</h3>
				<p class="text-muted">Acesse sua área de estudos</p>
			</div>

			@if ($errors->any())
				<div class="alert alert-danger">
					<ul class="mb-0">
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif

			<form method="POST" action="{{ route('loginschoolar') }}" enctype="multipart/form-data">
	            @csrf

	            <div class="row">
	              <div class="mb-3">
	                <label for="email" class="form-label">E-mail</label>
	                <input type="email" name="email" class="form-control" id="emailSchoolarLogin" value="{{ old('email') }}" required aria-describedby="emailHelp">
	                <div id="emailHelp" class="form-text">Digite o e-mail cadastrado na instituição</div>
	              </div>
	            </div>

	            <div class="row">
	              <div class="mb-3">
	                <label for="password" class="form-label">Senha</label>
	                <input type="password" name="password" class="form-control" id="senhaSchoolarLogin" required aria-describedby="passwordHelp">
	                <div id="passwordHelp" class="form-text">Digite sua senha de acesso</div>
	              </div>
	            </div>

	            <div class="row">
	              <div class="mb-3">
	                <input type="submit" value="Entrar" class="btn btn-primary w-100 botaoLogar">
	              </div>
	            </div>

	            <div class="text-center">
	            	<a href="{{ route('home') }}" class="text-muted">Voltar ao início</a>
	            </div>
	                
	         </form>
		</div>
		<div class="col-sm-4"></div>
	</div>
</div>

@endsection