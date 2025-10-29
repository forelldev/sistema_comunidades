
function mostrarMensaje(mensaje, tipo = 'info', duracion = 3000) {
    // Elimina mensaje anterior si existe
    const anterior = document.querySelector('.mensaje-flotante');
    if (anterior) anterior.remove();

    // Crea el contenedor del mensaje
    const div = document.createElement('div');
    div.className = `alert alert-${tipo === 'error' ? 'danger' : 'primary'} text-center fw-semibold shadow-lg`;
    div.textContent = mensaje;

    // Estilos flotante mejorados para login y sobreponer arriba de todo

    div.style.position = 'fixed';
    div.style.top = '0';
    div.style.left = '50%';
    div.style.transform = 'translateX(-50%)';
    div.style.zIndex = '2147483647';
    div.style.padding = '0.75rem 1.5rem';
    div.style.borderRadius = '0 0 1rem 1rem';
    div.style.maxWidth = '90vw';
    div.style.width = 'auto';
    div.style.boxSizing = 'border-box';
    div.style.pointerEvents = 'none';
    div.style.fontSize = '1rem';
    div.style.opacity = '0.95';
    div.style.transition = 'top 0.4s ease, opacity 0.4s ease';


    document.body.appendChild(div);

    setTimeout(() => {
        div.remove();
    }, duracion);
}