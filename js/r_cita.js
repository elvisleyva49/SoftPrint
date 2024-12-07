// citas.js
document.addEventListener('DOMContentLoaded', (event) => {
    const fechaInput = document.getElementById('fecha');
    const horarioSelect = document.getElementById('horario');
    const citasTableBody = document.getElementById('citasTableBody');

    // Establecer la fecha mínima y el valor inicial
    const today = new Date();
    const year = today.getFullYear();
    const month = String(today.getMonth() + 1).padStart(2, '0');
    const day = String(today.getDate()).padStart(2, '0');
    const todayFormatted = `${year}-${month}-${day}`;
    fechaInput.setAttribute('min', todayFormatted);
    fechaInput.value = todayFormatted;

    // Deshabilitar horarios ocupados para la fecha actual
    const horariosOcupados = window.horariosOcupados; // Obtener los horarios ocupados desde la variable global
    Array.from(horarioSelect.options).forEach(option => {
        if (horariosOcupados.includes(option.value)) {
            option.disabled = true; // Deshabilita la opción si está ocupada
        }
    });

    // Agregar el evento change para buscar citas
    fechaInput.addEventListener('change', () => {
        const selectedDate = fechaInput.value;
        console.log('Fecha seleccionada:', selectedDate);

        // Realizar la búsqueda de citas mediante AJAX
        fetch(`../controladores/ControladorCita.php?accion=obtenerHistorial&fecha=${selectedDate}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta de la red');
                }
                return response.json();
            })
            .then(data => {
                console.log('Datos recibidos:', data); // Para depuración
                // Limpiar el contenido anterior
                citasTableBody.innerHTML = '';

                // Limpiar el select de horarios
                horarioSelect.selectedIndex = 0; // Resetea la selección
                Array.from(horarioSelect.options).forEach(option => {
                    option.disabled = false; // Habilita todas las opciones antes de deshabilitar las ocupadas
                });

                // Llenar la tabla con los nuevos datos y deshabilitar horarios ocupados
                const nuevosHorariosOcupados = [];
                data.forEach(cita => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${cita.fecha}</td>
                        <td>${cita.horario}</td>
                        <td>${cita.estado}</td>
                    `;
                    citasTableBody.appendChild(row);
                    nuevosHorariosOcupados.push(cita.horario); // Almacenar horarios ocupados
                });

                // Deshabilitar opciones de horarios ocupados en el select
                Array.from(horarioSelect.options).forEach(option => {
                    if (nuevosHorariosOcupados.includes(option.value)) {
                        option.disabled = true; // Deshabilita la opción si está ocupada
                    }
                });
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });
});
