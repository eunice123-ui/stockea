document.addEventListener('DOMContentLoaded', function () {
    let calendarEl = document.getElementById('calendar');

    let calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listWeek'
        },
        editable: true,
        selectable: true,
        events: 'eventos.php',
        eventClick: function(info) {
            alert("📌 Evento: " + info.event.title + "\nDescripción: " + info.event.extendedProps.descripcion);
        },
        dateClick: function(info) {
            let titulo = prompt("Título del evento:");
            if (titulo) {
                calendar.addEvent({
                    title: titulo,
                    start: info.dateStr,
                    color: "#74c69d"
                });
            }
        }
    });

    calendar.render();
});

