
function mostrarSelect() {
  const tipo = document.getElementById('tipo').value;
  const comunidadDiv = document.getElementById('comunidadDiv');
  const ubchDiv = document.getElementById('ubchDiv');
  const comunidadSelect = document.getElementById('comunidad');
  const ubchSelect = document.getElementById('ubch');
  // const jefeDiv = document.getElementById('jefeDiv');
  // const jefeInput = document.getElementById('jefe');

  // Ocultar todo
  comunidadDiv.style.display = 'none';
  ubchDiv.style.display = 'none';
  comunidadSelect.required = false;
  ubchSelect.required = false;
  // jefeInput.value = '';
  // jefeDiv.style.display = 'none';

  // Mostrar según tipo
  if (tipo === 'Comunidad') {
    comunidadDiv.style.display = 'block';
    comunidadSelect.required = true;
  } else if (tipo === 'UBCH') {
    ubchDiv.style.display = 'block';
    ubchSelect.required = true;
  }
}

// function mostrarJefe(tipo) {
//   const select = document.getElementById(tipo);
//   const selectedOption = select.options[select.selectedIndex];
//   const jefe = selectedOption?.getAttribute('data-jefe') || '';
//   const jefeDiv = document.getElementById('jefeDiv');
//   const jefeInput = document.getElementById('jefe');

//   if (jefe.trim() !== '') {
//     jefeInput.value = jefe;
//     jefeDiv.style.display = 'block';
//   } else {
//     jefeInput.value = '';
//     jefeDiv.style.display = 'none';
//   }
// }
