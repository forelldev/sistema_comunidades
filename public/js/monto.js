function obtenerMontoTotal() {
  const tipo = document.getElementById('tipo').value;
  let valor = '';

  if (tipo === 'Comunidad') {
    valor = document.getElementById('comunidad').value;
  } else if (tipo === 'UBCH') {
    valor = document.getElementById('ubch').value;
  }

  const montoInput = document.getElementById('monto_total');
  const totalH1 = document.getElementById('total');
  const tarjetasContenedor = document.getElementById('tarjetas_solicitudes');

  if (!valor) {
    montoInput.value = '';
    totalH1.textContent = '';
    tarjetasContenedor.innerHTML = '';
    return;
  }

  fetch(BASE_B + '/modelo/montos_fetch.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `tipo=${encodeURIComponent(tipo)}&valor=${encodeURIComponent(valor)}`
  })
  .then(response => response.json())
  .then(data => {
    const montoFormateado = new Intl.NumberFormat('es-VE').format(data.total || 0);
    montoInput.value = montoFormateado;

    const totalFilas = Array.isArray(data.datos) ? data.datos.length : 0;
    totalH1.textContent = `Total de solicitudes encontradas: ${totalFilas}`;

    tarjetasContenedor.innerHTML = '';

    if (totalFilas > 0) {
      data.datos.forEach(doc => {
        const tarjeta = document.createElement('div');
        tarjeta.className = 'col-md-6 col-lg-5 d-flex';

        const fechaFormateada = doc.fecha
          ? new Date(doc.fecha).toLocaleDateString('es-VE', { day: '2-digit', month: '2-digit', year: 'numeric' })
          : 'Sin fecha';

        tarjeta.innerHTML = `
          <div class="card shadow-sm border rounded-3 h-100 w-100 mx-auto fondo-logo">
            <div class="card-body d-flex flex-column justify-content-between contenido-superior">
              <div>
                <div class="text-center mb-4">
                  <img src="${BASE_B}/img/logo.png" alt="Logo" class="mb-2" style="max-height: 100px; width: auto;">
                </div>
                <h6 class="fw-semibold text-primary mb-2">#${doc.id_doc} - ${doc.descripcion}</h6>
                <p class="mb-1"><strong>Comunidad:</strong> ${doc.comunidad}</p>
                <p class="mb-1"><strong>Monto:</strong> ${doc.monto == 0 ? 'Sin Monto Aproximado' : new Intl.NumberFormat('es-VE').format(doc.monto) + ' $'}</p>
                <p class="mb-1"><strong>Fecha:</strong> ${fechaFormateada}</p>
              </div>
              <div class="d-flex justify-content-between">
                <a href="${BASE_B}/editar?id=${doc.id_doc}" class="btn btn-outline-info btn-sm rounded-pill px-3 fw-normal">Editar</a>
                <a href="${BASE_B}/cartas/${encodeURIComponent(doc.ubicacion || '')}" target="_blank" class="btn btn-outline-secondary btn-sm rounded-pill px-3 fw-normal">Ver Carta</a>
              </div>
            </div>
          </div>
        `;

        tarjetasContenedor.appendChild(tarjeta);
      });
    } else {
      tarjetasContenedor.innerHTML = `<p class="text-center text-muted">No se encontraron solicitudes.</p>`;
    }
  })
  .catch(() => {
    montoInput.value = 'Error';
    totalH1.textContent = '';
    tarjetasContenedor.innerHTML = '';
  });
}

document.getElementById('comunidad').addEventListener('change', obtenerMontoTotal);
document.getElementById('ubch').addEventListener('change', obtenerMontoTotal);
