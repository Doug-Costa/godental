<?php
$tipoTopo = 'topoPreto';
?>

@extends('layouts.master')

@section('content')

<div class="container" style="padding-top: 30px;">
	<div class="row">
		<div class="col-sm-4"></div>
		<div class="col-sm-4">
			<form method="POST" action="{{ route('login') }}" enctype="multipart/form-data">
	            @csrf

	            <div class="row">
	              <div class="mb-3">
	                <label for="E-mail" class="form-label">{{__("messages.LogarBladeEmail")}}</label>
	                <input type="email" name="email" class="form-control" id="emailLoginLabel" aria-describedby="emailLogin">
	                <div id="emailLogin" class="form-text">{{__("messages.LogarBladeCadastrado")}}</div>
	              </div>
	            </div>

	            <div class="row">
	              <div class="mb-3">
	                <label for="password" class="form-label">{{__("messages.LogarBladeCadastrado")}}</label>
	                <input type="password" name="password" class="form-control" id="senhaLogin" aria-describedby="passoword">
	              </div>
	            </div>

	            <div class="row">
	              <div class="mb-3">
	                <input type="submit" value="Logar" class="btn btn-danger dropdown-toggle botaoLogar">
	              </div>
	            </div>
	                
	         </form>
		</div>
		<div class="col-sm-4"></div>
	</div>
</div>

@endsection