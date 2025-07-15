document.addEventListener('DOMContentLoaded', function() {
    // Referencias a los elementos
    const cameraView = document.getElementById('camera-view');
    const cameraCanvas = document.getElementById('camera-canvas');
    const captureButton = document.getElementById('capture-button');
    const switchCameraButton = document.getElementById('switch-camera');
    const photoPreview = document.getElementById('photo-preview');
    const uploadButton = document.getElementById('upload-button');
    const retakeButton = document.getElementById('retake-button');
    const controls = document.getElementById('controls');
    const statusDiv = document.getElementById('status');
    
    // Variables para la cámara
    let cameraStream = null;
    let facingMode = 'user'; // 'user' es cámara frontal, 'environment' es cámara trasera
    let photoBlob = null;
    
    // Comprobar si hay múltiples cámaras
    navigator.mediaDevices.enumerateDevices()
        .then(devices => {
            const videoDevices = devices.filter(device => device.kind === 'videoinput');
            if (videoDevices.length > 1) {
                switchCameraButton.style.display = 'inline-block';
            }
        });
    
    // Iniciar la cámara
    async function initCamera() {
        // Detener cualquier stream existente
        if (cameraStream) {
            cameraStream.getTracks().forEach(track => track.stop());
        }
        
        try {
            cameraStream = await navigator.mediaDevices.getUserMedia({ 
                video: { facingMode: facingMode }, 
                audio: false 
            });
            cameraView.srcObject = cameraStream;
            
            // Mostrar mensaje de éxito
            showStatus('Cámara iniciada correctamente', 'success');
        } catch (error) {
            console.error('Error accediendo a la cámara:', error);
            showStatus('Error al acceder a la cámara: ' + error.message, 'error');
        }
    }
    
    // Cambiar entre cámaras frontal y trasera
    switchCameraButton.addEventListener('click', function() {
        facingMode = facingMode === 'user' ? 'environment' : 'user';
        initCamera();
    });
    
    // Tomar la foto
    captureButton.addEventListener('click', function() {
        if (cameraStream) {
            // Configurar el tamaño del canvas según el video
            cameraCanvas.width = cameraView.videoWidth;
            cameraCanvas.height = cameraView.videoHeight;
            
            // Dibujar la imagen del video en el canvas
            const context = cameraCanvas.getContext('2d');
            context.drawImage(cameraView, 0, 0, cameraCanvas.width, cameraCanvas.height);
            
            // Convertir a blob
            cameraCanvas.toBlob(function(blob) {
                photoBlob = blob;
                photoPreview.src = URL.createObjectURL(blob);
                photoPreview.style.display = 'block';
                
                // Mostrar controles y ocultar botón de captura
                controls.style.display = 'block';
                captureButton.style.display = 'none';
                switchCameraButton.style.display = 'none';
            }, 'image/jpeg', 0.9);
        }
    });
    
    // Volver a tomar la foto
    retakeButton.addEventListener('click', function() {
        photoPreview.style.display = 'none';
        controls.style.display = 'none';
        captureButton.style.display = 'inline-block';
        
        // Mostrar el botón de cambio de cámara si hay múltiples cámaras
        navigator.mediaDevices.enumerateDevices()
            .then(devices => {
                const videoDevices = devices.filter(device => device.kind === 'videoinput');
                if (videoDevices.length > 1) {
                    switchCameraButton.style.display = 'inline-block';
                }
            });
    });
    
    // Subir la foto
    uploadButton.addEventListener('click', function() {
        if (photoBlob) {
            uploadPhoto(photoBlob);
        }
    });
    
    // Función para enviar la foto al servidor
    function uploadPhoto(photoBlob) {
        const formData = new FormData();
        formData.append('photo', photoBlob, 'photo.jpg');
        
        // Mostrar estado
        showStatus('Enviando foto al servidor...', '');
        
        // Enviar al servidor
        fetch('subir_foto.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            console.log('Respuesta del servidor:', data);
            if (data.success) {
                showStatus('Foto guardada correctamente: ' + data.filename, 'success');
            } else {
                showStatus('Error al guardar la foto: ' + data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showStatus('Error al enviar la foto: ' + error.message, 'error');
        });
    }
    
    // Mostrar mensaje de estado
    function showStatus(message, type) {
        statusDiv.textContent = message;
        statusDiv.style.display = 'block';
        
        // Quitar clases anteriores
        statusDiv.classList.remove('success', 'error');
        
        // Añadir clase según el tipo
        if (type) {
            statusDiv.classList.add(type);
        }
    }
    
    // Iniciar la cámara al cargar la página
    initCamera();
});