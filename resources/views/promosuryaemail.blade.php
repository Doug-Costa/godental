<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('ladingpage/img/go.ico') }}">
    <title>Dental GO Surya 3 Meses</title>
    <meta name="description" content="A Maior Plataforma da conhecimento Odontológico ao seu dispor, informação e atualização com o que há de mais moderno na Odontologia...">
    <meta name="keywords" content="Conhecimento Acessivel de maneira fácil e rápida">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="{{ asset('ladingpage/css/meupedido.css') }}">
    <script src="{{ asset('ladingpage/js/navbar-ontop.js') }}"></script>
    <script src="{{ asset('ladingpage/js/animate-in.js') }}"></script>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-06LXEX0626"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-06LXEX0626');
    </script>
</head>

<body>
  <nav class="navbar navbar-expand-md fixed-top bg-dark navbar-light" style="background-color:#ffffff">
    <div class="container"> <a class="navbar-brand" href="#"><img class="img-fluid d-block" src="{{ asset('ladingpage/img/logo.png') }}" width="300" style=""></a> <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbar2SupportedContent" aria-controls="navbar2SupportedContent" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
      <div class="collapse navbar-collapse text-center justify-content-end" id="navbar2SupportedContent">
        <ul class="navbar-nav">
          <li class="nav-item mx-2"> <a class="nav-link" href="#inicio">Início</a> </li>
          <li class="nav-item mx-2"> <a class="nav-link" href="#video">Como Funciona?</a> </li>
        </ul> <a class="btn navbar-btn mx-2 btn-primary text-light" href="novocliente/"><b>Começar Agora!</b></a>
      </div>
    </div>
  </nav>
 
  <!-- Cover -->
  <div class="bg-light pt-5" id="inicio" style="	background-image: url({{ asset('ladingpage/img/bg.png') }});	background-position: center, left top;	background-size: cover, cover;	background-repeat: no-repeat, no-repeat;">
    <div class="container pt-5 pb-4">
      <div class="row">

      

        <div class="text-lg-left text-left align-self-left pt-4 col-md-6 py-3" style="">
          <h1 class="text-white"><b class="">Cadastre-se ao lado e adquira 3 meses grátis do DentalGO em parceria com a Surya</b></h1>
          <p class="text-white"><b><br></b><br>
          <img class="img-fluid" src="{{ asset('imagens/logo-joE.png') }}" alt="">
		  <br>
      
        </div>
        <div class="col-md-6" style="">

        <!--formulario-->
          <div class="container_form" id="container_form" style="padding-left:40px !important; padding-right: 40px; border-radius: 10px;">
              <!--  <h1>Ganhe sete dias grátis</h1> -->
              <form id="formCad" method="POST" action="{{ route('promosuryacad') }}" enctype="multipart/form-data">
                  @csrf
                  <div class="row">
                      <div class="mb-3" style="width:100% !important;">
                          <label for="nome" class="form-label">{{__("messages.ModCadNome")}}</label>
                          <input type="text" name="nome" class="form-control" id="InputNome" aria-describedby="yourName" required>
                      </div>
                  </div>
                  <div class="row">
                      <div class="mb-3">
                          <label for="telefone" class="form-label">{{__("messages.ModCadFone")}}</label>
                          <div class="row">
                              <div class="col-md-3">
                                  <select class="form-select" style="height:40%; width:86px;"  name="ddi" id="InputDDI" aria-describedby="validationServer04Feedback" required>
                                      <option selected disabled value="">{{__("messages.ModCadSelecione")}}</option>
                                      <option data-countryCode="BR" value="55">Brasil (+55)</option>
                                      <option data-countryCode="PT" value="351">Portugal (+351)</option>
                                      <option data-countryCode="PE" value="51">Peru (+51)</option>
                                      <option data-countryCode="GQ" value="240">Guiné Equatorial (+240)</option>
                                      <option data-countryCode="CL" value="56">Chile (+56)</option>
                                      <option data-countryCode="BO" value="591">Bolívia (+591)</option>
                                      <option data-countryCode="US" value="1">USA (+1)</option>
                                      <option data-countryCode="DZ" value="213">Argélia (+213)</option>
                                      <option data-countryCode="AD" value="376">Andorra (+376)</option>
                                      <option data-countryCode="AO" value="244">Angola (+244)</option>
                                      <option data-countryCode="AI" value="1264">Anguilla (+1264)</option>
                                      <option data-countryCode="AG" value="1268">Antigua &amp; Barbuda (+1268)</option>
                                      <option data-countryCode="AR" value="54">Argentina (+54)</option>
                                      <option data-countryCode="AM" value="374">Armênia (+374)</option>
                                      <option data-countryCode="AW" value="297">Aruba (+297)</option>
                                      <option data-countryCode="AU" value="61">Austrália (+61)</option>
                                      <option data-countryCode="AT" value="43">Áustria (+43)</option>
                                      <option data-countryCode="AZ" value="994">Azerbaijão (+994)</option>
                                      <option data-countryCode="BS" value="1242">Bahamas (+1242)</option>
                                      <option data-countryCode="BH" value="973">Bahrein (+973)</option>
                                      <option data-countryCode="BD" value="880">Bangladesh (+880)</option>
                                      <option data-countryCode="BB" value="1246">Barbados (+1246)</option>
                                      <option data-countryCode="BY" value="375">Bielorrússia (+375)</option>
                                      <option data-countryCode="BE" value="32">Bélgica (+32)</option>
                                      <option data-countryCode="BZ" value="501">Belize (+501)</option>
                                      <option data-countryCode="BJ" value="229">Benin (+229)</option>
                                      <option data-countryCode="BM" value="1441">Bermudas (+1441)</option>
                                      <option data-countryCode="BT" value="975">Butão (+975)</option>
                                      <option data-countryCode="BA" value="387">Bósnia Herzegovina (+387)</option>
                                      <option data-countryCode="BW" value="267">Botswana (+267)</option>
                                      <option data-countryCode="BN" value="673">Brunei (+673)</option>
                                      <option data-countryCode="BG" value="359">Bulgária (+359)</option>
                                      <option data-countryCode="BF" value="226">Burkina Faso (+226)</option>
                                      <option data-countryCode="BI" value="257">Burundi (+257)</option>
                                      <option data-countryCode="KH" value="855">Camboja (+855)</option>
                                      <option data-countryCode="CM" value="237">Camarões (+237)</option>
                                      <option data-countryCode="CA" value="1">Canadá (+1)</option>
                                      <option data-countryCode="CV" value="238">Cabo Verde (+238)</option>
                                      <option data-countryCode="KY" value="1345">Ilhas Cayman (+1345)</option>
                                      <option data-countryCode="CF" value="236">República Centro-Africana (+236)</option>
                                      <option data-countryCode="CN" value="86">China (+86)</option>
                                      <option data-countryCode="CO" value="57">Colômbia (+57)</option>
                                      <option data-countryCode="KM" value="269">Comores (+269)</option>
                                      <option data-countryCode="CG" value="242">Congo (+242)</option>
                                      <option data-countryCode="CK" value="682">Ilhas Cook (+682)</option>
                                      <option data-countryCode="CR" value="506">Costa Rica (+506)</option>
                                      <option data-countryCode="HR" value="385">Croácia (+385)</option>
                                      <option data-countryCode="CU" value="53">Cuba (+53)</option>
                                      <option data-countryCode="CY" value="90392">Chipre Norte (+90392)</option>
                                      <option data-countryCode="CY" value="357">Chipre Sul (+357)</option>
                                      <option data-countryCode="CZ" value="42">República Checa (+42)</option>
                                      <option data-countryCode="DK" value="45">Dinamarca (+45)</option>
                                      <option data-countryCode="DJ" value="253">Djibuti (+253)</option>
                                      <option data-countryCode="DM" value="1809">Dominica (+1809)</option>
                                      <option data-countryCode="DO" value="1809">República Dominicana (+1809)</option>
                                      <option data-countryCode="EC" value="593">Equador (+593)</option>
                                      <option data-countryCode="EG" value="20">Egito (+20)</option>
                                      <option data-countryCode="SV" value="503">El Salvador (+503)</option>
                                      <option data-countryCode="ER" value="291">Eritreia (+291)</option>
                                      <option data-countryCode="EE" value="372">Estônia (+372)</option>
                                      <option data-countryCode="ET" value="251">Etiópia (+251)</option>
                                      <option data-countryCode="FK" value="500">Ilhas Falkland (+500)</option>
                                      <option data-countryCode="FO" value="298">Ilhas Faroe (+298)</option>
                                      <option data-countryCode="FJ" value="679">Fiji (+679)</option>
                                      <option data-countryCode="FI" value="358">Finlândia (+358)</option>
                                      <option data-countryCode="FR" value="33">França (+33)</option>
                                      <option data-countryCode="GF" value="594">Guiana Francesa (+594)</option>
                                      <option data-countryCode="PF" value="689">Polinésia Francesa (+689)</option>
                                      <option data-countryCode="GA" value="241">Gabão (+241)</option>
                                      <option data-countryCode="GM" value="220">Gâmbia (+220)</option>
                                      <option data-countryCode="GE" value="7880">Geórgia (+7880)</option>
                                      <option data-countryCode="DE" value="49">Alemanha (+49)</option>
                                      <option data-countryCode="GH" value="233">Gana (+233)</option>
                                      <option data-countryCode="GI" value="350">Gibraltar (+350)</option>
                                      <option data-countryCode="GR" value="30">Grécia (+30)</option>
                                      <option data-countryCode="GL" value="299">Groenlândia (+299)</option>
                                      <option data-countryCode="GD" value="1473">Granada (+1473)</option>
                                      <option data-countryCode="GP" value="590">Guadalupe (+590)</option>
                                      <option data-countryCode="GU" value="671">Guam (+671)</option>
                                      <option data-countryCode="GT" value="502">Guatemala (+502)</option>
                                      <option data-countryCode="GN" value="224">Guiné (+224)</option>
                                      <option data-countryCode="GW" value="245">Guiné-Bissau (+245)</option>
                                      <option data-countryCode="GY" value="592">Guiana (+592)</option>
                                      <option data-countryCode="HT" value="509">Haiti (+509)</option>
                                      <option data-countryCode="HN" value="504">Honduras (+504)</option>
                                      <option data-countryCode="HK" value="852">Hong Kong (+852)</option>
                                      <option data-countryCode="HU" value="36">Hungria (+36)</option>
                                      <option data-countryCode="IS" value="354">Islândia (+354)</option>
                                      <option data-countryCode="IN" value="91">Índia (+91)</option>
                                      <option data-countryCode="ID" value="62">Indonésia (+62)</option>
                                      <option data-countryCode="IR" value="98">Irã (+98)</option>
                                      <option data-countryCode="IQ" value="964">Iraque (+964)</option>
                                      <option data-countryCode="IE" value="353">Irlanda (+353)</option>
                                      <option data-countryCode="IL" value="972">Israel (+972)</option>
                                      <option data-countryCode="IT" value="39">Itália (+39)</option>
                                      <option data-countryCode="JM" value="1876">Jamaica (+1876)</option>
                                      <option data-countryCode="JP" value="81">Japão (+81)</option>
                                      <option data-countryCode="JO" value="962">Jordânia (+962)</option>
                                      <option data-countryCode="KZ" value="7">Cazaquistão (+7)</option>
                                      <option data-countryCode="KE" value="254">Quênia (+254)</option>
                                      <option data-countryCode="KI" value="686">Kiribati (+686)</option>
                                      <option data-countryCode="KP" value="850">Coreia do Norte (+850)</option>
                                      <option data-countryCode="KR" value="82">Coreia do Sul (+82)</option>
                                      <option data-countryCode="KW" value="965">Kuwait (+965)</option>
                                      <option data-countryCode="KG" value="996">Quirguistão (+996)</option>
                                      <option data-countryCode="LA" value="856">Laos (+856)</option>
                                      <option data-countryCode="LV" value="371">Letônia (+371)</option>
                                      <option data-countryCode="LB" value="961">Líbano (+961)</option>
                                      <option data-countryCode="LS" value="266">Lesoto (+266)</option>
                                      <option data-countryCode="LR" value="231">Libéria (+231)</option>
                                      <option data-countryCode="LY" value="218">Líbia (+218)</option>
                                      <option data-countryCode="LI" value="417">Liechtenstein (+417)</option>
                                      <option data-countryCode="LT" value="370">Lituânia (+370)</option>
                                      <option data-countryCode="LU" value="352">Luxemburgo (+352)</option>
                                      <option data-countryCode="MO" value="853">Macau (+853)</option>
                                      <option data-countryCode="MK" value="389">Macedônia (+389)</option>
                                      <option data-countryCode="MG" value="261">Madagáscar (+261)</option>
                                      <option data-countryCode="MW" value="265">Malawi (+265)</option>
                                      <option data-countryCode="MY" value="60">Malásia (+60)</option>
                                      <option data-countryCode="MV" value="960">Maldivas (+960)</option>
                                      <option data-countryCode="ML" value="223">Mali (+223)</option>
                                      <option data-countryCode="MT" value="356">Malta (+356)</option>
                                      <option data-countryCode="MH" value="692">Ilhas Marshall (+692)</option>
                                      <option data-countryCode="MQ" value="596">Martinica (+596)</option>
                                      <option data-countryCode="MR" value="222">Mauritânia (+222)</option>
                                      <option data-countryCode="YT" value="269">Mayotte (+269)</option>
                                      <option data-countryCode="MX" value="52">México (+52)</option>
                                      <option data-countryCode="FM" value="691">Micronésia (+691)</option>
                                      <option data-countryCode="MD" value="373">Moldova (+373)</option>
                                      <option data-countryCode="MC" value="377">Mônaco (+377)</option>
                                      <option data-countryCode="MN" value="976">Mongólia (+976)</option>
                                      <option data-countryCode="MS" value="1664">Montserrat (+1664)</option>
                                      <option data-countryCode="MA" value="212">Marrocos (+212)</option>
                                      <option data-countryCode="MZ" value="258">Moçambique (+258)</option>
                                      <option data-countryCode="MM" value="95">Mianmar (+95)</option>
                                      <option data-countryCode="NA" value="264">Namíbia (+264)</option>
                                      <option data-countryCode="NR" value="674">Nauru (+674)</option>
                                      <option data-countryCode="NP" value="977">Nepal (+977)</option>
                                      <option data-countryCode="NL" value="31">Holanda (+31)</option>
                                      <option data-countryCode="NC" value="687">Nova Caledônia (+687)</option>
                                      <option data-countryCode="NZ" value="64">Nova Zelândia (+64)</option>
                                      <option data-countryCode="NI" value="505">Nicarágua (+505)</option>
                                      <option data-countryCode="NE" value="227">Níger (+227)</option>
                                      <option data-countryCode="NG" value="234">Nigéria (+234)</option>
                                      <option data-countryCode="NU" value="683">Niue (+683)</option>
                                      <option data-countryCode="NF" value="672">Ilhas Norfolk (+672)</option>
                                      <option data-countryCode="NP" value="670">Ilhas Marianas do Norte (+670)</option>
                                      <option data-countryCode="NO" value="47">Noruega (+47)</option>
                                      <option data-countryCode="OM" value="968">Omã (+968)</option>
                                      <option data-countryCode="PW" value="680">Palau (+680)</option>
                                      <option data-countryCode="PA" value="507">Panamá (+507)</option>
                                      <option data-countryCode="PG" value="675">Papua Nova Guiné (+675)</option>
                                      <option data-countryCode="PY" value="595">Paraguai (+595)</option>
                                      <option data-countryCode="PH" value="63">Filipinas (+63)</option>
                                      <option data-countryCode="PL" value="48">Polônia (+48)</option>
                                      <option data-countryCode="PR" value="1787">Porto Rico (+1787)</option>
                                      <option data-countryCode="QA" value="974">Catar (+974)</option>
                                      <option data-countryCode="RE" value="262">Reunião (+262)</option>
                                      <option data-countryCode="RO" value="40">Romênia (+40)</option>
                                      <option data-countryCode="RU" value="7">Rússia (+7)</option>
                                      <option data-countryCode="RW" value="250">Ruanda (+250)</option>
                                      <option data-countryCode="SM" value="378">San Marino (+378)</option>
                                      <option data-countryCode="ST" value="239">São Tomé e Príncipe (+239)</option>
                                      <option data-countryCode="SA" value="966">Arábia Saudita (+966)</option>
                                      <option data-countryCode="SN" value="221">Senegal (+221)</option>
                                      <option data-countryCode="CS" value="381">Sérvia (+381)</option>
                                      <option data-countryCode="SC" value="248">Seychelles (+248)</option>
                                      <option data-countryCode="SL" value="232">Serra Leoa (+232)</option>
                                      <option data-countryCode="SG" value="65">Singapura (+65)</option>
                                      <option data-countryCode="SK" value="421">Eslováquia (+421)</option>
                                      <option data-countryCode="SI" value="386">Eslovênia (+386)</option>
                                      <option data-countryCode="SB" value="677">Ilhas Salomão (+677)</option>
                                      <option data-countryCode="SO" value="252">Somália (+252)</option>
                                      <option data-countryCode="ZA" value="27">África do Sul (+27)</option>
                                      <option data-countryCode="ES" value="34">Espanha (+34)</option>
                                      <option data-countryCode="LK" value="94">Sri Lanka (+94)</option>
                                      <option data-countryCode="SH" value="290">Santa Helena (+290)</option>
                                      <option data-countryCode="KN" value="1869">São Cristóvão (+1869)</option>
                                      <option data-countryCode="LC" value="1758">Santa Lúcia (+1758)</option>
                                      <option data-countryCode="SD" value="249">Sudão (+249)</option>
                                      <option data-countryCode="SR" value="597">Suriname (+597)</option>
                                      <option data-countryCode="SZ" value="268">Suazilândia (+268)</option>
                                      <option data-countryCode="SE" value="46">Suécia (+46)</option>
                                      <option data-countryCode="CH" value="41">Suíça (+41)</option>
                                      <option data-countryCode="SY" value="963">Síria (+963)</option>
                                      <option data-countryCode="TW" value="886">Taiwan (+886)</option>
                                      <option data-countryCode="TJ" value="7">Tadjiquistão (+7)</option>
                                      <option data-countryCode="TH" value="66">Tailândia (+66)</option>
                                      <option data-countryCode="TG" value="228">Togo (+228)</option>
                                      <option data-countryCode="TO" value="676">Tonga (+676)</option>
                                      <option data-countryCode="TT" value="1868">Trinidad &amp; Tobago (+1868)</option>
                                      <option data-countryCode="TN" value="216">Tunísia (+216)</option>
                                      <option data-countryCode="TR" value="90">Turquia (+90)</option>
                                      <option data-countryCode="TM" value="7">Turcomenistão (+7)</option>
                                      <option data-countryCode="TM" value="993">Turcomenistão (+993)</option>
                                      <option data-countryCode="TC" value="1649">Ilhas Turks &amp; Caicos (+1649)</option>
                                      <option data-countryCode="TV" value="688">Tuvalu (+688)</option>
                                      <option data-countryCode="UG" value="256">Uganda (+256)</option>
                                      <option data-countryCode="GB" value="44">Reino Unido (+44)</option>
                                      <option data-countryCode="UA" value="380">Ucrânia (+380)</option>
                                      <option data-countryCode="AE" value="971">Emirados Árabes Unidos (+971)</option>
                                      <option data-countryCode="UY" value="598">Uruguai (+598)</option>
                                      <option data-countryCode="UZ" value="7">Uzbequistão (+7)</option>
                                      <option data-countryCode="VU" value="678">Vanuatu (+678)</option>
                                      <option data-countryCode="VA" value="379">Cidade do Vaticano (+379)</option>
                                      <option data-countryCode="VE" value="58">Venezuela (+58)</option>
                                      <option data-countryCode="VN" value="84">Vietnã (+84)</option>
                                      <option data-countryCode="VG" value="1284">Ilhas Virgens Britânicas (+1284)</option>
                                      <option data-countryCode="VI" value="1340">Ilhas Virgens Americanas (+1340)</option>
                                      <option data-countryCode="WF" value="681">Wallis &amp; Futuna (+681)</option>
                                      <option data-countryCode="YE" value="969">Iêmen do Norte (+969)</option>
                                      <option data-countryCode="YE" value="967">Iêmen do Sul (+967)</option>
                                      <option data-countryCode="ZM" value="260">Zâmbia (+260)</option>
                                      <option data-countryCode="ZW" value="263">Zimbábue (+263)</option>
                                  </select>
                              </div>
                              <div class="col-md-9">
                                  <input type="text" name="telefone" class="form-control" id="InputTelefone" aria-describedby="yourPhone" required>
                                  <div id="yourPhone" class="form-text">{{__("messages.ModCadDdd")}}</div>
                              </div>
                          </div>
                      </div>
                  </div>

                  <div class="row" id="CadCPF" style="display: none;">
                      <div class="mb-3" style="width:100% !important;">
                          <label  for="cpf" class="form-label">{{__("messages.ModCadCpf")}}</label>
                          <input type="text" name="cpf" class="form-control" id="InputCPF" aria-describedby="yourCPF">
                          <div id="cpfError" class="error-message"></div>
                      </div>
                  </div>

                  <div class="row">
                      <div class="mb-3" style="width:100% !important;">
                          <label for="E-mail" class="form-label">{{__("messages.ModCadEmail")}}</label>
                          <input type="email" name="email" class="form-control" id="InputEmail" aria-describedby="emailCadastro" required>
                          <div id="emailCadastro" class="form-text">{{__("messages.ModCadSubMail")}}</div>
                      </div>
                  </div>

                  <div class="row">
                      <div class="mb-3" style="width:100% !important;">
                          <label for="password" class="form-label">{{__("messages.ModCadSenha")}}</label>
                          <input type="password" name="password" class="form-control" id="InputSenha" aria-describedby="senhaCadastro" required>
                      </div>
                  </div>

                  <div class="row">
                      <div class="mb-3" style="width:100% !important;">
                          <label for="passwordConfirm" class="form-label">{{__("messages.ModCadSenhaConfirm")}}</label>
                          <input type="password" name="passwordConfirm" class="form-control" id="InputSenhaConfirma" aria-describedby="senhaCadastro" required>
                      </div>
                  </div>

                  <div class="row" id="couponCode" style="display:none;width:100% !important;">
                      <div class="mb-3">
                          <label for="coupon" class="form-label">{{__("messages.ModCadInsertCupom")}}</label>
                          <input type="text" name="coupon" class="form-control" id="InputCoupon" aria-describedby="coupon">
                      </div>
                  </div>

                  <div class="form-group form-check mb-3" style="width:100% !important;">
                      <input type="checkbox" class="form-check-input" id="CheckTermos" required>
                      <label class="form-check-label" for="CheckTermos">{{__("messages.ModCadTermos")}}<a href="#" style="color: black; font-weight:bold; text-decoration: none;"> {{__("messages.ModCadTermos2")}}</a> {{__("messages.ModCadTermos3")}} <a href="#" style="color: black; font-weight:bold; text-decoration: none;">{{__("messages.ModCadTermos4")}}</a> {{__("messages.ModCadTermos5")}}</label>
                  </div>

                  <div class="row">
                      <div class="mb-3">
                          <input type="submit" value="{{__("messages.ModCadBotao")}}" class="btn btn-danger dropdown-toggle botaoLogar" style="float: right;">
                      </div>
                  </div>
              </form>
          </div><!--container_form-->


        </div> 
      
      </div>
       <br>
       <BR>
       </BR>
       <BR>
       </BR>
       <br>
       <br>
       <br>
    </div>
  </div>

  

