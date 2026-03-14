<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anamnese Odontológica - GoDental</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #0ea5e9;
            --primary-dark: #0284c7;
            --bg: #f8fafc;
            --card: #ffffff;
            --text: #1e293b;
            --text-muted: #64748b;
            --border: #e2e8f0;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg);
            color: var(--text);
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
        }

        .container {
            max-width: 600px;
            width: 100%;
            background: var(--card);
            padding: 32px;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 32px;
        }

        .header h1 {
            font-size: 24px;
            margin-bottom: 8px;
            color: var(--primary);
        }

        .header p {
            color: var(--text-muted);
            font-size: 14px;
        }

        .question-group {
            margin-bottom: 24px;
            padding-bottom: 24px;
            border-bottom: 1px solid var(--border);
        }

        .question-label {
            display: block;
            font-weight: 600;
            margin-bottom: 12px;
        }

        .options {
            display: flex;
            gap: 16px;
        }

        .options label {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        textarea,
        input[type="text"] {
            width: 100%;
            padding: 12px;
            border: 1px solid var(--border);
            border-radius: 8px;
            margin-top: 12px;
            font-family: inherit;
        }

        button {
            width: 100%;
            padding: 16px;
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s;
        }

        button:hover {
            background-color: var(--primary-dark);
        }

        .hidden {
            display: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>GoDental</h1>
            <p>Olá, <strong>{{ $instance->patient->name }}</strong>. Por favor, preencha sua ficha de anamnese antes do
                atendimento.</p>
        </div>

        <form action="{{ route('anamnesis.store', $instance->token) }}" method="POST">
            @csrf

            @foreach($instance->template->questions as $q)
                <div class="question-group">
                    <label class="question-label">{{ $loop->iteration }}. {{ $q['text'] }}</label>

                    @if($q['type'] == 'yes_no')
                        <div class="options">
                            <label><input type="radio" name="answers[{{ $q['id'] }}]" value="Sim" required> Sim</label>
                            <label><input type="radio" name="answers[{{ $q['id'] }}]" value="Não"> Não</label>
                        </div>
                    @elseif($q['type'] == 'yes_no_text')
                        <div class="options">
                            <label><input type="radio" name="answers[{{ $q['id'] }}][choice]" value="Sim"
                                    onchange="toggleExtra('{{ $q['id'] }}', true)" required> Sim</label>
                            <label><input type="radio" name="answers[{{ $q['id'] }}][choice]" value="Não"
                                    onchange="toggleExtra('{{ $q['id'] }}', false)"> Não</label>
                        </div>
                        <input type="text" name="answers[{{ $q['id'] }}][extra]" id="extra_{{ $q['id'] }}" class="hidden"
                            placeholder="Especifique aqui...">
                    @elseif($q['type'] == 'long_text')
                        <textarea name="answers[{{ $q['id'] }}]" rows="4" required placeholder="Sua resposta..."></textarea>
                    @endif
                </div>
            @endforeach

            <button type="submit">Enviar Anamnese</button>
        </form>
    </div>

    <script>
        function toggleExtra(id, show) {
            const input = document.getElementById('extra_' + id);
            if (show) {
                input.classList.remove('hidden');
                input.required = true;
            } else {
                input.classList.add('hidden');
                input.required = false;
            }
        }
    </script>
</body>

</html>