<?php
$tipoTopo = 'topoPreto';

?>

@extends('layouts.master')

@section('content')
<div class="container" style="padding-top: 100px;">
	<div class="row">
		<div class="col-sm-2"></div>
		<div class="col-sm-8">

				@if($localizado == 1 || $localizado == 2 || $localizado == 3)
					<h2>
						{{__("messages.ModalRecSenhaOla")}} {{$usuario->fullName}}
					</h2>
					
				<form method="POST" action="{{ route('recsenhaaply') }}?cod={{request()->input('cod')}}" enctype="multipart/form-data"  onsubmit="return validateFormRecSenha()">
						<div class="row">
				            @csrf
				            <div class="col-12">
				            	<div class="mb-3">
				            		@if($localizado == 2)
					            		<p style="color:red;">
					            			*E-mail digitado não condiz com o que esta cadastrado no sistema!
					            		</p>
				            		@endif
				                	<label for="password" class="form-label">{{__("messages.ModalRecSenhaEmail")}}</label>
				                	<input type="text" name="email" class="form-control" id="EmailRec" aria-describedby="passoword">
				              	</div>
				            </div>

				            <div class="col-12">
				            	<h5 style="font-size: 13px;">
									{{__("messages.ModalRecSenhaDesc")}}
								</h5>
				            </div>

				            @if($localizado == 2)
				            	<div class="col-12">
				            		<p style="color:red;">
				            			*As senhas digitadas não são iguais!
				            		</p>
				            	</div>
				            @endif
				            <div class="col-12 col-md-6">
				            	<div class="mb-3">
				                	<label for="password" class="form-label">{{__("messages.ModalRecSenha")}}</label>
				                	<input type="password" name="password" class="form-control" id="senhaLogin" aria-describedby="passoword">
				              	</div>
				            </div>

				            <div class="col-12 col-md-6">
							    <div class="mb-3">
							        <label for="password" class="form-label">{{__("messages.ModalRecSenhaConfirm")}}</label>
							        <input type="password" name="passwordconfirm" class="form-control" id="senhaConfirm" aria-describedby="password">
							        <span id="senhaError" style="color:red;"></span>
							    </div>
							</div>

				            <div class="col-12">
				              <div class="mb-3">
				                <input type="submit" value='{{__("messages.Redefinir")}}' class="btn btn-danger dropdown-toggle botaoLogar">
				              </div>
				            </div>
				        </div>
			       	</form>
			    @else
			    	<h3>
			    		Usuario não localizado, porfavor tente novamente mais tarde
			    	</h3>
			    @endif
			
		</div>
		<div class="col-sm-2"></div>
	</div>
</div>



@endsection