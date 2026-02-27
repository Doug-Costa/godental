<?php
$tipoTopo = 'topoPreto';
?>

@extends('layouts.master')

@section('content')
<div class="container-fluid produtoTopo produtoTopo" style="background: url({{ asset('imagens/minhacontafundo.png') }}) no-repeat top center fixed !important;">
    <div class="container containerColecao">
        <div class="row">
            <h1 style="display: flex; color: #fff; font-size: 75px; align-items: center;">{{__("messages.MinhaContaBladeMinha")}}</h1>
        </div>
    </div>
</div>
<div class="container-fluid revistaApoiadoresFundoCol3" style="background: #8fa6a9; filter: drop-shadow(0px 2px 2px #9999); margin-bottom: 10px;">
    <div class="container">
        <div class="row">
            <ul class="nav nav-tabs centerTab" id="myTab" role="tablist">
              <li class="nav-item centerTab" role="presentation">
                <button class="nav-link buscaLink active" id="minhabiblioteca-tab" data-bs-toggle="tab" data-bs-target="#minhabiblioteca" type="button" role="tab" aria-controls="minhabiblioteca" aria-selected="true"> {{__("messages.MinhaContaBladeBiblioteca")}}</button>
              </li>
              <!--<li class="nav-item centerTab" role="presentation">
                <button class="nav-link buscaLink" id="videos-tab" data-bs-toggle="tab" data-bs-target="#meusfavoritos" type="button" role="tab" aria-controls="meusfavoritos" aria-selected="false">{{__("messages.MinhaContaBladeFavoritos")}}</button>
              </li>-->
              <li class="nav-item centerTab" role="presentation">
                <button class="nav-link buscaLink" id="minhaconta-tab" data-bs-toggle="tab" data-bs-target="#minhaconta" type="button" role="tab" aria-controls="minhaconta" aria-selected="false">{{__("messages.MinhaContaBladeMyac")}}</button>
              </li>
            </ul>
        </div>
    </div>
