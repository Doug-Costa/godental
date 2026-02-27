{{-- Exibe erros do withErrors() --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Erros:</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- Exibe mensagens de erro simples --}}
@if (session('error'))
    <div class="alert alert-danger">
        <strong>Erro:</strong> {{ session('error') }}
    </div>
@endif

{{-- Exibe mensagens de sucesso --}}
@if (session('success'))
    <div class="alert alert-success">
        <strong>Sucesso:</strong> {{ session('success') }}
    </div>
@endif

{{-- Exibe qualquer mensagem de sessão --}}
@foreach (session()->all() as $key => $value)
    @if (is_string($value) && !in_array($key, ['_token', '_previous', '_flash']))
        <div class="alert alert-info">
            <strong>Session [{{ $key }}]:</strong> {{ $value }}
        </div>
    @endif
@endforeach

<form method="POST" action="{{ route('schoolarlogin') }}" enctype="multipart/form-data">
            @csrf

            <div class="row">
              <div class="mb-3">
                <label for="E-mail" class="form-label">{{__("messages.ModalEmail")}}</label>
                <input type="email" name="email" class="form-control" id="emailLoginLabel" aria-describedby="emailLogin">
                <div id="emailLogin" class="form-text">{{__("messages.ModalSubEmail")}}</div>
              </div>
            </div>

            <div class="row">
              <div class="mb-3">
                <label for="password" class="form-label">{{__("messages.ModalSenha")}}</label>
                <input type="password" name="password" class="form-control" id="senhaLogin" aria-describedby="passoword">
              </div>
            </div>

            <div class="row">
              <div class="mb-3">
                <a data-bs-toggle="modal" data-bs-target="#modalRecSenha" class="btn btn-secondary botaoLogin"><i class="fa-solid fa-user"></i> {{__("messages.ModalSenhaEsqueceu")}}</a>
                <input type="submit" value="{{__("messages.ModaLogin")}}" class="btn btn-danger dropdown-toggle botaoLogar" style="float: right;">
              </div>
            </div>
                
          </form>