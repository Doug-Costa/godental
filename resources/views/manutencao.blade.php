<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serviço Temporariamente Indisponível</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .maintenance-container {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        .maintenance-image img {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
        }
        .title {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 15px;
            color: #343a40;
        }
        .description {
            font-size: 1.2rem;
            margin-bottom: 20px;
            color: #6c757d;
        }
        .footer {
            margin-top: 20px;
            font-size: 0.9rem;
            color: #adb5bd;
        }
    </style>
</head>
<body>
    <div class="maintenance-container">
        <div class="maintenance-image">
            <img src="https://miro.medium.com/v2/resize:fit:860/0*Zcn7ZCwN4DGFtmo8.png" alt="Sistema Indisponível">
        </div>
        <div class="content">
            <h1 class="title">Serviço Temporariamente Indisponível</h1>
            <p class="description">
                Prezado(a) usuário(a),<br>
                Informamos que o sistema de busca está temporariamente indisponível devido a problemas técnicos. 
                Nossa equipe está trabalhando para solucionar o mais rápido possível. Agradecemos sua compreensão e pedimos desculpas pelo transtorno.
            </p>
            <button class="btn btn-secondary mt-3" onclick="window.location.href='/'">Voltar à Página Inicial</button>
        </div>
        <div class="footer">
            &copy; 2024 DentalPress. Todos os direitos reservados.
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>