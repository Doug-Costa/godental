<!-- MODAL GRAVAÇÃO (DARK MODE) -->
<div class="modal fade" id="modalGoClinicRecording" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1"
    aria-hidden="true" style="z-index: 100001;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="background: #121212; color: #fff; border-radius: 30px;">
            <div class="modal-body p-5 text-center">
                <div class="mb-4">
                    <h4 class="fw-bold mb-0" style="color: #CA1D53;">GoClinic</h4>
                    <p class="text-secondary small">by DentalGO</p>
                </div>

                <div class="d-flex justify-content-center align-items-center mb-5" style="height: 200px;">
                    <div id="visualizer-container"
                        class="position-relative d-flex justify-content-center align-items-center">
                        <canvas id="recordingCanvas" width="300" height="300"
                            style="width: 250px; height: 250px;"></canvas>
                        <div id="recordingBadge" class="position-absolute badge rounded-pill bg-danger d-none"
                            style="top: -20px;">
                            GRAVANDO
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <h1 id="recordingTimer" class="display-3 fw-bold mb-0" style="font-family: monospace;">00:00</h1>
                </div>

                <div class="mb-5 px-3" style="max-height: 100px; overflow-y: auto;">
                    <p id="liveTranscript" class="text-light opacity-75 small italic">Aguardando voz...</p>
                </div>

                <div class="d-flex justify-content-center gap-4 align-items-center">
                    <button id="btnRecordingPause"
                        class="btn btn-outline-light rounded-circle p-3 d-flex align-items-center justify-content-center"
                        style="width: 60px; height: 60px;">
                        <i class="bi bi-pause-fill fs-3"></i>
                    </button>
                    <button id="btnRecordingStop"
                        class="btn btn-danger rounded-circle p-4 d-flex align-items-center justify-content-center shadow-lg"
                        style="width: 90px; height: 90px;">
                        <i class="bi bi-stop-fill fs-1"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes pulse-red {
        0% {
            opacity: 1;
            transform: scale(1);
        }

        50% {
            opacity: 0.5;
            transform: scale(1.1);
        }

        100% {
            opacity: 1;
            transform: scale(1);
        }
    }

    #modalGoClinicRecording .modal-content {
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        background: #121212 !important;
        border: 2px solid #CA1D53 !important;
        box-shadow: 0 0 60px rgba(202, 29, 83, 0.4) !important;
    }

    #recordingBadge {
        animation: pulse-red 1.5s infinite;
    }

    /* Estilos Globais de Modal removidos em favor de master.blade.php */
</style>

