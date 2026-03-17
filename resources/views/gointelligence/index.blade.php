@extends('facelift2.master')

@section('content')

    <style>
        /* Setup base structure */
        .chat-main {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: calc(100vh - 80px);
            /* minus topbar */
            background-color: #f7f7f7;
            font-family: 'Poppins', 'Montserrat', sans-serif;
        }

        /* HERO STATE */
        .go-home-hero {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            flex: 1;
            text-align: center;
            padding: 4rem 2rem;
        }

        .go-logo-icon {
            width: 70px;
            margin-bottom: 2rem;
        }

        .go-hero-title {
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            font-size: 2.5rem;
            color: #111;
            margin-bottom: 1rem;
        }

        .go-hero-subtitle {
            font-family: 'Raleway', sans-serif;
            color: #777;
            max-width: 650px;
            font-size: 1.1rem;
            margin-bottom: 2.5rem;
        }

        .go-search-wrapper {
            position: relative;
            width: 100%;
            max-width: 600px;
            margin-bottom: 2rem;
        }

        .go-search-input {
            width: 100%;
            padding: 1.25rem 3.5rem 1.25rem 1.75rem;
            border-radius: 50px;
            border: 1px solid #e0e0e0;
            font-size: 1rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            outline: none;
            transition: all 0.3s ease;
            color: #333;
            resize: none;
            overflow-y: hidden;
            min-height: 56px;
        }

        .go-search-input:focus {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border-color: #CA1D53;
        }

        .go-search-btn {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #CA1D53;
            font-size: 1.2rem;
            cursor: pointer;
        }

        .go-suggestions {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
            width: 100%;
            max-width: 600px;
            justify-content: space-between;
        }

        .go-suggestion-card {
            background-color: #f3f4f6;
            color: #4b5563;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 1rem;
            font-size: 0.8rem;
            flex: 1;
            text-align: left;
            transition: transform 0.2s, box-shadow 0.2s;
            cursor: default;
        }

        .go-suggestion-card h5 {
            font-size: 0.85rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 0.5rem;
            line-height: 1.2;
        }

        .go-suggestion-card p {
            font-size: 0.75rem;
            color: #6b7280;
            margin-bottom: 0;
            line-height: 1.3;
        }

        .go-suggestion-card:hover {
            background-color: #d0d0d0;
        }

        @media (max-width: 576px) {
            .go-suggestions {
                flex-direction: column;
                align-items: stretch;
            }
        }

        /* CHAT STATE */
        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 2rem 1rem;
            display: none;
            /* hidden initially */
            flex-direction: column;
            gap: 1.5rem;
            max-width: 900px;
            margin: 0 auto;
            width: 100%;
        }

        .message-row {
            display: flex;
            gap: 1rem;
            width: 100%;
        }

        .message-row.user {
            flex-direction: row-reverse;
        }

        .message-bubble {
            padding: 1rem 1.25rem;
            border-radius: 1rem;
            line-height: 1.5;
            max-width: 80%;
            font-size: 0.95rem;
        }

        .message-row.bot .message-bubble {
            background-color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            border: 1px solid #e5e7eb;
            color: #333;
            max-width: 100%;
            width: 100%;
            box-sizing: border-box;
        }

        .message-row.user .message-bubble {
            background-color: #CA1D53;
            color: white;
            box-shadow: 0 2px 5px rgba(202, 29, 83, 0.2);
        }

        .chat-input-container {
            padding: 1.5rem;
            background-color: transparent;
            display: none;
            /* hidden initially */
            margin-top: auto;
            margin-bottom: 2rem;
        }

        .chat-input-wrapper {
            max-width: 900px;
            margin: 0 auto;
            position: relative;
            display: flex;
            align-items: center;
            background-color: white;
            border: 1px solid #d1d5db;
            border-radius: 50px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .chat-input {
            flex: 1;
            border: none;
            padding: 1.25rem 1.75rem;
            border-radius: 50px;
            outline: none;
            font-size: 1rem;
            color: #333;
            resize: none;
            overflow-y: hidden;
            min-height: 56px;
            display: flex;
            align-items: center;
        }

        .btn-send {
            background-color: #CA1D53;
            color: white;
            border: none;
            border-radius: 50%;
            width: 45px;
            height: 45px;
            margin-right: 0.8rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.2s;
        }

        .btn-send:hover {
            opacity: 0.9;
        }

        .btn-send:disabled {
            background-color: #d1d5db;
            cursor: not-allowed;
        }

        /* Fontes (Sources) */
        .sources-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .source-card {
            background-color: white;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 1rem;
            transition: all 0.2s ease-in-out;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .source-card.has-link {
            cursor: pointer;
        }

        .source-card.has-link:hover {
            border-color: #3b82f6;
            box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.1);
            background-color: #eff6ff;
        }

        .source-card-title {
            font-size: 0.85rem;
            font-weight: 600;
            color: #111827;
            margin-bottom: 0.5rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .source-card.has-link .source-card-title {
            color: #1d4ed8;
        }

        .source-card-snippet {
            font-size: 0.75rem;
            color: #4b5563;
            margin-bottom: 0.75rem;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .source-card-meta {
            font-size: 0.7rem;
            color: #6b7280;
            font-style: italic;
        }

        .source-card-footer {
            margin-top: 0.75rem;
            padding-top: 0.75rem;
            border-top: 1px solid #f3f4f6;
            font-size: 0.7rem;
            font-weight: 500;
            display: flex;
            align-items: center;
        }

        .source-card.has-link .source-card-footer {
            color: #2563eb;
        }

        .source-card:not(.has-link) .source-card-footer {
            color: #9ca3af;
        }

        .source-card-number {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 24px;
            width: 24px;
            height: 24px;
            flex-shrink: 0;
            background-color: #e5e7eb;
            color: #374151;
            border-radius: 50%;
            font-size: 0.75rem;
            font-weight: 700;
            margin-right: 0.5rem;
        }

        .source-card.has-link .source-card-number {
            background-color: #dbeafe;
            color: #1d4ed8;
        }

        /* Citation Badge */
        .citation-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 1.25rem;
            height: 1.25rem;
            background-color: #f3f4f6;
            color: #4b5563;
            border-radius: 4px;
            font-size: 0.7rem;
            font-weight: 700;
            margin: 0 0.15rem;
            padding: 0 0.25rem;
            text-decoration: none;
            vertical-align: super;
            border: 1px solid #e5e7eb;
            transition: all 0.2s;
            cursor: pointer;
        }

        .citation-badge:hover {
            background-color: #dbeafe;
            color: #1d4ed8;
            border-color: #bfdbfe;
            text-decoration: none;
        }

        /* Reliability Badge */
        .reliability-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.7rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
        }

        .reliability-high {
            background-color: #dcfce7;
            color: #166534;
        }

        .reliability-medium {
            background-color: #fef9c3;
            color: #854d0e;
        }

        .reliability-low {
            background-color: #fee2e2;
            color: #991b1b;
        }

        /* Reasoning Accordion */
        .reasoning-container {
            margin-bottom: 1rem;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            background-color: #f9fafb;
            overflow: hidden;
        }

        .reasoning-header {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.75rem 1rem;
            background: none;
            border: none;
            font-size: 0.8rem;
            font-weight: 600;
            color: #4b5563;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .reasoning-header:hover {
            background-color: #f3f4f6;
        }

        .reasoning-body {
            display: none;
            padding: 1rem;
            border-top: 1px solid #e5e7eb;
            background-color: white;
            font-size: 0.8rem;
            color: #4b5563;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
            white-space: pre-wrap;
            line-height: 1.5;
        }

        .reasoning-body.open {
            display: block;
        }
    </style>

    <div class="chat-main" @if($modalConteudo !== 'permitido') style="filter: blur(8px); pointer-events: none; user-select: none;" @endif>
        <!-- HERO STATE -->
        <div class="go-home-hero" id="goHomeState">
            <!-- Using the target logo mentioned -->
            <img src="{{ asset('facelift2/img/loogoo.png') }}"
                onerror="this.src='{{ asset('facelift2/img/go_logo_5.png') }}'" alt="GO Logo" class="go-logo-icon"
                style="width: 100px;">

            <h1 class="go-hero-title">Pesquise com segurança<br>em nossa base ciêntífica</h1>
            <p class="go-hero-subtitle">O GoIntelligence responde com base no<br>conhecimento de mais de 35 anos<br>na
                ciência da odontologia</p>

            <form class="go-search-wrapper" id="homeSearchForm">
                <textarea class="go-search-input" id="homeSearchInput" placeholder="Sua dúvida..." rows="1"></textarea>
                <button type="submit" class="go-search-btn"><i class="fa-solid fa-search"></i></button>
            </form>

            <div class="go-suggestions">
                <div class="go-suggestion-card">
                    <h5>Global Search</h5>
                    <p>Ask in any language.<br>We answer in your language.</p>
                </div>
                <div class="go-suggestion-card">
                    <h5>Explique melhor,<br>receba melhor</h5>
                    <p>Quanto mais detalhes você enviar, mais precisa será a resposta.</p>
                </div>
                <div class="go-suggestion-card">
                    <h5>Base científica real</h5>
                    <p>Respostas baseadas em mais de 35 anos de literatura odontológica.</p>
                </div>
            </div>
        </div>

        <!-- CHAT STATE -->
        <div class="chat-messages" id="chatArea">
        </div>

        <div class="typing-indicator text-center" id="typingIndicator"
            style="display: none; padding: 1rem; color: #888; font-style: italic; font-size: 0.95rem;">
            <i class="fa-solid fa-circle-notch fa-spin"></i> O GoIntelligence está analisando o acervo...
        </div>

        <div class="chat-input-container" id="chatInputContainer">
            <form id="chatForm" class="chat-input-wrapper">
                <textarea id="messageInput" class="chat-input" placeholder="Pesquisar..." rows="1" autocomplete="off" required></textarea>
                <button type="submit" class="btn-send" id="sendBtn">
                    <i class="fa-solid fa-paper-plane"></i>
                </button>
            </form>
            <div class="text-center mt-3" style="font-size: 0.75rem; color: #9ca3af;">
                A IA pode cometer erros. Considere verificar informações clínicas importantes na literatura original.
            </div>
        </div>
    </div>

    <script>
        const API_URL = '{{ $apiUrl }}';
        const API_KEY = '{{ $apiKey }}';
        const goHomeState = document.getElementById('goHomeState');
        const chatArea = document.getElementById('chatArea');
        const chatInputContainer = document.getElementById('chatInputContainer');
        const typingIndicator = document.getElementById('typingIndicator');

        // Forms
        const homeSearchForm = document.getElementById('homeSearchForm');
        const homeSearchInput = document.getElementById('homeSearchInput');
        const chatForm = document.getElementById('chatForm');
        const messageInput = document.getElementById('messageInput');
        const sendBtn = document.getElementById('sendBtn');

        function startSearch(text) {
            // Transition state correctly
            goHomeState.style.display = 'none';
            chatArea.style.display = 'flex';
            chatInputContainer.style.display = 'block';

            sendMessage(text);
        }

        homeSearchForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const text = homeSearchInput.value.trim();
            if (text) startSearch(text);
        });

        chatForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const text = messageInput.value.trim();
            if (text) sendMessage(text);
        });

        // Auto-resize and Enter handling
        function setupAutoResize(textarea, form) {
            textarea.addEventListener('input', () => {
                textarea.style.height = 'auto';
                textarea.style.height = (textarea.scrollHeight) + 'px';
            });

            textarea.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    form.dispatchEvent(new Event('submit'));
                }
            });
        }

        setupAutoResize(homeSearchInput, homeSearchForm);
        setupAutoResize(messageInput, chatForm);

        function appendUserMessage(text) {
            const div = document.createElement('div');
            div.className = 'message-row user';
            div.innerHTML = `<div class="message-bubble">${text}</div>`;
            chatArea.appendChild(div);
            scrollToBottom();
        }

        function appendBotMessage(text, sources = [], confidence = null, reasoningTrace = null) {
            const div = document.createElement('div');
            div.className = 'message-row bot';

            let badgeHtml = '';
            if (confidence !== null && confidence !== undefined) {
                let badgeClass = 'reliability-low';
                let badgeText = 'Confiança Baixa';
                let badgeIcon = 'fa-shield-halved';

                if (confidence >= 0.75) {
                    badgeClass = 'reliability-high';
                    badgeText = 'Alta Confiança';
                    badgeIcon = 'fa-shield-check';
                } else if (confidence >= 0.5) {
                    badgeClass = 'reliability-medium';
                    badgeText = 'Confiança Média';
                    badgeIcon = 'fa-shield';
                }

                badgeHtml = `
                                            <div class="reliability-badge ${badgeClass}">
                                                <i class="fa-solid ${badgeIcon}"></i>
                                                <span>${badgeText} (${(confidence * 100).toFixed(0)}%)</span>
                                            </div>
                                        `;
            }

            let reasoningHtml = '';
            if (reasoningTrace) {
                // Generate a unique ID for the accordion toggle
                const toggleId = 'reasoning-' + Math.random().toString(36).substr(2, 9);
                reasoningHtml = `
                                            <div class="reasoning-container">
                                                <button class="reasoning-header" onclick="document.getElementById('${toggleId}').classList.toggle('open'); this.querySelector('.fa-chevron-down').classList.toggle('fa-flip-vertical');">
                                                    <span><i class="fa-solid fa-brain" style="color: #9333ea; margin-right: 0.5rem;"></i> Raciocínio Clínico (GoIntelligence)</span>
                                                    <i class="fa-solid fa-chevron-down" style="transition: transform 0.2s;"></i>
                                                </button>
                                                <div id="${toggleId}" class="reasoning-body">${reasoningTrace}</div>
                                            </div>
                                        `;
            }

            let sourcesHtml = '';
            // Generate a random ID prefix to ensure uniqueness across multiple messages
            const msgHash = Math.random().toString(36).substr(2, 6);

            if (sources && sources.length > 0) {
                sourcesHtml = '<div class="mt-3"><h4 style="font-size: 0.75rem; font-weight: 600; color: #4b5563; text-transform: uppercase; margin-bottom: 0.5rem;">Fontes Consultadas</h4><div class="sources-grid">';

                sources.forEach((src, index) => {
                    const sourceNum = index + 1;
                    const title = src.title || src.file_name || `Fonte ${sourceNum}`;
                    const snippet = src.snippet || src.content || src.reference || '';
                    const journal = src.journal ? `${src.journal} ${src.year ? '(' + src.year + ')' : ''}` : '';

                    const targetUrl = src.url || src.pdf_url || src.link || null;
                    const hasLink = !!targetUrl;

                    const clickAction = hasLink ? `onclick="window.open('${targetUrl}', '_blank', 'noopener,noreferrer')"` : '';
                    const cardClass = hasLink ? 'source-card has-link' : 'source-card';
                    const iconHtml = hasLink ? '<i class="fa-solid fa-arrow-up-right-from-square" style="margin-right: 0.25rem;"></i> Abrir em nova aba' : '<span>Link não disponível</span>';

                    sourcesHtml += `
                                                <div class="${cardClass}" ${clickAction} id="source-${msgHash}-${sourceNum}" title="${hasLink ? 'Clique para abrir o artigo original' : 'Artigo restrito ou sem link'}">
                                                    <div>
                                                        <div style="display: flex; align-items: flex-start; margin-bottom: 0.5rem;">
                                                            <span class="source-card-number">${sourceNum}</span>
                                                            <h5 class="source-card-title" style="margin-top: 0.15rem;">${title}</h5>
                                                        </div>
                                                        <p class="source-card-snippet">${snippet}</p>
                                                        ${journal ? `<div class="source-card-meta">${journal}</div>` : ''}
                                                    </div>
                                                    <div class="source-card-footer">
                                                        ${iconHtml}
                                                    </div>
                                                </div>
                                            `;
                });

                sourcesHtml += '</div></div>';
            }

            let formattedText = text.replace(/\n/g, '<br>').replace(/\*\*(.*?)\*\*/g, '<b>$1</b>');

            // Regex to match citations like [1], [1, 2], [1-3]
            formattedText = formattedText.replace(/\[([\d,\s\-]+)\]/g, function (match, inner) {
                // Split multiple numbers like "1, 2" or handle singlets "1"
                const numbers = inner.split(/[,\-]/).map(n => n.trim()).filter(n => !isNaN(n) && n !== '');

                let badges = '';
                numbers.forEach(num => {
                    // Create an anchor that scrolls/jumps to the source card
                    badges += `<a href="#source-${msgHash}-${num}" class="citation-badge" title="Ir para a fonte ${num}" onclick="event.preventDefault(); document.getElementById('source-${msgHash}-${num}').scrollIntoView({behavior: 'smooth', block: 'center'}); document.getElementById('source-${msgHash}-${num}').style.boxShadow = '0 0 0 2px #3b82f6'; setTimeout(() => document.getElementById('source-${msgHash}-${num}').style.boxShadow = '', 2000);">${num}</a>`;
                });

                return badges ? badges : match;
            });
        }

        function createEmptyBotMessage() {
            const div = document.createElement('div');
            div.className = 'message-row bot';
            div.innerHTML = `
                <div style="width: 100%;">
                    <div class="message-bubble bot-response-area"></div>
                </div>
            `;
            chatArea.appendChild(div);
            scrollToBottom();
            return div.querySelector('.bot-response-area');
        }

        function scrollToBottom() {
            chatArea.scrollTop = chatArea.scrollHeight;
        }

        async function sendMessage(message) {
            appendUserMessage(message);
            messageInput.value = '';
            sendBtn.disabled = true;
            typingIndicator.style.display = 'block';

            const div = document.createElement('div');
            div.className = 'message-row bot';
            div.innerHTML = `<div style="width: 100%;"><div class="message-bubble bot-response-area"></div><div class="bot-sources-area"></div></div>`;
            chatArea.appendChild(div);
            scrollToBottom();

            const botResponseArea = div.querySelector('.bot-response-area');
            const botSourcesArea = div.querySelector('.bot-sources-area');
            
            let fullText = "";
            let allSources = [];
            let buffer = "";

            try {
                // Direct request to the external AI API
                const response = await fetch(`${API_URL.replace(/\/$/, '')}/query/stream`, {
                    method: 'POST',
                    headers: { 
                        'Accept': 'text/event-stream', 
                        'Content-Type': 'application/json',
                        'X-API-Key': API_KEY
                    },
                    body: JSON.stringify({ question: message })
                });

                if (!response.ok) throw new Error('Erro na comunicação direta com a API.');

                const reader = response.body.getReader();
                const decoder = new TextDecoder();
                const msgHash = Math.random().toString(36).substr(2, 6);

                while (true) {
                    const { done, value } = await reader.read();
                    if (done) break;

                    buffer += decoder.decode(value, { stream: true });
                    const lines = buffer.split("\n");
                    buffer = lines.pop(); // Keep incomplete line in buffer

                    for (const line of lines) {
                        if (line.startsWith("data: ")) {
                            const data = line.substring(6).trim();
                            if (!data || data === "[DONE]") continue;

                            try {
                                const payload = JSON.parse(data);

                                if (payload.type === 'sources') {
                                    allSources = payload.data?.sources || payload.sources || [];
                                    renderSources(botSourcesArea, allSources, msgHash);
                                } else {
                                    // Tenta extrair texto de vários formatos possíveis
                                    const content = payload.data?.content || payload.data || payload.content || (typeof payload === 'string' ? payload : "");
                                    
                                    if (content && typeof content === 'string') {
                                        fullText += content;
                                        typingIndicator.style.display = 'none';
                                        
                                        // Update Text with citations
                                        let formatted = fullText.replace(/\n/g, '<br>').replace(/\*\*(.*?)\*\*/g, '<b>$1</b>');
                                        formatted = applyCitations(formatted, msgHash);
                                        botResponseArea.innerHTML = formatted;
                                        scrollToBottom();
                                    }
                                }
                            } catch (e) {
                                // Se não for JSON válido, tenta tratar como texto puro (fallback)
                                if (data && typeof data === 'string') {
                                    fullText += data;
                                    typingIndicator.style.display = 'none';
                                    let formatted = fullText.replace(/\n/g, '<br>').replace(/\*\*(.*?)\*\*/g, '<b>$1</b>');
                                    formatted = applyCitations(formatted, msgHash);
                                    botResponseArea.innerHTML = formatted;
                                    scrollToBottom();
                                }
                            }
                        }
                    }
                }

            } catch (error) {
                console.error('Erro:', error);
                botResponseArea.innerHTML = `<span style="color: #dc2626;"><i class="fa-solid fa-triangle-exclamation"></i> Erro ao processar. Tente novamente.</span>`;
            } finally {
                sendBtn.disabled = false;
                typingIndicator.style.display = 'none';
                messageInput.focus();
            }
        }

        function applyCitations(text, msgHash) {
            return text.replace(/\[([\d,\s\-]+)\]/g, function (match, inner) {
                const numbers = inner.split(/[,\-]/).map(n => n.trim()).filter(n => !isNaN(n) && n !== '');
                let badges = '';
                numbers.forEach(num => {
                    badges += `<a href="#source-${msgHash}-${num}" class="citation-badge" title="Fonte ${num}" onclick="event.preventDefault(); document.getElementById('source-${msgHash}-${num}')?.scrollIntoView({behavior: 'smooth', block: 'center'});">${num}</a>`;
                });
                return badges ? badges : match;
            });
        }

        function renderSources(container, sources, msgHash) {
            if (!sources || sources.length === 0) {
                container.innerHTML = "";
                return;
            }

            let html = '<div class="mt-3"><h4 style="font-size: 0.75rem; font-weight: 600; color: #4b5563; text-transform: uppercase; margin-bottom: 0.5rem;">Fontes Consultadas</h4><div class="sources-grid">';
            sources.forEach((src, index) => {
                const num = index + 1;
                const title = src.title || `Fonte ${num}`;
                const snippet = src.brief || src.snippet || src.content_preview || '';
                const journal = src.journal || src.journal_name || '';
                const link = src.link || src.url || null;

                html += `
                    <div class="source-card ${link ? 'has-link' : ''}" id="source-${msgHash}-${num}" ${link ? `onclick="window.open('${link}', '_blank')"` : ''}>
                        <div>
                            <div style="display: flex; align-items: flex-start; margin-bottom: 0.5rem;">
                                <span class="source-card-number">${num}</span>
                                <h5 class="source-card-title">${title}</h5>
                            </div>
                            <p class="source-card-snippet">${snippet}</p>
                            <div class="source-card-meta">
                                ${src.authors ? `<span style="display:block; margin-bottom: 2px;"><b>Autores:</b> ${src.authors}</span>` : ''}
                                ${journal ? `<span>${journal}</span>` : ''}
                            </div>
                        </div>
                        <div class="source-card-footer">${link ? 'Abrir Artigo' : 'Sem link'}</div>
                    </div>`;
            });
            html += '</div></div>';
            container.innerHTML = html;
        }

        // Controle de Acesso: Dispara o modal se não estiver permitido
        document.addEventListener('DOMContentLoaded', function() {
            @if($modalConteudo !== 'permitido')
                const modalId = '{{ $modalConteudo }}';
                const modalElement = document.getElementById(modalId);
                if (modalElement) {
                    const modal = new bootstrap.Modal(modalElement, {
                        backdrop: 'static',
                        keyboard: false
                    });
                    modal.show();
                }
            @endif
        });
    </script>

@endsection