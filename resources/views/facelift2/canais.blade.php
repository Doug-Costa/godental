@extends('facelift2.master')

@section('content')
<div class="container">
    <div class="d-flex align-items-center justify-content-between" style="margin-top: 40px; margin-bottom:30px;">
        <h2 class="h4 titulogeral" >Tecnologias</h2>
    </div>
    <div class="row tecnologiascanais">
        
        <div class="col-6 col-md-4">
            <a href="https://www.dentalgo.com.br/parceiro/73/dvi">
            <img src="{{ asset('facelift2/img/dvicanais.png') }}" class="img-fluid">
            </a>
        </div>
        <div class="col-6 col-md-4">
            <a href="https://www.dentalgo.com.br/clinicorp">
            <img src="{{ asset('facelift2/img/clinicorpcanais.png') }}" class="img-fluid">
            </a>
        </div>
        <div class="col-6 col-md-4">
            <a href="https://www.dentalgo.com.br/dentsplysirona">
            <img src="{{ asset('facelift2/img/dentsplycanais.png') }}" class="img-fluid">
            </a>
        </div>    
        <div class="col-6 col-md-4">
            <a href="https://www.dentalgo.com.br/invisalign">
            <img src="{{ asset('facelift2/img/invisaligncanais.png') }}" class="img-fluid">
            </a>
        </div>
        <div class="col-6 col-md-4">
            <a href="https://dentalgo.com.br/biologix">
            <img src="{{ asset('facelift2/img/biologixcanais.png') }}" class="img-fluid">
            </a>
        </div>
        <div class="col-6 col-md-4">
            <a href="https://dentalgo.com.br/shining3d">
            <img src="{{ asset('facelift2/img/shiningcanais.png') }}" class="img-fluid">
            </a>
        </div>

    </div>
    
    
</div>
<div class="container">
<div class="my-slider15 carrossellogocanais" style="margin-top: 50px; margin-bottom: 20px">
    <a href="https://www.dentalgo.com.br/facelift25/clinicorp"><img src="{{ asset('facelift2/img/clinicorp.png') }}"></a>
    <a href="https://www.dentalgo.com.br/facelift25/dentsplysirona"><img src="{{ asset('facelift2/img/dentsply.png') }}"></a>
    <a href="https://dentalgo.com.br/facelift25/invisalign"><img src="{{ asset('facelift2/img/alignbranco (1).png') }}"></a>
    <a href="https://dentalgo.com.br/facelift25/biologix"><img src="{{ asset('facelift2/img/biologixbranco (1).png') }}"></a>
    <a href="https://www.dentalgo.com.br/facelift25/parceiro/73/dvi"><img src="{{ asset('facelift2/img/dvi.png') }}"></a>
    <a href="https://orthometric.com.br/"><img src="{{ asset('facelift2/img/testando123.fw.png') }}"></a>
    <a href="https://easy3d.com.br/"><img src="{{ asset('facelift2/img/easy3d.png') }}"></a>
    <a href="https://id-logical.com/"><img src="{{ asset('facelift2/img/id-logicallogo.png') }}"></a>
    <a href="https://dentalgo.com.br/facelift25/shining3d"><img src="{{ asset('facelift2/img/shininglogobranca (1).png') }}"    ></a>
    
    </div>
    </div>
@endsection