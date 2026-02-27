<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Não Encontrada - DentalGo</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&family=Montserrat:wght@700&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --accent-color: #CA1D53;
            --bg-color: #f8f9fa;
            --text-primary: #212529;
            --text-secondary: #6c757d;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-primary);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .error-container {
            max-width: 600px;
            padding: 40px;
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            margin: 20px;
        }

        h1 {
            font-family: 'Montserrat', sans-serif;
            font-size: 8rem;
            margin: 0;
            color: #e9ecef;
            line-height: 1;
            font-weight: 800;
            position: relative;
        }

        h1 span {
            color: var(--accent-color);
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 2rem;
            font-weight: 600;
            white-space: nowrap;
            color: var(--text-primary);
        }

        h2 {
            font-size: 1.8rem;
            margin-top: 20px;
            margin-bottom: 15px;
            font-weight: 700;
            color: var(--text-primary);
        }

        p {
            color: var(--text-secondary);
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .btn-home {
            display: inline-block;
            background-color: var(--accent-color);
            color: #ffffff;
            padding: 15px 35px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(202, 29, 83, 0.3);
        }

        .btn-home:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(202, 29, 83, 0.4);
            background-color: #a01541;
        }
    </style>
</head>

<body>
    <div class="error-container">
        <h1>404 <span>Página não encontrada</span></h1>
        <h2>Conteúdo Indisponível</h2>
        <p>A página que você está procurando pode ter sido removida ou o link está incorreto.</p>
        <a href="{{ url('/') }}" class="btn-home">Voltar para a Home</a>
    </div>
</body>

</html>