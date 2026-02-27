<?php
$conversao = array(
  'á' => 'a', 'à' => 'a', 'ã' => 'a', 'â' => 'a', 'é' => 'e',
  'ê' => 'e', 'í' => 'i', 'ï' => 'i', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', "ö" => "o",
  'ú' => 'u', 'ü' => 'u', 'ç' => 'c', 'ñ' => 'n', 'Á' => 'A', 'À' => 'A', 'Ã' => 'A',
  'Â' => 'A', 'É' => 'E', 'Ê' => 'E', 'Í' => 'I', 'Ï' => 'I', "Ö" => "O", 'Ó' => 'O',
  'Ô' => 'O', 'Õ' => 'O', 'Ú' => 'U', 'Ü' => 'U', 'Ç' => 'C', 'N' => 'Ñ'
);

if (isset($_POST["url"])) {
  $modelo = $_POST['modelo'];
  $url = $_POST['url'];
  $url = str_replace(' ', '', $url);
  $url = strtr($url, $conversao);
  $url = strtolower($url);
  //$url = "delicius' AND url='kjhkjhkjhkj";

  $buscaurl   = $connect->query("SELECT id FROM config WHERE url='$url'");
  $count_url  = $buscaurl->rowCount();

  if ($count_url >= 1) {

    header("location: ./?cod=existente");
    exit;
  } else {
    $_SESSION["modelo"] = $modelo;
    $_SESSION["url"] = $url;
    header("location: ./cadastrar_empresa");
    exit;
  }
}

