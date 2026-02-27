<!doctype html>
<html lang="pt">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
    <meta name="description" content="Bem vindo ao DentalGO a plataforma online dos melhores dentistas">
    <meta name="description" content="">
    <meta name="author" content="Dental Press">
    <title>{{__("messages.LogarBooksBladeGo")}}</title>
  	@include('layouts.estilo')
</head>
<body>
	<div class="container" style="padding-top: 30px;">
		<div class="row">
			<div class="col-sm-4"></div>
			<div class="col-sm-4">
				<form method="POST" action="{{ route('loginbooks') }}" enctype="multipart/form-data">
		            @csrf

		            <div class="row">
		              <div class="mb-3">
		                <label for="E-mail" class="form-label">{{__("messages.LogarBooksBladeEmail")}}</label>
		                <input type="email" name="email" class="form-control" id="emailLoginLabel" aria-describedby="emailLogin">
		                <div id="emailLogin" class="form-text">{{__("messages.LogarBooksBladeCadastrado")}}</div>
		              </div>
		            </div>

		            <div class="row">
		              <div class="mb-3">
		                <label for="password" class="form-label">{{__("messages.LogarBooksBladeSenha")}}</label>
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
	@include('layouts.scripts')
</body>
</html>