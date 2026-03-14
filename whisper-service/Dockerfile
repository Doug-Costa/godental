# Build stage
FROM python:3.11-slim

# Install system dependencies
RUN apt-get update && apt-get install -y \
    ffmpeg \
    && rm -rf /var/lib/apt/lists/*

# Set working directory
WORKDIR /app

# Install Python dependencies
# Using --no-cache-dir to keep image size small
RUN pip install --no-cache-dir \
    fastapi \
    uvicorn \
    python-multipart \
    faster-whisper

# Copy application code
COPY . .

# Set Environment variables
ENV ENVIRONMENT=development
ENV WHISPER_MODEL=small
ENV MAX_FILE_SIZE_MB=100

# Expose port
EXPOSE 9001

# Run the application
CMD ["uvicorn", "main:app", "--host", "0.0.0.0", "--port", "9001"]