</div>
<div class="container tab-content" id="myTabContent" style="margin-top: 50px; margin-bottom: 50px;">
    <!-- TAB Minha biblioteca -->
    <div class="tab-pane fade show active" id="minhabiblioteca" role="tabpanel" aria-labelledby="minhabiblioteca-tab">
        <div class="row" style="margin-bottom: 30px;">
            <div class="col-sm-12">
                <h1>{{__("messages.MinhaContaBladeComprados")}}</h1>
            </div>
        </div>
        <div class="row">
            @if(count($minhaconta['minhabiblioteca']->rows) == 0)

            <h2>{{__("messages.MinhaContaBladeNoComprados")}}</h2>

            @else

                @foreach ($minhaconta['minhabiblioteca']->rows as $key => $produto)
                    <article class="col-6 col-md-3 col-lg-2">
                        <a href="{{ route('produtocomprado') }}/{{ $produto->id }}/{{ str_replace(' ', '-', $produto->title) }}" alt="{{ $produto->title }} - {{ $produto->brief }}" class="tiraUnderline">
                            <img class="img-fluid sombrita arredonda-imagem" src="{{ $produto->cover }}" alt="{{ $produto->title }} - {{ $produto->brief }}" width="100%" height="auto">
                            <h1 class="colecaoRound">
                                {{ $produto->title }}
                            </h1>
                            <p style="display: none !important;">{{ $produto->brief }}</p>
                        </a>
                    </article>
                @endforeach

            @endif
        </div>
    </div>

    <!-- TAB Meus favoritos -->
    <!--<div class="tab-pane fade show" id="meusfavoritos" role="tabpanel" aria-labelledby="meusfavoritos-tab">
        <div class="row" style="margin-bottom: 30px;">
            <div class="col-sm-12">
                <h1>{{__("messages.MinhaContaBladeFavoritados")}}</h1>
            </div>
        </div>
        <div class="row">

            @if(count($minhaconta['meusFav']->rows) == 0)

            <h2>{{__("messages.MinhaContaBladeNoFavoritos")}}</h2>

            @else

                @foreach ($minhaconta['meusFav']->rows as $key => $produto)
                    <article class="col-6 col-md-3">
                        <a href="{{ route('revista') }}/{{ $produto->productItem->product->id }}/{{ str_replace(' ', '-', $produto->productItem->product->title) }}/{{ $produto->productItem->id }}" alt="{{ $produto->productItem->title }} - {{ $produto->productItem->brief }}" class="tiraUnderline">
                            @if($produto->productItem->cover == null)
                                <img class="img-fluid sombrita arredonda-imagem" src="{{ $produto->productItem->product->cover }}" alt="{{ $produto->productItem->title }} - {{ $produto->productItem->brief }}" width="100%" height="auto">
                            @else
                                <img class="img-fluid sombrita arredonda-imagem" src="{{ $produto->productItem->cover }}" alt="{{ $produto->productItem->title }} - {{ $produto->productItem->brief }}" width="100%" height="auto">
                            @endif
                            <h1 class="colecaoRound">
                                {{ $produto->productItem->title }}
                            </h1>
                            <p style="display: none !important;">{{ $produto->productItem->brief }}</p>
                        </a>
                    </article>
                @endforeach

            @endif
        </div>
    </div>-->

    <!-- TAB Minha conta -->
    <div class="tab-pane fade show" id="minhaconta" role="tabpanel" aria-labelledby="minhaconta-tab">
        <div class="row" style="margin-bottom: 30px;">
            <div class="col-sm-12">
                <h1>{{__("messages.MinhaContaBladeDados")}}</h1>
            </div>
            <form method="POST" action="{{ route('attcadastro') }}" enctype="multipart/form-data">
            @csrf
                <div class="row">
                    <div class="col-sm-6 mb-3">
                        <label for="nome" class="form-label">{{__("messages.MinhaContaBladeName")}}</label>
                        <input type="text" name="nome" class="form-control" id="NomeLabel" aria-describedby="nome" value="{{ session()->get('usuario')->fullName }}">
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="email" class="form-label">{{__("messages.MinhaContaBladeEmail")}}</label>
                        <input type="email" name="email" class="form-control" id="email" aria-describedby="email" value="{{ session()->get('usuario')->email }}">
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="cpf" class="form-label">{{__("messages.MinhaContaBladeCpf")}}</label>
                        <input type="text" name="cpf" class="form-control" id="cpf" aria-describedby="cpf" value="{{ session()->get('usuario')->documentNumber }}">
                    </div>
                    <div class="col-sm-6 mb-3">
                        <div class="row">
                            <label for="telefone" class="form-label">{{__("messages.MinhaContaBladePhone")}}</label>
                            <div class="col-md-3">
                                <?php
                                $telefone = explode(' ', session()->get('usuario')->phoneNumber);
                                $numeroDDI = str_replace(' ', '', $telefone[0]);
                                $numeroDDI = str_replace('+', '', $numeroDDI);
                                $numeroDDI = str_replace('-', '', $numeroDDI);

                                $numeroT = '';
                                foreach($telefone as $key => $value){ 
                                    if ($key == 0){

                                    }else{ 
                                        $numeroT.= $value;
                                    } 
                                }
                                $numeroT = str_replace(' ', '', $numeroT);

                                ?>
                              <select class="form-select" name="ddi" id="InputDDI" aria-describedby="validationServer04Feedback" required>
                                <option selected disabled value="">{{__("messages.MinhaContaBladeSelecione")}}</option>
                                <option data-countryCode="BR" value="55" @if($numeroDDI == 55) selected @endif>Brasil (+55)</option>
                                <option data-countryCode="PT" value="351" @if($numeroDDI == 351) selected @endif>Portugal (+351)</option>
                                <option data-countryCode="PE" value="51" @if($numeroDDI == 51) selected @endif>Peru (+51)</option>
                                <option data-countryCode="GQ" value="240" @if($numeroDDI == 240) selected @endif>Equatorial Guinea (+240)</option>
                                <option data-countryCode="CL" value="56" @if($numeroDDI == 56) selected @endif>Chile (+56)</option>
                                <option data-countryCode="US" value="1" @if($numeroDDI == 1) selected @endif>USA (+1)</option>
                                <option data-countryCode="DZ" value="213" @if($numeroDDI == 213) selected @endif>Algeria (+213)</option>
                                <option data-countryCode="AD" value="376" @if($numeroDDI == 376) selected @endif>Andorra (+376)</option>
                                <option data-countryCode="AO" value="244" @if($numeroDDI == 244) selected @endif>Angola (+244)</option>
                                <option data-countryCode="AI" value="1264" @if($numeroDDI == 1264) selected @endif>Anguilla (+1264)</option>
                                <option data-countryCode="AG" value="1268" @if($numeroDDI == 1268) selected @endif>Antigua &amp; Barbuda (+1268)</option>
                                <option data-countryCode="AR" value="54" @if($numeroDDI == 54) selected @endif>Argentina (+54)</option>
                                <option data-countryCode="AM" value="374" @if($numeroDDI == 374) selected @endif>Armenia (+374)</option>
                                <option data-countryCode="AW" value="297" @if($numeroDDI == 297) selected @endif>Aruba (+297)</option>
                                <option data-countryCode="AU" value="61" @if($numeroDDI == 61) selected @endif>Australia (+61)</option>
                                <option data-countryCode="AT" value="43" @if($numeroDDI == 43) selected @endif>Austria (+43)</option>
                                <option data-countryCode="AZ" value="994" @if($numeroDDI == 994) selected @endif>Azerbaijan (+994)</option>
                                <option data-countryCode="BS" value="1242" @if($numeroDDI == 1242) selected @endif>Bahamas (+1242)</option>
                                <option data-countryCode="BH" value="973" @if($numeroDDI == 973) selected @endif>Bahrain (+973)</option>
                                <option data-countryCode="BD" value="880" @if($numeroDDI == 880) selected @endif>Bangladesh (+880)</option>
                                <option data-countryCode="BB" value="1246" @if($numeroDDI == 1246) selected @endif>Barbados (+1246)</option>
                                <option data-countryCode="BY" value="375" @if($numeroDDI == 375) selected @endif>Belarus (+375)</option>
                                <option data-countryCode="BE" value="32" @if($numeroDDI == 32) selected @endif>Belgium (+32)</option>
                                <option data-countryCode="BZ" value="501" @if($numeroDDI == 501) selected @endif>Belize (+501)</option>
                                <option data-countryCode="BJ" value="229" @if($numeroDDI == 229) selected @endif>Benin (+229)</option>
                                <option data-countryCode="BM" value="1441" @if($numeroDDI == 1441) selected @endif>Bermuda (+1441)</option>
                                <option data-countryCode="BT" value="975" @if($numeroDDI == 975) selected @endif>Bhutan (+975)</option>
                                <option data-countryCode="BO" value="591" @if($numeroDDI == 591) selected @endif>Bolivia (+591)</option>
                                <option data-countryCode="BA" value="387" @if($numeroDDI == 387) selected @endif>Bosnia Herzegovina (+387)</option>
                                <option data-countryCode="BW" value="267" @if($numeroDDI == 267) selected @endif>Botswana (+267)</option>
                                <option data-countryCode="BN" value="673" @if($numeroDDI == 673) selected @endif>Brunei (+673)</option>
                                <option data-countryCode="BG" value="359" @if($numeroDDI == 359) selected @endif>Bulgaria (+359)</option>
                                <option data-countryCode="BF" value="226" @if($numeroDDI == 226) selected @endif>Burkina Faso (+226)</option>
                                <option data-countryCode="BI" value="257" @if($numeroDDI == 257) selected @endif>Burundi (+257)</option>
                                <option data-countryCode="KH" value="855" @if($numeroDDI == 855) selected @endif>Cambodia (+855)</option>
                                <option data-countryCode="CM" value="237" @if($numeroDDI == 237) selected @endif>Cameroon (+237)</option>
                                <option data-countryCode="CA" value="1" @if($numeroDDI == 1) selected @endif>Canada (+1)</option>
                                <option data-countryCode="CV" value="238" @if($numeroDDI == 238) selected @endif>Cape Verde Islands (+238)</option>
                                <option data-countryCode="KY" value="1345" @if($numeroDDI == 1345) selected @endif>Cayman Islands (+1345)</option>
                                <option data-countryCode="CF" value="236" @if($numeroDDI == 236) selected @endif>Central African Republic (+236)</option>
                                <option data-countryCode="CN" value="86" @if($numeroDDI == 86) selected @endif>China (+86)</option>
                                <option data-countryCode="CO" value="57" @if($numeroDDI == 57) selected @endif>Colombia (+57)</option>
                                <option data-countryCode="KM" value="269" @if($numeroDDI == 269) selected @endif>Comoros (+269)</option>
                                <option data-countryCode="CG" value="242" @if($numeroDDI == 242) selected @endif>Congo (+242)</option>
                                <option data-countryCode="CK" value="682" @if($numeroDDI == 682) selected @endif>Cook Islands (+682)</option>
                                <option data-countryCode="CR" value="506" @if($numeroDDI == 506) selected @endif>Costa Rica (+506)</option>
                                <option data-countryCode="HR" value="385" @if($numeroDDI == 385) selected @endif>Croatia (+385)</option>
                                <option data-countryCode="CU" value="53" @if($numeroDDI == 53) selected @endif>Cuba (+53)</option>
                                <option data-countryCode="CY" value="90392" @if($numeroDDI == 90392) selected @endif>Cyprus North (+90392)</option>
                                <option data-countryCode="CY" value="357" @if($numeroDDI == 357) selected @endif>Cyprus South (+357)</option>
                                <option data-countryCode="CZ" value="42" @if($numeroDDI == 42) selected @endif>Czech Republic (+42)</option>
                                <option data-countryCode="DK" value="45" @if($numeroDDI == 45) selected @endif>Denmark (+45)</option>
                                <option data-countryCode="DJ" value="253" @if($numeroDDI == 253) selected @endif>Djibouti (+253)</option>
                                <option data-countryCode="DM" value="1809" @if($numeroDDI == 1809) selected @endif>Dominica (+1809)</option>
                                <option data-countryCode="DO" value="1809" @if($numeroDDI == 1809) selected @endif>Dominican Republic (+1809)</option>
                                <option data-countryCode="EC" value="593" @if($numeroDDI == 593) selected @endif>Ecuador (+593)</option>
                                <option data-countryCode="EG" value="20" @if($numeroDDI == 20) selected @endif>Egypt (+20)</option>
                                <option data-countryCode="SV" value="503" @if($numeroDDI == 503) selected @endif>El Salvador (+503)</option>
                                <option data-countryCode="ER" value="291" @if($numeroDDI == 291) selected @endif>Eritrea (+291)</option>
                                <option data-countryCode="EE" value="372" @if($numeroDDI == 372) selected @endif>Estonia (+372)</option>
                                <option data-countryCode="ET" value="251" @if($numeroDDI == 251) selected @endif>Ethiopia (+251)</option>
                                <option data-countryCode="FK" value="500" @if($numeroDDI == 500) selected @endif>Falkland Islands (+500)</option>
                                <option data-countryCode="FO" value="298" @if($numeroDDI == 298) selected @endif>Faroe Islands (+298)</option>
                                <option data-countryCode="FJ" value="679" @if($numeroDDI == 679) selected @endif>Fiji (+679)</option>
                                <option data-countryCode="FI" value="358" @if($numeroDDI == 358) selected @endif>Finland (+358)</option>
                                <option data-countryCode="FR" value="33" @if($numeroDDI == 33) selected @endif>France (+33)</option>
                                <option data-countryCode="GF" value="594" @if($numeroDDI == 594) selected @endif>French Guiana (+594)</option>
                                <option data-countryCode="PF" value="689" @if($numeroDDI == 689) selected @endif>French Polynesia (+689)</option>
                                <option data-countryCode="GA" value="241" @if($numeroDDI == 241) selected @endif>Gabon (+241)</option>
                                <option data-countryCode="GM" value="220" @if($numeroDDI == 220) selected @endif>Gambia (+220)</option>
                                <option data-countryCode="GE" value="7880" @if($numeroDDI == 7880) selected @endif>Georgia (+7880)</option>
                                <option data-countryCode="DE" value="49" @if($numeroDDI == 49) selected @endif>Germany (+49)</option>
                                <option data-countryCode="GH" value="233" @if($numeroDDI == 233) selected @endif>Ghana (+233)</option>
                                <option data-countryCode="GI" value="350" @if($numeroDDI == 350) selected @endif>Gibraltar (+350)</option>
                                <option data-countryCode="GR" value="30" @if($numeroDDI == 30) selected @endif>Greece (+30)</option>
                                <option data-countryCode="GL" value="299" @if($numeroDDI == 299) selected @endif>Greenland (+299)</option>
                                <option data-countryCode="GD" value="1473" @if($numeroDDI == 1473) selected @endif>Grenada (+1473)</option>
                                <option data-countryCode="GP" value="590" @if($numeroDDI == 590) selected @endif>Guadeloupe (+590)</option>
                                <option data-countryCode="GU" value="671" @if($numeroDDI == 671) selected @endif>Guam (+671)</option>
                                <option data-countryCode="GT" value="502" @if($numeroDDI == 502) selected @endif>Guatemala (+502)</option>
                                <option data-countryCode="GN" value="224" @if($numeroDDI == 224) selected @endif>Guinea (+224)</option>
                                <option data-countryCode="GW" value="245" @if($numeroDDI == 245) selected @endif>Guinea - Bissau (+245)</option>
                                <option data-countryCode="GY" value="592" @if($numeroDDI == 592) selected @endif>Guyana (+592)</option>
                                <option data-countryCode="HT" value="509" @if($numeroDDI == 509) selected @endif>Haiti (+509)</option>
                                <option data-countryCode="HN" value="504" @if($numeroDDI == 504) selected @endif>Honduras (+504)</option>
                                <option data-countryCode="HK" value="852" @if($numeroDDI == 852) selected @endif>Hong Kong (+852)</option>
                                <option data-countryCode="HU" value="36" @if($numeroDDI == 36) selected @endif>Hungary (+36)</option>
                                <option data-countryCode="IS" value="354" @if($numeroDDI == 354) selected @endif>Iceland (+354)</option>
                                <option data-countryCode="IN" value="91" @if($numeroDDI == 91) selected @endif>India (+91)</option>
                                <option data-countryCode="ID" value="62" @if($numeroDDI == 62) selected @endif>Indonesia (+62)</option>
                                <option data-countryCode="IR" value="98" @if($numeroDDI == 98) selected @endif>Iran (+98)</option>
                                <option data-countryCode="IQ" value="964" @if($numeroDDI == 964) selected @endif>Iraq (+964)</option>
                                <option data-countryCode="IE" value="353" @if($numeroDDI == 353) selected @endif>Ireland (+353)</option>
                                <option data-countryCode="IL" value="972" @if($numeroDDI == 972) selected @endif>Israel (+972)</option>
                                <option data-countryCode="IT" value="39" @if($numeroDDI == 39) selected @endif>Italy (+39)</option>
                                <option data-countryCode="JM" value="1876" @if($numeroDDI == 1876) selected @endif>Jamaica (+1876)</option>
                                <option data-countryCode="JP" value="81" @if($numeroDDI == 81) selected @endif>Japan (+81)</option>
                                <option data-countryCode="JO" value="962" @if($numeroDDI == 962) selected @endif>Jordan (+962)</option>
                                <option data-countryCode="KZ" value="7" @if($numeroDDI == 7) selected @endif>Kazakhstan (+7)</option>
                                <option data-countryCode="KE" value="254" @if($numeroDDI == 254) selected @endif>Kenya (+254)</option>
                                <option data-countryCode="KI" value="686" @if($numeroDDI == 686) selected @endif>Kiribati (+686)</option>
                                <option data-countryCode="KP" value="850" @if($numeroDDI == 686) selected @endif>Korea North (+850)</option>
                                <option data-countryCode="KR" value="82" @if($numeroDDI == 82) selected @endif>Korea South (+82)</option>
                                <option data-countryCode="KW" value="965" @if($numeroDDI == 965) selected @endif>Kuwait (+965)</option>
                                <option data-countryCode="KG" value="996" @if($numeroDDI == 996) selected @endif>Kyrgyzstan (+996)</option>
                                <option data-countryCode="LA" value="856" @if($numeroDDI == 856) selected @endif>Laos (+856)</option>
                                <option data-countryCode="LV" value="371" @if($numeroDDI == 371) selected @endif>Latvia (+371)</option>
                                <option data-countryCode="LB" value="961" @if($numeroDDI == 961) selected @endif>Lebanon (+961)</option>
                                <option data-countryCode="LS" value="266" @if($numeroDDI == 266) selected @endif>Lesotho (+266)</option>
                                <option data-countryCode="LR" value="231" @if($numeroDDI == 231) selected @endif>Liberia (+231)</option>
                                <option data-countryCode="LY" value="218" @if($numeroDDI == 218) selected @endif>Libya (+218)</option>
                                <option data-countryCode="LI" value="417" @if($numeroDDI == 417) selected @endif>Liechtenstein (+417)</option>
                                <option data-countryCode="LT" value="370" @if($numeroDDI == 370) selected @endif>Lithuania (+370)</option>
                                <option data-countryCode="LU" value="352" @if($numeroDDI == 352) selected @endif>Luxembourg (+352)</option>
                                <option data-countryCode="MO" value="853" @if($numeroDDI == 853) selected @endif>Macao (+853)</option>
                                <option data-countryCode="MK" value="389" @if($numeroDDI == 389) selected @endif>Macedonia (+389)</option>
                                <option data-countryCode="MG" value="261" @if($numeroDDI == 261) selected @endif>Madagascar (+261)</option>
                                <option data-countryCode="MW" value="265" @if($numeroDDI == 265) selected @endif>Malawi (+265)</option>
                                <option data-countryCode="MY" value="60" @if($numeroDDI == 60) selected @endif>Malaysia (+60)</option>
                                <option data-countryCode="MV" value="960" @if($numeroDDI == 960) selected @endif>Maldives (+960)</option>
                                <option data-countryCode="ML" value="223" @if($numeroDDI == 223) selected @endif>Mali (+223)</option>
                                <option data-countryCode="MT" value="356" @if($numeroDDI == 356) selected @endif>Malta (+356)</option>
                                <option data-countryCode="MH" value="692" @if($numeroDDI == 692) selected @endif>Marshall Islands (+692)</option>
                                <option data-countryCode="MQ" value="596" @if($numeroDDI == 596) selected @endif>Martinique (+596)</option>
                                <option data-countryCode="MR" value="222" @if($numeroDDI == 222) selected @endif>Mauritania (+222)</option>
                                <option data-countryCode="YT" value="269" @if($numeroDDI == 269) selected @endif>Mayotte (+269)</option>
                                <option data-countryCode="MX" value="52" @if($numeroDDI == 52) selected @endif>Mexico (+52)</option>
                                <option data-countryCode="FM" value="691" @if($numeroDDI == 691) selected @endif>Micronesia (+691)</option>
                                <option data-countryCode="MD" value="373" @if($numeroDDI == 373) selected @endif>Moldova (+373)</option>
                                <option data-countryCode="MC" value="377" @if($numeroDDI == 377) selected @endif>Monaco (+377)</option>
                                <option data-countryCode="MN" value="976" @if($numeroDDI == 976) selected @endif>Mongolia (+976)</option>
                                <option data-countryCode="MS" value="1664" @if($numeroDDI == 1664) selected @endif>Montserrat (+1664)</option>
                                <option data-countryCode="MA" value="212" @if($numeroDDI == 212) selected @endif>Morocco (+212)</option>
                                <option data-countryCode="MZ" value="258" @if($numeroDDI == 258) selected @endif>Mozambique (+258)</option>
                                <option data-countryCode="MN" value="95" @if($numeroDDI == 95) selected @endif>Myanmar (+95)</option>
                                <option data-countryCode="NA" value="264" @if($numeroDDI == 264) selected @endif>Namibia (+264)</option>
                                <option data-countryCode="NR" value="674" @if($numeroDDI == 674) selected @endif>Nauru (+674)</option>
                                <option data-countryCode="NP" value="977" @if($numeroDDI == 977) selected @endif>Nepal (+977)</option>
                                <option data-countryCode="NL" value="31" @if($numeroDDI == 31) selected @endif>Netherlands (+31)</option>
                                <option data-countryCode="NC" value="687" @if($numeroDDI == 687) selected @endif>New Caledonia (+687)</option>
                                <option data-countryCode="NZ" value="64" @if($numeroDDI == 64) selected @endif>New Zealand (+64)</option>
                                <option data-countryCode="NI" value="505" @if($numeroDDI == 505) selected @endif>Nicaragua (+505)</option>
                                <option data-countryCode="NE" value="227" @if($numeroDDI == 227) selected @endif>Niger (+227)</option>
                                <option data-countryCode="NG" value="234" @if($numeroDDI == 234) selected @endif>Nigeria (+234)</option>
                                <option data-countryCode="NU" value="683" @if($numeroDDI == 683) selected @endif>Niue (+683)</option>
                                <option data-countryCode="NF" value="672" @if($numeroDDI == 672) selected @endif>Norfolk Islands (+672)</option>
                                <option data-countryCode="NP" value="670" @if($numeroDDI == 670) selected @endif>Northern Marianas (+670)</option>
                                <option data-countryCode="NO" value="47" @if($numeroDDI == 47) selected @endif>Norway (+47)</option>
                                <option data-countryCode="OM" value="968" @if($numeroDDI == 968) selected @endif>Oman (+968)</option>
                                <option data-countryCode="PW" value="680" @if($numeroDDI == 680) selected @endif>Palau (+680)</option>
                                <option data-countryCode="PA" value="507" @if($numeroDDI == 507) selected @endif>Panama (+507)</option>
                                <option data-countryCode="PG" value="675" @if($numeroDDI == 675) selected @endif>Papua New Guinea (+675)</option>
                                <option data-countryCode="PY" value="595" @if($numeroDDI == 595) selected @endif>Paraguay (+595)</option>
                                <option data-countryCode="PH" value="63" @if($numeroDDI == 63) selected @endif>Philippines (+63)</option>
                                <option data-countryCode="PL" value="48" @if($numeroDDI == 48) selected @endif>Poland (+48)</option>
                                <option data-countryCode="PR" value="1787" @if($numeroDDI == 1787) selected @endif>Puerto Rico (+1787)</option>
                                <option data-countryCode="QA" value="974" @if($numeroDDI == 974) selected @endif>Qatar (+974)</option>
                                <option data-countryCode="RE" value="262" @if($numeroDDI == 262) selected @endif>Reunion (+262)</option>
                                <option data-countryCode="RO" value="40" @if($numeroDDI == 40) selected @endif>Romania (+40)</option>
                                <option data-countryCode="RU" value="7" @if($numeroDDI == 7) selected @endif>Russia (+7)</option>
                                <option data-countryCode="RW" value="250" @if($numeroDDI == 250) selected @endif>Rwanda (+250)</option>
                                <option data-countryCode="SM" value="378" @if($numeroDDI == 378) selected @endif>San Marino (+378)</option>
                                <option data-countryCode="ST" value="239" @if($numeroDDI == 239) selected @endif>Sao Tome &amp; Principe (+239)</option>
                                <option data-countryCode="SA" value="966" @if($numeroDDI == 966) selected @endif>Saudi Arabia (+966)</option>
                                <option data-countryCode="SN" value="221" @if($numeroDDI == 221) selected @endif>Senegal (+221)</option>
                                <option data-countryCode="CS" value="381" @if($numeroDDI == 381) selected @endif>Serbia (+381)</option>
                                <option data-countryCode="SC" value="248" @if($numeroDDI == 248) selected @endif>Seychelles (+248)</option>
                                <option data-countryCode="SL" value="232" @if($numeroDDI == 232) selected @endif>Sierra Leone (+232)</option>
                                <option data-countryCode="SG" value="65" @if($numeroDDI == 65) selected @endif>Singapore (+65)</option>
                                <option data-countryCode="SK" value="421" @if($numeroDDI == 421) selected @endif>Slovak Republic (+421)</option>
                                <option data-countryCode="SI" value="386" @if($numeroDDI == 386) selected @endif>Slovenia (+386)</option>
                                <option data-countryCode="SB" value="677" @if($numeroDDI == 677) selected @endif>Solomon Islands (+677)</option>
                                <option data-countryCode="SO" value="252" @if($numeroDDI == 252) selected @endif>Somalia (+252)</option>
                                <option data-countryCode="ZA" value="27" @if($numeroDDI == 27) selected @endif>South Africa (+27)</option>
                                <option data-countryCode="ES" value="34" @if($numeroDDI == 34) selected @endif>Spain (+34)</option>
                                <option data-countryCode="LK" value="94" @if($numeroDDI == 94) selected @endif>Sri Lanka (+94)</option>
                                <option data-countryCode="SH" value="290" @if($numeroDDI == 290) selected @endif>St. Helena (+290)</option>
                                <option data-countryCode="KN" value="1869" @if($numeroDDI == 1869) selected @endif>St. Kitts (+1869)</option>
                                <option data-countryCode="SC" value="1758" @if($numeroDDI == 1758) selected @endif>St. Lucia (+1758)</option>
                                <option data-countryCode="SD" value="249" @if($numeroDDI == 249) selected @endif>Sudan (+249)</option>
                                <option data-countryCode="SR" value="597" @if($numeroDDI == 597) selected @endif>Suriname (+597)</option>
                                <option data-countryCode="SZ" value="268" @if($numeroDDI == 268) selected @endif>Swaziland (+268)</option>
                                <option data-countryCode="SE" value="46" @if($numeroDDI == 46) selected @endif>Sweden (+46)</option>
                                <option data-countryCode="CH" value="41" @if($numeroDDI == 41) selected @endif>Switzerland (+41)</option>
                                <option data-countryCode="SI" value="963" @if($numeroDDI == 963) selected @endif>Syria (+963)</option>
                                <option data-countryCode="TW" value="886" @if($numeroDDI == 886) selected @endif>Taiwan (+886)</option>
                                <option data-countryCode="TJ" value="7" @if($numeroDDI == 7) selected @endif>Tajikstan (+7)</option>
                                <option data-countryCode="TH" value="66" @if($numeroDDI == 66) selected @endif>Thailand (+66)</option>
                                <option data-countryCode="TG" value="228" @if($numeroDDI == 228) selected @endif>Togo (+228)</option>
                                <option data-countryCode="TO" value="676" @if($numeroDDI == 676) selected @endif>Tonga (+676)</option>
                                <option data-countryCode="TT" value="1868" @if($numeroDDI == 1868) selected @endif>Trinidad &amp; Tobago (+1868)</option>
                                <option data-countryCode="TN" value="216" @if($numeroDDI == 216) selected @endif>Tunisia (+216)</option>
                                <option data-countryCode="TR" value="90" @if($numeroDDI == 90) selected @endif>Turkey (+90)</option>
                                <option data-countryCode="TM" value="7" @if($numeroDDI == 7) selected @endif>Turkmenistan (+7)</option>
                                <option data-countryCode="TM" value="993" @if($numeroDDI == 993) selected @endif>Turkmenistan (+993)</option>
                                <option data-countryCode="TC" value="1649" @if($numeroDDI == 1649) selected @endif>Turks &amp; Caicos Islands (+1649)</option>
                                <option data-countryCode="TV" value="688" @if($numeroDDI == 688) selected @endif>Tuvalu (+688)</option>
                                <option data-countryCode="UG" value="256" @if($numeroDDI == 256) selected @endif>Uganda (+256)</option>
                                <option data-countryCode="GB" value="44" @if($numeroDDI == 44) selected @endif>UK (+44)</option>
                                <option data-countryCode="UA" value="380" @if($numeroDDI == 380) selected @endif>Ukraine (+380)</option>
                                <option data-countryCode="AE" value="971" @if($numeroDDI == 971) selected @endif>United Arab Emirates (+971)</option>
                                <option data-countryCode="UY" value="598" @if($numeroDDI == 598) selected @endif>Uruguay (+598)</option>
                                <option data-countryCode="UZ" value="7" @if($numeroDDI == 7) selected @endif>Uzbekistan (+7)</option>
                                <option data-countryCode="VU" value="678" @if($numeroDDI == 678) selected @endif>Vanuatu (+678)</option>
                                <option data-countryCode="VA" value="379" @if($numeroDDI == 379) selected @endif>Vatican City (+379)</option>
                                <option data-countryCode="VE" value="58" @if($numeroDDI == 58) selected @endif>Venezuela (+58)</option>
                                <option data-countryCode="VN" value="84" @if($numeroDDI == 84) selected @endif>Vietnam (+84)</option>
                                <option data-countryCode="VG" value="84" @if($numeroDDI == 84) selected @endif>Virgin Islands - British (+1284)</option>
                                <option data-countryCode="VI" value="84" @if($numeroDDI == 84) selected @endif>Virgin Islands - US (+1340)</option>
                                <option data-countryCode="WF" value="681" @if($numeroDDI == 681) selected @endif>Wallis &amp; Futuna (+681)</option>
                                <option data-countryCode="YE" value="969" @if($numeroDDI == 969) selected @endif>Yemen (North)(+969)</option>
                                <option data-countryCode="YE" value="967" @if($numeroDDI == 967) selected @endif>Yemen (South)(+967)</option>
                                <option data-countryCode="ZM" value="260" @if($numeroDDI == 260) selected @endif>Zambia (+260)</option>
                                <option data-countryCode="ZW" value="263" @if($numeroDDI == 263) selected @endif>Zimbabwe (+263)</option>
                              </select>
                            </div>
                            <div class="col-md-9">
                                <input type="tel" name="telefone" class="form-control" id="InputTelefone" aria-describedby="yourPhone" value="{{ $numeroT }}" required>
                                <div id="yourPhone" class="form-text">{{__("messages.MinhaContaBladeDdd")}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <input type="submit" value="{{__("messages.MinhaContaBladeAtualizar")}}" class="form-control btn btn-danger dropdown-toggle botaoLogar">
                    </div>
                </div>
            </form>
        </div>
        @if($numeroDDI == 55)
            <hr/>
            <div class="row">
                <div class="col-sm-12">
                    <h1>{{__("messages.MinhaContaBladeSeuEnd")}}</h1>
                </div>
                <div class="co-sm-12">
                    <form method="POST" action="{{ route('attendereco') }}" enctype="multipart/form-data">
                    @csrf
                        <div class="row">
                            <div class="col-sm-5 mb-3">
                                <label for="cep" class="form-label">{{__("messages.MinhaContaBladeCep")}}</label>
                                <input type="text"  id="cep" maxlength="9" placeholder="13483-000" autofocus name="cep" class="form-control" aria-describedby="cep" @if(isset($minhaconta['endereco']->zipCode))  value="{{ $minhaconta['endereco']->zipCode }}" @endif>
                            </div> 

                            <div class="col-sm-5 mb-3">
                                <label for="cidade" class="form-label">{{__("messages.MinhaContaBladeCity")}}</label>
                                <input type="text"  id="cidade" name="cidade" class="form-control" aria-describedby="cidade" @if(isset($minhaconta['endereco']->zipCode)) value="{{ $minhaconta['endereco']->city }}" @endif>
                            </div>

                            <div class="col-sm-2 mb-3">
                                <label for="uf" class="form-label">{{__("messages.MinhaContaBladeUF")}}</label>
                                <input type="text"  id="uf" name="uf" class="form-control" aria-describedby="uf" @if(isset($minhaconta['endereco']->zipCode)) value="{{ $minhaconta['endereco']->state->code }}" @endif>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-8 mb-3">
                                <label for="endereco" class="form-label">{{__("messages.MinhaContaBladeLog")}}</label>
                                <input type="text"  id="endereco" name="endereco" class="form-control" aria-describedby="endereco" @if(isset($minhaconta['endereco']->zipCode)) value="{{ $minhaconta['endereco']->street }}" @endif>
                            </div>

                            <div class="col-sm-4 mb-3">
                                <label for="numero" class="form-label">{{__("messages.MinhaContaBladeNum")}}</label>
                                <input type="text"  id="numero" name="numero" class="form-control" aria-describedby="numero" @if(isset($minhaconta['endereco']->zipCode)) value="{{ $minhaconta['endereco']->number }}" @endif>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-8 mb-3">
                                <label for="bairro" class="form-label">{{__("messages.MinhaContaBladeBairro")}}</label>
                                <input type="text"  id="bairro" name="bairro" class="form-control" aria-describedby="bairro" @if(isset($minhaconta['endereco']->zipCode)) value="{{ $minhaconta['endereco']->neighborhood }}" @endif>
                            </div>

                            <div class="col-sm-4 mb-3">
                                <label for="complemento" class="form-label">{{__("messages.MinhaContaBladeComplemento")}}</label>
                                <input type="text"  id="complemento" name="complemento" class="form-control" aria-describedby="complemento" @if(isset($minhaconta['endereco']->zipCode)) value="{{ $minhaconta['endereco']->complement }}" @endif>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <input type="submit" value="{{__("messages.MinhaContaBladeAtualizar")}}" class="form-control btn btn-danger dropdown-toggle botaoLogar">
                            </div>
                        </div>
                    </form>
                    <script src="https://code.jquery.com/jquery-3.0.0.min.js"></script>
                    <script>
                        /*
                         * Para efeito de demonstração, o JavaScript foi
                         * incorporado no arquivo HTML.
                         * O ideal é que você faça em um arquivo ".js" separado. Para mais informações
                         * visite o endereço https://developer.yahoo.com/performance/rules.html#external
                         */
                        
                        // Registra o evento blur do campo "cep", ou seja, a pesquisa será feita
                        // quando o usuário sair do campo "cep"
                        $("#cep").blur(function(){
                            // Remove tudo o que não é número para fazer a pesquisa
                            var cep = this.value.replace(/[^0-9]/, "");
                            
                            // Validação do CEP; caso o CEP não possua 8 números, então cancela
                            // a consulta
                            if(cep.length != 8){
                                return false;
                            }
                            
                            // A url de pesquisa consiste no endereço do webservice + o cep que
                            // o usuário informou + o tipo de retorno desejado (entre "json",
                            // "jsonp", "xml", "piped" ou "querty")
                            var url = "https://viacep.com.br/ws/"+cep+"/json/";
                            
                            // Faz a pesquisa do CEP, tratando o retorno com try/catch para que
                            // caso ocorra algum erro (o cep pode não existir, por exemplo) a
                            // usabilidade não seja afetada, assim o usuário pode continuar//
                            // preenchendo os campos normalmente
                            $.getJSON(url, function(dadosRetorno){
                                try{
                                    // Preenche os campos de acordo com o retorno da pesquisa
                                    $("#endereco").val(dadosRetorno.logradouro);
                                    $("#bairro").val(dadosRetorno.bairro);
                                    $("#cidade").val(dadosRetorno.localidade);
                                    $("#uf").val(dadosRetorno.uf);
                                }catch(ex){}
                            });
                        });
                    </script>
                </div>
            </div>
        @endif
    </div>
</div>


@endsection