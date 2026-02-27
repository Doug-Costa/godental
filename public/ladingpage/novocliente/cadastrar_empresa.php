<?php
if(!isset($_SESSION['url'])) { header("location: ./"); exit;}
$url = $_SESSION['url'];
$modelo = $_SESSION['modelo'];
?>
    <div class="signin-wrapper">
      <div class="signin-box signup">
         <center><img src="../img/logoc.png" class="img-fluid" alt="<?php print $nomesite; ?>" width="200">
         <br /><br />
         <h3 class="signin-title-secondary">CRIAR UMA NOVA CONTA</h3></center>
		 <div class="signup-separator" style="margin-top:-40px;"><span>SUA URL</span></div>
		 <p align="center"><?php print $urlmaster; ?>/<span style="color:#FF0000"><?php print $url; ?></span></p>
		 <hr>
		<form method="post" action="">
		<input type="hidden" name="urlm" value="<?php print $urlmaster;?>">
	    <input type="hidden" name="urln" value="<?php print $url;?>">
		<input type="hidden" name="modelon" value="<?php print $modelo;?>">
        <div class="row row-xs mg-b-10">
          <div class="col-sm"><input type="text" name="empresa" class="form-control" placeholder="Nome da Empresa" maxlength="60" required>
		  <label style="font-size:10px">Nome exibido no cardápio.</label>
		  </div>
          <div class="col-sm mg-t-10 mg-sm-t-0"><input type="text" name="celular" id="phone-number" class="form-control" placeholder="Nº de celular com Whatsapp" required>
		  <label style="font-size:10px">Número que receberá o pedido.</label>
		  </div>
        </div>
		<div class="row row-xs mg-b-10">
          <div class="col-sm"><input type="text" name="nome" class="form-control" placeholder="Primeiro Nome" maxlength="30" required>
		   <label style="font-size:10px">Nome para contato.</label>
		  </div>
          <div class="col-sm mg-t-10 mg-sm-t-0"><input type="email" name="email" class="form-control" placeholder="Seu e-mail" maxlength="60" required>
		   <label style="font-size:10px">E-mail para receber informações.</label>
		  </div>
        </div>
		<div class="signup-separator" style="margin-top:20px;"><span>DADOS PARA ACESSO A CONTA</span></div>
        <div class="row row-xs mg-b-10">
          <div class="col-sm"><input type="text" name="cpf" id="cpf" class="form-control" placeholder="CPF ou CNPJ" required>
		  <label style="font-size:10px">Será utilizado como login.</label>
		  </div>
          <div class="col-sm mg-t-10 mg-sm-t-0"><input type="password" class="form-control" name="senha" placeholder="Informe uma senha" maxlength="8" required>
		  <label style="font-size:10px">Máximo de oito caracteres.</label>
		  </div>
        </div>
        <button class="btn btn-primary btn-block btn-signin">Criar Conta</button>
      </div>
    </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
 <script>
 $(document).ready(function(){
  $('#phone-number').mask('(00)00000-0000');
  $('#cpf').mask('000.000.000-00');
});
 </script>
  </body>
</html>