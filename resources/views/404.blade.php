<?php
$tipoTopo = 'topoPreto';
?>

@extends('layouts.master')

@section('content')

<div class="col-sm-12" style="padding-top: 50px;">
	<h1 style="text-align: center;">{{__("messages.Erro404")}}</h1>
	<img src="{{ asset('imagens/404.png') }}" calss="img-fluid" style="margin: 50px auto; display: block;">
</div>

@endsection