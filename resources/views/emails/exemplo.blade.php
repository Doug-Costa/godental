<!DOCTYPE html>
<html>
<head>
    <title>Recuperação de Senha - DentalGo</title>
</head>
<body>
    <h1>{{ $assunto }}</h1>

    <p>Olá {{ $nomeUsuario }},</p>
    
    <p>Recebemos uma solicitação para redefinir a senha da sua conta no DentalGo. Clique no link abaixo para iniciar o processo de recuperação de senha:</p>

    <p><a href="{{ $linkRecuperacao }}">{{ $linkRecuperacao }}</a></p>

    <p>Se você não solicitou essa recuperação de senha, ignore este e-mail.</p>

    <p>Atenciosamente,<br>
    Equipe DentalGo</p>
</body>
</html>