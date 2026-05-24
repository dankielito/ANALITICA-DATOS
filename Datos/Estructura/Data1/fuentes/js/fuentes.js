function mostrarFuente(tipo) {
    let titulo, texto, cita, url;

    switch(tipo) {
        case 'inegi':
            titulo = 'INEGI - ENBIARE 2021';
            texto = 'Proporciona la base demográfica de mascotas en hogares. Reporta que el 69.8% de los hogares en México cuentan con algún tipo de mascota.';
            cita = 'Instituto Nacional de Estadística y Geografía. (2021). Encuesta Nacional de Bienestar Autorreportado (ENBIARE) 2021. https://www.inegi.org.mx/programas/enbiare/2021/';
            url = 'https://www.inegi.org.mx/programas/enbiare/2021/';
            break;
        case 'ssa':
            titulo = 'Secretaría de Salud (SSA)';
            texto = 'Datos sobre zoonosis y control animal. Estima que de los 27 millones de perros y gatos en México, el 70% se encuentra en situación de calle.';
            cita = 'Secretaría de Salud. (2026). Boletín Epidemiológico: Situación de la fauna urbana y salud pública en México. Gobierno de México.';
            url = 'https://www.gob.mx/salud';
            break;
        case 'ammvvee':
            titulo = 'AMMVEE México';
            texto = 'Asociación Mexicana de Médicos Veterinarios Especialistas en Pequeñas Especies. Aporta datos sobre tasas de reproducción y éxito de campañas de esterilización.';
            cita = 'AMMVEE. (2025). Reporte Anual sobre Abandono y Bienestar Animal en Zonas Metropolitanas. Asociación Mexicana de Médicos Veterinarios.';
            url = 'https://ammvepe.com.mx/';
            break;
    }

    Swal.fire({
        title: `<span style="color:#01833d; font-weight:bold;">${titulo}</span>`,
        html: `
            <div style="text-align: left; font-size: 0.95rem; color: #000;">
                <p><strong>Hallazgo clave:</strong> ${texto}</p>
                <hr style="border: 0; border-top: 1px solid #ffd600; margin: 15px 0;">
                <p><strong>Cita APA 7:</strong><br><small><em>${cita}</em></small></p>
            </div>
        `,
        icon: 'info',
        confirmButtonText: 'Cerrar',
        confirmButtonColor: '#01833d',
        footer: `<a href="${url}" target="_blank" style="color: #01833d; font-weight:bold; text-decoration:none;">Ir al sitio oficial →</a>`,
        didOpen: () => {
            const popup = Swal.getPopup();
            const icon = Swal.getIcon();
            
            // --- CONFIGURACIÓN INICIAL (Verde) ---
            popup.style.border = '6px solid #01833d';
            popup.style.boxShadow = '0 0 20px #01833d';
            popup.style.transition = 'all 1.5s ease'; // Transición para todas las propiedades
            
            if(icon) {
                icon.style.borderColor = '#01833d';
                icon.style.color = '#01833d';
                icon.style.transition = 'all 1.5s ease';
            }

            // --- CICLO DE CAMBIO SINCRONIZADO ---
            let toggle = false;
            const intervalId = setInterval(() => {
                if (Swal.isVisible()) {
                    const color = toggle ? '#01833d' : '#ffd600';
                    
                    // Aplicar color al contorno
                    popup.style.borderColor = color;
                    popup.style.boxShadow = `0 0 20px ${color}`;
                    
                    // Aplicar color al icono simultáneamente
                    if(icon) {
                        icon.style.borderColor = color;
                        icon.style.color = color;
                    }
                    
                    toggle = !toggle;
                } else {
                    clearInterval(intervalId);
                }
            }, 1500);
        }
    });
}