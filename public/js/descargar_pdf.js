  document.getElementById('descargar_pdf').addEventListener('click', async () => {
    const btn = document.getElementById('descargar_pdf');
    const cartaUrl = btn.getAttribute('data-url');

    try {
      const response = await fetch(cartaUrl);
      if (!response.ok) throw new Error('No se pudo obtener la imagen');

      const blob = await response.blob();
      const reader = new FileReader();

      reader.onloadend = () => {
        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF();

        const img = new Image();
        img.onload = () => {
          const pageWidth = pdf.internal.pageSize.getWidth();
          const pageHeight = pdf.internal.pageSize.getHeight();
          const ratio = Math.min(pageWidth / img.width, pageHeight / img.height);
          const imgWidth = img.width * ratio;
          const imgHeight = img.height * ratio;
          const x = (pageWidth - imgWidth) / 2;
          const y = (pageHeight - imgHeight) / 2;

          pdf.addImage(reader.result, 'JPEG', x, y, imgWidth, imgHeight);
          pdf.save('carta.pdf');
        };
        img.src = reader.result;
      };

      reader.readAsDataURL(blob);
    } catch (error) {
      console.error('Error al generar el PDF:', error);
      alert('No se pudo descargar la carta. Verifica que el archivo esté disponible.');
    }
  });

