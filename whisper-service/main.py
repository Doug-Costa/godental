import os
import time
import io
from typing import Optional
from fastapi import FastAPI, UploadFile, File, HTTPException, Header, Depends
from faster_whisper import WhisperModel

app = FastAPI(
    title="Whisper Service - Faster-Whisper",
    description="Serviço de transcrição otimizado para CPU usando Faster-Whisper",
    version="2.0.0"
)

# Configuration
WHISPER_MODEL = os.getenv("WHISPER_MODEL", "small")
ENVIRONMENT = os.getenv("ENVIRONMENT", "development")
API_KEY = os.getenv("API_KEY", "")
MAX_FILE_SIZE_MB = int(os.getenv("MAX_FILE_SIZE_MB", "100"))

# Global model variable
model = None

@app.on_event("startup")
def load_model():
    global model
    print(f"Carregando modelo Faster-Whisper: {WHISPER_MODEL}...")
    # Load model with optimizations for CPU
    model = WhisperModel(
        WHISPER_MODEL, 
        device="cpu", 
        compute_type="int8", 
        cpu_threads=2,
        download_root="/root/.cache/whisper"
    )
    print("Modelo carregado com sucesso!")

def verify_api_key(x_api_key: Optional[str] = Header(None)):
    if ENVIRONMENT == "production":
        if not API_KEY:
            raise HTTPException(status_code=500, detail="API_KEY não configurada no servidor.")
        if x_api_key != API_KEY:
            raise HTTPException(status_code=401, detail="X-API-Key inválida ou ausente.")
    return x_api_key

@app.get("/health")
def health_check():
    return {
        "status": "ok",
        "model": WHISPER_MODEL,
        "ready": model is not None,
        "environment": ENVIRONMENT,
        "engine": "faster-whisper"
    }

@app.post("/transcribe")
async def transcribe_audio(
    file: UploadFile = File(...),
    auth: str = Depends(verify_api_key)
):
    print(f"Recebendo arquivo: {file.filename}")
    if not model:
        raise HTTPException(status_code=503, detail="Modelo Whisper ainda não carregado.")

    try:
        # Check file size
        print("Lendo conteúdo do arquivo...")
        file_content = await file.read()
        size_mb = len(file_content) / (1024 * 1024)
        print(f"Tamanho do arquivo: {size_mb:.2f} MB")
        
        if size_mb > MAX_FILE_SIZE_MB:
            raise HTTPException(status_code=413, detail=f"Arquivo muito grande. Máximo permitido: {MAX_FILE_SIZE_MB}MB")

        start_time = time.time()
        
        # Audio buffer for memory processing
        print("Criando buffer de áudio...")
        audio_data = io.BytesIO(file_content)

        # Dental technical vocabulary prompt
        dental_prompt = (
            "Olá, esta é uma consulta odontológica profissional. Vamos falar sobre: "
            "necrose pulpar, cárie, higiene bucal, gengiva, dentes, arcada dentária, "
            "prontuário clínico, anamnese, diagnóstico, prognóstico, plano de tratamento, "
            "exodontia, implantes, periodontia, endodontia, restauração, resina, amálgama, "
            "paciente, clínico, consulta, retorno, entrada, dor no dente, sensibilidade térmica, "
            "bruxismo, canal, coroa, ponte, faceta, alinhador, ortodontia, limpeza, profilaxia, "
            "tártaro, placa bacteriana, raspagem, restauração de resina, extração."
        )

        # Transcribe using Faster-Whisper API
        print("Iniciando transcrição com Faster-Whisper...")
        segments, info = model.transcribe(
            audio_data,
            language="pt",
            initial_prompt=dental_prompt,
            vad_filter=True,
            vad_parameters=dict(min_silence_duration_ms=500),
            beam_size=5
        )

        print(f"Transcrição detectada linguagem: {info.language}")
        # Consuming generator to get all text
        full_text = []
        segments_data = []
        for segment in segments:
            print(f"Processando segmento: {segment.start:.2f}s - {segment.end:.2f}s")
            full_text.append(segment.text)
            segments_data.append({
                "start": segment.start,
                "end": segment.end,
                "text": segment.text.strip()
            })

        processing_time = time.time() - start_time
        print(f"Transcrição concluída em {processing_time:.2f} segundos.")

        return {
            "text": "".join(full_text).strip(),
            "language": info.language,
            "processing_seconds": round(processing_time, 2),
            "file_size_mb": round(size_mb, 2),
            "segments": segments_data
        }

    except Exception as e:
        import traceback
        print(f"Erro na transcrição: {str(e)}")
        traceback.print_exc()
        raise HTTPException(status_code=500, detail=str(e))

if __name__ == "__main__":
    import uvicorn
    uvicorn.run(app, host="0.0.0.0", port=9001)