<div class="mt-5 pt-5 pb-5 footer">
    <div class="container">
      <div class="row">
        <div class="col-lg-5 col-xs-12 about-company">
        <div class="container"> <a class="navbar-brand" href="#"><img class="img-fluid d-block" src="{{ asset('ladingpage/img/logo.png') }}" width="300" style=""></a> <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbar2SupportedContent" aria-controls="navbar2SupportedContent" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
        <p class="pr-5 text-white-50"> DentalGO é uma plataforma digital que oferece publicações e recursos para profissionais da odontologia., </p>
        <p><a href="https://www.facebook.com/dentalpresseditora/?locale=pt_BR"><i class="fa fa-facebook-square mr-1"></i></a><a href="https://www.instagram.com/dentalgo_official/"><i class="fa fa-instagram"></i></a></p>
        </div>
        </div>
        <div class="col-lg-3 col-xs-12 links">
        <h2 class="mt-lg-0 mt-sm-3">Links Úteis</h2>
          <ul class="m-0 p-0">
            <li>- <a href="http://www.dentalpress.com.br">Portal Dental Press</a></li>
            <li>- <a href="#">Submeter artigos</a></li>
            <li>- <a href="#">App Dental GO</a></li>
            <li>- <a href="https://novo.dentalpresspub.com/">Editora Dental Press</a></li>
            <li>- <a href="http://www.dentalpress.com.br/cursos">Cursos de Especialização</a></li>
            <li>- <a href="https://dentalpress.com.br/portal/acesso-do-assinante/">Acesso Assinantes</a></li>
          </ul>
        </div>


        <div class="col-lg-4 col-xs-12 location">
          <h2 class="mt-lg-0 mt-sm-4"><b></b>Onde nos encontrar ?<b></b></h2>
          <p>Avenida Dr. Luiz Teixeira Mendes, 2712</p>
          <p>Maringá - Paraná - 87045-000</p>
          <p class="mb-0"><i class="fa fa-phone mr-3"></i>(44) 3033-9812</p>
          <p><i class="fa fa-envelope-o mr-3"></i>atendimento2@dentalpress.com.br</p>
        </div>
      </div>
      <div class="row mt-5">
        <div class="col copyright">
          <p class=""><small class="text-white-50">© 2024. All Rights Reserved. Dental Press International</small></p>
        </div>
      </div>
    </div>
    </div>
  
  
    
    <!-- JavaScript dependencies -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <!-- Script: Smooth scrolling between anchors in the same page -->
    <script src="{{ asset('ladingpage/js/smooth-scroll.js') }}"></script>
    <!-- botão whats -->
    <script type="text/javascript">
      (function() {
        var options = {
          whatsapp: "+554430339812", // WhatsApp number
          call_to_action: "Fale Conosco", // Call to action
          position: "right", // Position may be 'right' or 'left'
        };
        var proto = document.location.protocol,
          host = "getbutton.io",
          url = proto + "//static." + host;
        var s = document.createElement('script');
        s.type = 'text/javascript';
        s.async = true;
        s.src = url + '/widget-send-button/js/init.js';
        s.onload = function() {
          WhWidgetSendButton.init(host, proto, options);
        };
        var x = document.getElementsByTagName('script')[0];
        x.parentNode.insertBefore(s, x);
      })();
    </script>
    <!-- /botão whats -->


    <!-- validar cpf  -->

    <script>
  $(document).ready(function() {
    // Evento para mostrar/esconder campo CPF
    $("#InputDDI").change(function() {
      if ($(this).val() === "55") {
        $("#CadCPF").show();
        $("#InputCPF").attr("required", true);
      } else {
        $("#CadCPF").hide();
        $("#InputCPF").removeAttr("required").val("").removeClass('is-invalid').next().text('');
      }
    });

    // Inicializar o plugin de validação
    $("#formCad").validate({
      rules: {
        cpf: {
          required: function() {
            return $("#InputDDI").val() === "55";
          },
          cpf: true
        },
      },
      messages: {
        cpf: {
          cpf: "CPF inválido"
        }
      }
    });

    // Método customizado de validação de CPF
    $.validator.addMethod("cpf", function(value, element) {
      value = $.trim(value);
      value = value.replace(/\./g, "").replace("-", "");
      while (value.length < 11) value = "0" + value;
      var expReg = /^0+$|^1+$|^2+$|^3+$|^4+$|^5+$|^6+$|^7+$|^8+$|^9+$/;
      var a = [];
      var b = 0;
      var c = 11;
      for (var i = 0; i < 11; i++) {
        a[i] = value.charAt(i);
        if (i < 9) b += a[i] * --c;
      }
      var x = b % 11;
      a[9] = (x < 2) ? 0 : 11 - x;
      b = 0;
      c = 11;
      for (var y = 0; y < 10; y++) b += a[y] * c--;
      x = b % 11;
      a[10] = (x < 2) ? 0 : 11 - x;
      var retorno = true;
      if (value.charAt(9) != a[9] || value.charAt(10) != a[10] || value.match(expReg)) {
        document.getElementById("InputCPF").setCustomValidity("O CPF é inválido");
        retorno = false;
      } else {
        document.getElementById("InputCPF").setCustomValidity("");
      }
      return this.optional(element) || retorno;
    });

    // Máscaras para os campos
    Inputmask("999.999.999-99").mask("#InputCPF");

    // Evento de validação de CPF
    $("#InputCPF").blur(function() {
      if (!$(this).valid()) {
        $(this).addClass('is-invalid').next().text("O CPF é inválido");
      } else {
        $(this).removeClass('is-invalid').next().text('');
      }
    });
  });
  </script>

<!--validacao da senha -->

<script>
 $(document).ready(function() {
    $("#formCad").on('submit', function(event) {
      var password = $("#InputSenha").val();
      var confirmPassword = $("#InputSenhaConfirma").val();
      
      if (password !== confirmPassword) {
        event.preventDefault();
        alert("Suas Senhas Não Coincidem")
      } 
    });
  });
</script>
  </body>
  
  </html>