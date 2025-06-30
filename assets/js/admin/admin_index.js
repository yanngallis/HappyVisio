import '/assets/js/admin/custom/sparkline.js'
import { Calendar } from 'fullcalendar'
import frLocale from '@fullcalendar/core/locales/fr'

$(function () {
    const calendarEl = document.getElementById('calendar')
    const calendar = new Calendar(calendarEl, {
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
        },
        locale: frLocale,
        defaultView: 'month',
        navLinks: true,
        editable: true,
        selectable: true,
        droppable: false,
        events: calendar_route,
    })

    calendar.render()
});