<script>
    (function () {
        console.log("GoClinic Block: RUNNING");

        function initGoClinic() {
            // Element-based guard: Prevents double-init on the same button instance
            const btnCheck = document.getElementById('btnIniciarEscuta');
            if (btnCheck && btnCheck.dataset.goClinicInitialized === 'true') {
                console.log("GoClinic: Already initialized on this element (Skipping)");
                return;
            }
            if (btnCheck) btnCheck.dataset.goClinicInitialized = 'true';

            console.log("GoClinic Block: INITIALIZING...");

            // Global state
            let mediaRecorder;
            let audioChunks = [];
            let startTime, timerInterval;
            let audioContext, analyser, dataArray, animationId;
            let isPaused = false;
            let elapsedTime = 0;
            let recognition;
            let fullTranscript = "";
            let consultationData = {};
            let isSimulating = false;
            let simulationTimer;

            // DentalGO AI phrases for simulation fallback
            const medicalPhrases = [
                "Iniciando avaliação clínica do paciente.",
                "Observada sensibilidade retro-molar no quadrante superior direito.",
                "Paciente relata desconforto térmico ao contato com líquidos gelados.",
                "Presença de restauração infiltrada na face oclusal do dente 16.",
                "Indicação de radiografia panorâmica para planejamento cirúrgico.",
                "Higiene bucal classificada como boa, porém requer profilaxia de rotina.",
                "Paciente concorda com o plano de tratamento proposto."
            ];

            // DOM Elements
            const modalHubEl = document.getElementById('modalGoIntelligence');
            const modalSimpleEl = document.getElementById('modalNovaConsulta');
            const modalRecEl = document.getElementById('modalGoClinicRecording');

            const liveTranscript = document.getElementById('liveTranscript');
            const btnIniciarEscuta = document.getElementById('btnIniciarEscuta');
            const btnRecordingStop = document.getElementById('btnRecordingStop');
            const btnRecordingPause = document.getElementById('btnRecordingPause');
            const recordingTimer = document.getElementById('recordingTimer');
            const recordingBadge = document.getElementById('recordingBadge');

            const patientSearchInput = document.getElementById('patient_search_input');
            const patientIdHidden = document.getElementById('patient_id_hidden');
            const patientIdentifierInput = document.getElementById('patient_identifier_input');
            const patientSearchResults = document.getElementById('patient_search_results');

            if (patientSearchInput) {
                patientSearchInput.addEventListener('input', function () {
                    const query = this.value;
                    if (query.length < 2) {
                        patientSearchResults.classList.add('d-none');
                        return;
                    }

                    fetch("{{ route('patients.search') }}?q=" + encodeURIComponent(query))
                        .then(response => response.json())
                        .then(data => {
                            patientSearchResults.innerHTML = "";
                            if (data.length > 0) {
                                data.forEach(patient => {
                                    const item = document.createElement('button');
                                    item.type = 'button';
                                    item.className = 'list-group-item list-group-item-action border-0 py-2 px-3 small';
                                    item.innerHTML = `<strong>${patient.full_name}</strong><br><span class="text-muted" style="font-size: 0.75rem">${patient.phone || patient.id}</span>`;
                                    item.onclick = () => {
                                        patientSearchInput.value = patient.full_name;
                                        patientIdHidden.value = patient.id;
                                        patientIdHidden.dispatchEvent(new Event('change')); // Trigger event for anamnesis check
                                        patientIdentifierInput.value = patient.phone || "";
                                        patientSearchResults.classList.add('d-none');
                                    };
                                    patientSearchResults.appendChild(item);
                                });
                                patientSearchResults.classList.remove('d-none');
                            } else {
                                patientSearchResults.classList.add('d-none');
                            }
                        });
                });

                document.addEventListener('click', function (e) {
                    if (patientSearchResults && !patientSearchResults.contains(e.target) && e.target !== patientSearchInput) {
                        patientSearchResults.classList.add('d-none');
                    }
                });

                // Anamnesis Flow Logic
                function checkPatientHistory(patientId) {
                    if (!patientId) return;
                    fetch(`/patients/check-history/${patientId}`)
                        .then(response => response.json())
                        .then(data => {
                            const anamnesisAlert = document.getElementById('anamnesis_alert');
                            const anamnesisToggle = document.getElementById('requires_anamnesis_toggle');
                            const section = document.getElementById('anamnesis_section');
                            const alertMsg = document.getElementById('anamnesis_alert_msg');

                            if (section) section.classList.remove('d-none');

                            // Se o paciente não tiver anamnese (novo ou antigo sem registro)
                            if (!data.has_anamnesis) {
                                if (anamnesisAlert) anamnesisAlert.classList.remove('d-none');
                                if (alertMsg) {
                                    alertMsg.innerText = data.is_new ? "Paciente novo: Anamnese recomendada." : "Paciente sem anamnese registrada.";
                                }
                                if (anamnesisToggle) {
                                    anamnesisToggle.checked = true;
                                    anamnesisToggle.dispatchEvent(new Event('change'));
                                }
                            } else {
                                // Já tem anamnese: esconde alerta e deixa toggle desmarcado por padrão (mas disponível)
                                if (anamnesisAlert) anamnesisAlert.classList.add('d-none');
                                if (anamnesisToggle) {
                                    anamnesisToggle.checked = false;
                                    anamnesisToggle.dispatchEvent(new Event('change'));
                                }
                            }
                        });
                }

                if (patientIdHidden) {
                    patientIdHidden.addEventListener('change', function () {
                        checkPatientHistory(this.value);
                    });
                }

                const anamnesisToggle = document.getElementById('requires_anamnesis_toggle');
                const templateSelection = document.getElementById('template_selection');
                const btnSubmit = document.getElementById('btnIniciarEscuta');

                if (anamnesisToggle) {
                    anamnesisToggle.addEventListener('change', function () {
                        if (this.checked) {
                            if (templateSelection) templateSelection.classList.remove('d-none');
                            if (btnSubmit) btnSubmit.innerHTML = '<i class="bi bi-qr-code me-1"></i> Gerar Ficha de Anamnese';
                        } else {
                            if (templateSelection) templateSelection.classList.add('d-none');
                            if (btnSubmit) btnSubmit.innerHTML = '<i class="bi bi-mic-fill me-1"></i> Iniciar Consulta';
                        }
                    });
                }
            }

            // Bootstrap Instances
            let modalHub, modalSimple, modalRec;
            try {
                if (typeof bootstrap !== 'undefined') {
                    if (modalHubEl) modalHub = bootstrap.Modal.getOrCreateInstance(modalHubEl);
                    if (modalSimpleEl) modalSimple = bootstrap.Modal.getOrCreateInstance(modalSimpleEl);
                    if (modalRecEl) modalRec = bootstrap.Modal.getOrCreateInstance(modalRecEl);
                }
            } catch (e) { console.error("GoClinic: UI Init Error", e); }

            // Speech Recognition Setup
            if ('webkitSpeechRecognition' in window || 'SpeechRecognition' in window) {
                const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
                recognition = new SpeechRecognition();
                recognition.continuous = true;
                recognition.interimResults = true;
                recognition.lang = 'pt-BR';

                recognition.onstart = () => { if (liveTranscript) liveTranscript.innerHTML = "Ouvindo... (Microfone ativo)"; };

                recognition.onresult = (event) => {
                    let interimTranscript = "";
                    for (let i = event.resultIndex; i < event.results.length; ++i) {
                        if (event.results[i].isFinal) {
                            fullTranscript += event.results[i][0].transcript + " ";
                        } else {
                            interimTranscript += event.results[i][0].transcript;
                        }
                    }
                    if (liveTranscript) {
                        liveTranscript.innerHTML = `<strong>${fullTranscript}</strong> <span class="text-muted">${interimTranscript}</span>`;
                    }
                };

                recognition.onerror = (event) => {
                    console.error("Speech recognition error:", event.error);
                };

                recognition.onend = () => {
                    if (mediaRecorder && mediaRecorder.state === 'recording' && !isSimulating) {
                        try { recognition.start(); } catch (e) { }
                    }
                };
            }



            if (btnIniciarEscuta) {
                btnIniciarEscuta.addEventListener('click', async function (e) {
                    e.preventDefault();

                    const form = document.getElementById('formNovaConsulta');
                    const formDataJson = new FormData(form);
                    consultationData = Object.fromEntries(formDataJson.entries());

                    if (!consultationData.patient_name) {
                        alert("Preencha o nome do paciente.");
                        return;
                    }

                    // Check for anamnesis flow
                    const anamnesisToggle = document.getElementById('requires_anamnesis_toggle');
                    if (anamnesisToggle && anamnesisToggle.checked) {
                        try {
                            btnIniciarEscuta.disabled = true;
                            btnIniciarEscuta.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Gerando...';

                            const response = await fetch("{{ route('consultations.ajax-store') }}", {
                                method: 'POST',
                                body: new FormData(document.getElementById('formNovaConsulta')),
                                headers: {
                                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                }
                            });
                            const data = await response.json();

                            if (data.db_id) {
                                document.getElementById('formNovaConsulta').classList.add('d-none');
                                btnIniciarEscuta.parentElement.classList.add('d-none');
                                const successUI = document.getElementById('anamnesis_success_ui');
                                successUI.classList.remove('d-none');
                                document.getElementById('anamnesis_link_input').value = data.anamnesis_url;
                                document.getElementById('anamnesis_qrcode_img').src = `https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=${encodeURIComponent(data.anamnesis_url)}`;
                            }
                        } catch (error) {
                            console.error("Erro anamnese:", error);
                            alert("Falha ao gerar ficha de anamnese.");
                        } finally {
                            btnIniciarEscuta.disabled = false;
                            btnIniciarEscuta.innerHTML = '<i class="bi bi-qr-code me-1"></i> Gerar Ficha de Anamnese';
                        }
                        return;
                    }

                    try {
                        btnIniciarEscuta.disabled = true;
                        btnIniciarEscuta.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Iniciando...';

                        const stream = await navigator.mediaDevices.getUserMedia({
                            audio: {
                                echoCancellation: true,
                                noiseSuppression: true,
                                autoGainControl: true
                            }
                        });

                        // Hide whichever modal started this
                        if (modalHub) modalHub.hide();
                        if (modalSimple) modalSimple.hide();

                        setTimeout(() => {
                            if (modalRec) {
                                modalRec.show();
                                startRecording(stream);
                            }
                        }, 400);

                    } catch (error) {
                        alert("Erro microfone: " + error.message);
                    } finally {
                        btnIniciarEscuta.disabled = false;
                        btnIniciarEscuta.innerHTML = '<i class="bi bi-mic-fill me-1"></i> Iniciar Escuta (GoTalks)';
                    }
                });
            }

            function startRecording(stream) {
                mediaRecorder = new MediaRecorder(stream, {
                    mimeType: 'audio/webm',
                    audioBitsPerSecond: 128000
                });
                audioChunks = [];
                fullTranscript = "";
                isSimulating = false;

                mediaRecorder.ondataavailable = event => { if (event.data.size > 0) audioChunks.push(event.data); };
                mediaRecorder.onstop = () => {
                    if (simulationTimer) clearInterval(simulationTimer);
                    const audioBlob = new Blob(audioChunks, { type: 'audio/webm' });
                    stream.getTracks().forEach(track => track.stop());
                    saveMockData(audioBlob);
                };

                mediaRecorder.start();
                if (recognition) {
                    try { recognition.start(); } catch (e) { }
                }

                setupVisualizer(stream);
                startTimer();
                if (recordingBadge) recordingBadge.classList.remove('d-none');
            }

            if (btnRecordingPause) {
                btnRecordingPause.addEventListener('click', function () {
                    if (!isPaused) {
                        mediaRecorder.pause();
                        if (recognition) try { recognition.stop(); } catch (e) { }
                        isPaused = true;
                        btnRecordingPause.innerHTML = '<i class="bi bi-play-fill fs-3"></i>';
                        if (timerInterval) clearInterval(timerInterval);
                    } else {
                        mediaRecorder.resume();
                        if (recognition) try { recognition.start(); } catch (e) { }
                        isPaused = false;
                        btnRecordingPause.innerHTML = '<i class="bi bi-pause-fill fs-3"></i>';
                        startTimer();
                    }
                });
            }

            if (btnRecordingStop) {
                btnRecordingStop.addEventListener('click', function () {
                    if (mediaRecorder && mediaRecorder.state !== 'inactive') mediaRecorder.stop();
                    if (recognition) try { recognition.stop(); } catch (e) { }
                    stopVisualizer();
                    if (timerInterval) clearInterval(timerInterval);
                    if (modalRec) modalRec.hide();
                });
            }

            function startTimer() {
                startTime = Date.now() - elapsedTime;
                timerInterval = setInterval(() => {
                    const time = Date.now() - startTime;
                    elapsedTime = time;
                    const mins = Math.floor(time / 60000).toString().padStart(2, '0');
                    const secs = Math.floor((time % 60000) / 1000).toString().padStart(2, '0');
                    if (recordingTimer) recordingTimer.textContent = `${mins}:${secs}`;
                }, 1000);
            }

            function setupVisualizer(stream) {
                try {
                    audioContext = new (window.AudioContext || window.webkitAudioContext)();
                    analyser = audioContext.createAnalyser();
                    const source = audioContext.createMediaStreamSource(stream);
                    source.connect(analyser);
                    analyser.fftSize = 64;
                    dataArray = new Uint8Array(analyser.frequencyBinCount);
                    const canvas = document.getElementById('recordingCanvas');
                    if (!canvas) return;
                    const ctx = canvas.getContext('2d');
                    function draw() {
                        animationId = requestAnimationFrame(draw);
                        analyser.getByteFrequencyData(dataArray);
                        ctx.clearRect(0, 0, canvas.width, canvas.height);
                        let avg = 0;
                        for (let i = 0; i < dataArray.length; i++) avg += dataArray[i];
                        avg = avg / dataArray.length;
                        const radius = 80 + (avg * 0.5);
                        ctx.beginPath();
                        ctx.arc(canvas.width / 2, canvas.height / 2, radius, 0, Math.PI * 2);
                        ctx.strokeStyle = '#CA1D53';
                        ctx.lineWidth = 5;
                        ctx.stroke();
                        ctx.shadowBlur = avg / 2;
                        ctx.shadowColor = '#CA1D53';
                    }
                    draw();
                } catch (e) { console.error(e); }
            }

            function stopVisualizer() {
                if (animationId) cancelAnimationFrame(animationId);
                if (audioContext && audioContext.state !== 'closed') audioContext.close();
            }

            async function saveMockData(audioBlob) {
                // UI: Show uploading status
                const originalBtnText = btnRecordingStop ? btnRecordingStop.innerHTML : "";
                if (btnRecordingStop) {
                    btnRecordingStop.disabled = true;
                    btnRecordingStop.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
                }

                const metadataFormData = new FormData();
                metadataFormData.append('patient_id', consultationData.patient_id || "");
                metadataFormData.append('patient_name', consultationData.patient_name || "");
                metadataFormData.append('patient_identifier', consultationData.patient_identifier || "");
                metadataFormData.append('consultation_type', consultationData.consultation_type || "");
                metadataFormData.append('observations', consultationData.observations || "");
                metadataFormData.append('duration', recordingTimer ? recordingTimer.textContent : "00:00");
                metadataFormData.append('service_price_id', consultationData.service_price_id || "");
                metadataFormData.append('valor', consultationData.valor || 0);

                try {
                    console.log("GoClinic: Step 1 - Saving Metadata...");
                    // STEP 1: Save metadata first to ensure record existence
                    const metaResponse = await fetch('/mock-save', {
                        method: 'POST',
                        body: metadataFormData,
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                    });

                    if (!metaResponse.ok) throw new Error(`Metadata save failed: ${metaResponse.status}`);

                    const metaResult = await metaResponse.json();
                    if (!metaResult.success) throw new Error("Server rejected metadata");

                    const db_id = metaResult.db_id;
                    console.log("GoClinic: Metadata saved. DB ID:", db_id);

                    // STEP 2: Upload Audio
                    if (audioBlob) {
                        console.log("GoClinic: Step 2 - Uploading Audio file...");
                        const audioFormData = new FormData();
                        audioFormData.append('db_id', db_id);
                        audioFormData.append('audio', audioBlob, 'gravacao.webm');
                        audioFormData.append('id', metaResult.id); // original file id

                        // Note: We don't await this if we want to redirect immediately, 
                        // but it's safer to await to ensure Nginx/PHP received it.
                        const audioResponse = await fetch('/mock-save', {
                            method: 'POST',
                            body: audioFormData,
                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                        });

                        if (!audioResponse.ok) console.warn("Audio upload might have background issues, but metadata is safe.");
                    }

                    // Success: Redirect to the consultation page
                    alert('Consulta criada com sucesso! O áudio está sendo processado em segundo plano e aparecerá no prontuário em instantes.');
                    window.location.href = `/painel-consultas/${db_id}`;

                } catch (error) {
                    console.error("GoClinic Save Error:", error);
                    alert('Erro ao salvar: ' + error.message);
                } finally {
                    if (btnRecordingStop) {
                        btnRecordingStop.disabled = false;
                        btnRecordingStop.innerHTML = originalBtnText;
                    }
                }
            }
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initGoClinic);
        } else {
            initGoClinic();
        }
    })();
</script>