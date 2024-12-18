
document.addEventListener("DOMContentLoaded", function() {
    const phases = document.querySelectorAll('.phase');

    phases.forEach(phase => {
        phase.querySelector('h2').addEventListener('click', function() {
            phase.classList.toggle('active');

            if (phase.id === 'Gremio' && phase.classList.contains('active')) {
                loadImages();
            }
        });
    });

    function loadImages() {
        const gallery = document.getElementById('image-gallery');
        
        if (gallery) { // Verifica se as imagens já foram carregadas
            const images = [
                {
                    src: "https://upload.wikimedia.org/wikipedia/commons/thumb/4/4f/Gremio_x_Lanus_2017_%28cropped%29.jpg/640px-Gremio_x_Lanus_2017_%28cropped%29.jpg",
                    alt: "Grêmio Campeão - Jogo da Final"
                },
                {
                    src: "https://upload.wikimedia.org/wikipedia/commons/thumb/a/a8/Gr%C3%AAmio_-_Copa_Libertadores_2017.jpg/640px-Gr%C3%AAmio_-_Copa_Libertadores_2017.jpg",
                    alt: "Grêmio Campeão - Levantando a Taça"
                },
                {
                    src: "https://upload.wikimedia.org/wikipedia/commons/thumb/c/c0/Torcida_Gremio_CopaLibertadores2017.jpg/640px-Torcida_Gremio_CopaLibertadores2017.jpg",
                    alt: "Torcida do Grêmio Celebrando"
                }
            ];

            images.forEach(imageData => {
                const img = document.createElement('img');
                img.src = imageData.src;
                img.alt = imageData.alt;
                gallery.appendChild(img);
            });
        }
    }
});
