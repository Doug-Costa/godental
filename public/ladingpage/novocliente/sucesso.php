<?php
if(!isset($_SESSION['url'])) { header("location: index.php"); exit;}
$url = $_SESSION['url'];

$user  = $connect->query("SELECT * FROM config WHERE url='$url'"); 
$userx = $user->fetch(PDO::FETCH_OBJ);

$confgadm  	= $connect->query("SELECT * FROM adm"); 
$confgadm  	= $confgadm->fetch(PDO::FETCH_OBJ);
$novocli	= $confgadm->novocliente;

?>
    <div class="signin-wrapper">
      <div class="signin-box signup">
         <center><h2 class="slim-logo"><img src="../img/logoc.png" class="img-fluid" alt="<?php print $nomesite; ?>" width="200"></h2>
         <h3 class="signin-title-secondary">CADASTRO FINALIZADO</h3></center>
		 <div class="signup-separator" style="margin-top:-40px;"><span>IMPORTANTE</span></div>
		 <p style="margin-top:10px; color:#666666; font-size:13px" align="justify"><strong>
		 <span style="color:#00CCCC">Você terá <span style="color:#FF9966; font-size:18px"><?=$confgadm->dias; ?> dias</span> gratuitos para testar todas as funcionalidades do nosso sistema.</span>
		 <br />
		 Obrigado por contratar nosso serviço. Abaixo segue as instruções de acesso ao seu sistema. 
		 </strong>
		 <?php if($novocli == 1) { ?>
		 <p style="color:#00CC00; font-size:13px" align="justify"><strong>Sua conta já esta liberada e pronta para ser utilizada.</strong>
		 <?php } else { ?>
		 <p style="color:#FF3333; font-size:13px" align="justify"><strong>Sua conta está sendo criada. Por favor aguarde alguns minutos até receber uma mensagem informando a liberação do seu acesso.</strong>
		 <?php } ?>
		 <div class="signup-separator" style="margin-top:20px;"><span>COPIE OS DADOS ABAIXO</span></div>

        <div class="row row-xs mg-b-10">
          <div class="col-sm">
		  	<strong>Sua url personalizada:</strong><br><span style="color:#006699"><?php print $urlmaster; ?>/<?php print $url; ?></span><br><br>
			<strong>Painel Administrativo:</strong><br><span style="color:#006699"><?php print $urlmaster; ?>/<?php print $url; ?>/master</span><br>
		  </div>
        </div>
		
		<div class="row row-xs">
          <div class="col-sm">
			<strong>Login:</strong> <span style="color:#006699"><?php print $userx->cpf; ?></span><br>
			<strong>Senha:</strong> <span style="color:#006699">****</span><br><br>
		  </div>
        </div>
		         
        <a href="../"><button class="btn btn-primary btn-block btn-signin mg-t-20">Finalizar</button></a>
      </div>
    </div>
  </body>
</html>