if (isset($_POST["urln"])) {
  $urln       = $_POST['urln'];
  $urlm       = $_POST['urlm'];
  $modelon    = $_POST['modelon'];
  $nome      = $_POST['nome'];

  if (empty($_POST['cpf'])) {
    echo '<script type="text/javascript">';
    echo 'alert("CPF incorreto");';
    echo 'history.go(-1);';
    echo '</script>';
    exit;
  }

  $cpf = preg_replace("/[^0-9]/", "", $_POST['cpf']);
  $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);

  if (strlen($cpf) != 11) {
    echo '<script type="text/javascript">';
    echo 'alert("CPF incorreto");';
    echo 'history.go(-1);';
    echo '</script>';
    exit;
  }

  if (
    $cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' ||
    $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999'
  ) {
    echo '<script type="text/javascript">';
    echo 'alert("CPF incorreto");';
    echo 'history.go(-1);';
    echo '</script>';
    exit;
  } else {
    for ($t = 9; $t < 11; $t++) {
      for ($d = 0, $c = 0; $c < $t; $c++) {
        $d += $cpf[$c] * (($t + 1) - $c);
      }
      $d = ((10 * $d) % 11) % 10;
      if ($cpf[$c] != $d) {
        echo '<script type="text/javascript">';
        echo 'alert("CPF incorreto");';
        echo 'history.go(-1);';
        echo '</script>';
        exit;
      }
    }

    $celular   = $_POST['celular'];
    $celular1   = str_replace("(", "", $celular);
    $celular2   = str_replace(")", "", $celular1);
    $celular   = str_replace("-", "", $celular2);

    $senhax    = $_POST['senha'];
    $senha     = sha1($_POST['senha']);
    $empresa   = $_POST['empresa'];
    $email     = $_POST['email'];

    $verecel  = $connect->query("SELECT id FROM config WHERE celular='$celular'");
    $verecel  = $verecel->rowCount();
    if ($verecel) {
      echo '<script type="text/javascript">';
      echo 'alert("Tente outro nº de celular");';
      echo 'history.go(-1);';
      echo '</script>';
      exit;
    }

    $veremail  = $connect->query("SELECT id FROM config WHERE email='$email'");
    $veremail  = $veremail->rowCount();

    if ($veremail) {
      echo '<script type="text/javascript">';
      echo 'alert("Tente outro email");';
      echo 'history.go(-1);';
      echo '</script>';
      exit;
    }

    $vercpf  = $connect->query("SELECT id FROM config WHERE cpf='$cpf'");
    $vercpf  = $vercpf->rowCount();

    if ($vercpf) {

      echo '<script type="text/javascript">';
      echo 'alert("Tente outro CPF ou CNPJ");';
      echo 'history.go(-1);';
      echo '</script>';
      exit;
    }

    $confgadm    = $connect->query("SELECT * FROM adm");
    $confgadm    = $confgadm->fetch(PDO::FETCH_OBJ);
    $novocli  = $confgadm->novocliente;
    $dias    = $confgadm->dias;

    $data = date("Y-m-d");
    $dataexpira = date('Y-m-d', strtotime("+$dias days", strtotime($data)));

    $cadusuario = $connect->query("INSERT INTO config(idu, nomeempresa, nomeadmin, cpf, email, senha, url, telefone, celular, cep, rua, bairro, cidade, uf, complemento, numero, mesa, balcao, delivery, cupon, funcionamento, status, modelo2, expiracao, datacad) VALUES ('1','$empresa','$nome','$cpf','$email','$senha','$urln','00000000','$celular','000000000','xx','xx','xx','xx','xx','00','1','1','1','1','1','$novocli','$modelon','$dataexpira','$data')");

    $user      = $connect->query("SELECT id FROM config WHERE cpf='$cpf'");
    $userx     = $user->fetch(PDO::FETCH_OBJ);
    $userx     = $userx->id;

    $cadlogo   = $connect->query("INSERT INTO fundotopo(idu, foto) VALUES ('$userx','off.jpg')");
    $fundologo   = $connect->query("INSERT INTO logo(idu, foto) VALUES ('$userx','off.jpg')");
    $fbanner   = $connect->query("INSERT INTO banner(idu, img) VALUES ('$userx','off.jpg')");

    function rrmdir($Dir_destino)
    {
      if (is_dir($Dir_destino)) {
        $files = scandir($$Dir_destino);
        foreach ($files as $file)
          if (is_dir($Dir_destinho / $Dir_Origem)) {
            if ($file != "." && $file != "..") rrmdir("$Dir_destinho/$file");
          } else {
            if ($file != "." && $file != "..") rrmdir("$Dir_destinho/$file");
          }
        rmdir($dir);
      } else if (file_exists($dir)) unlink($dir);
    }


    function rcopy($src, $dst)
    {
      if (file_exists($dst)) rrmdir($dst);
      if (is_dir($src)) {
        mkdir($dst);
        $files = scandir($src);
        foreach ($files as $file)
          if ($file != "." && $file != "..") rcopy("$src/$file", "$dst/$file");
      } else if (file_exists($src)) copy($src, $dst);
    }

    if ($modelon == 1) {
      rcopy("../../basecard", "../../" . $urln . "");
    }

    if ($modelon == 2) {
      rcopy("../../basecat", "../../" . $urln . "");
    }

    $dad = "$";

    $conteudox  = "<?php\n";
    $conteudox .= "ob_start();\n";
    $conteudox .= "session_start();\n";
    $conteudox .= "if(!isset(" . $dad . "_SESSION['id_cliente'])) {\n";
    $conteudox .= "for (" . $dad . "i = 0; " . $dad . "i < 10; " . $dad . "i++) {\n";
    $conteudox .= "" . $dad . "id_pedido = rand(100000, 999999).\"PW\";\n";
    $conteudox .= "" . $dad . "_SESSION[\"id_cliente\"] = " . $dad . "id_pedido;}\n";
    $conteudox .= "} else { " . $dad . "id_cliente = " . $dad . "_SESSION['id_cliente'];\n";
    $conteudox .= "}\n";
    //$conteudox .= "".$dad."id_pedido = rand(100000, 999999).\"\";\n";
    $conteudox .= "if(!isset(" . $dad . "id_cliente)) { header(\"location: ./\"); exit; }\n";
    $conteudox .= "include('../funcoes/Conexao.php');\n";
    $conteudox .= "include('../funcoes/Key.php');\n";
    $conteudox .= "include('db/base.php');\n";
    //$conteudox .= "require('db/Mobile_Detect.php');\n";
    //$conteudox .= "".$dad."detect = new Mobile_Detect;\n";
    $conteudox .= "" . $dad . "xurl = '" . $urln . "';\n";
    $conteudox .= "" . $dad . "site = HOME;\n";
    $conteudox .= "include('db/Funcoes.php');\n";
    $conteudox .= "" . $dad . "Url[1] = (empty(" . $dad . "Url[1]) ? null : " . $dad . "Url[1]);\n";
    $conteudox;

    file_put_contents("../../" . $urln . "/header.php", $conteudox);

    $conteudoy  = "<?php\n";
    $conteudoy .= "define('HOME', '" . $urlm . "/" . $urln . "/');\n";
    $conteudoy .= "setlocale( LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese' );\n";
    $conteudoy;

    file_put_contents("../../" . $urln . "/db/base.php", $conteudoy);

    $conteudoz  = "<?php\n";
    $conteudoz .= "ob_start();\n";
    $conteudoz .= "if(isset(" . $dad . "_COOKIE['pedidomesa'])){\n";
    $conteudoz .= "" . $dad . "id_mesa = " . $dad . "_COOKIE['pedidomesa'];\n";
    $conteudoz .= "} else {\n";
    $conteudoz .= "" . $dad . "cookie_cel = 'pedidomesa';\n";
    $conteudoz .= "" . $dad . "cookie_value2 = rand(100000, 999999);\n";
    $conteudoz .= "setcookie(" . $dad . "cookie_cel, " . $dad . "cookie_value2, time() + (3500 * 5));\n";
    $conteudoz .= "" . $dad . "id_mesa = " . $dad . "_COOKIE['pedidomesa'];\n";
    $conteudoz .= "}\n";
    $conteudoz .= "if(!isset(" . $dad . "id_mesa)) { header('location: finalizado.php'); exit; }\n";
    $conteudoz .= "include('../../funcoes/Conexao.php');\n";
    $conteudoz .= "include('../../funcoes/Key.php');\n";
    $conteudoz .= "include('../db/base.php');\n";
    $conteudoz .= "require('../db/Mobile_Detect.php');\n";
    $conteudoz .= "" . $dad . "detect = new Mobile_Detect;\n";
    $conteudoz .= "" . $dad . "xurl = '" . $urln . "';\n";
    $conteudoz .= "" . $dad . "site = HOME;\n";
    $conteudoz .= "include('FuncoesM.php');\n";
    $conteudoz;

    file_put_contents("../../" . $urln . "/mesa/header.php", $conteudoz);


    if ($cadusuario) {
      header("location: sucesso");
      exit;
      exit;
    } else {
      header("location: erro");
      exit;
      exit;
    }
  }
}
