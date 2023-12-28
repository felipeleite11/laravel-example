$('select').formSelect()

$('.modal').modal()

$('.tooltipped').tooltip()

$('.sidenav').sidenav()

$('.collapsible').collapsible()

$('.datepicker')
    .not('.birthdate, .future')
    .datepicker(getDatepickerSetup())

$('.datepicker.birthdate').datepicker({
    ...getDatepickerSetup(),
    yearRange: [1930, new Date().getFullYear()]
})

$('.datepicker.future').datepicker({
    ...getDatepickerSetup(),
    minDate: new Date()
})

$('.datepicker.month-only').datepicker({
    ...getDatepickerSetup(),
    format: 'mm/yyyy'
})

$('.timepicker').timepicker({
    container: 'body',
    autoClose: true,
    twelveHour: false,
    i18n: {
        cancel: 'Fechar',
        done: ''
    }
})

function getDatepickerSetup() {
    return {
        container: $('body'),
        format: 'yyyy-mm-dd',
        autoClose: true,
        i18n: {
            cancel: 'Fechar',
            done: '',
            months: [
                'Janeiro',
                'Fevereiro',
                'Março',
                'Abril',
                'Maio',
                'Junho',
                'Julho',
                'Agosto',
                'Setembro',
                'Outubro',
                'Novembro',
                'Dezembro'
            ],
            monthsShort: [
                'Jan',
                'Fev',
                'Mar',
                'Abr',
                'Mai',
                'Jun',
                'Jul',
                'Ago',
                'Set',
                'Out',
                'Nov',
                'Dez'
            ],
            weekdays: [
                'Domingo',
                'Segunda-feira',
                'Terça-feira',
                'Quarta-feira',
                'Quinta-feira',
                'Sexta-feira',
                'Sábado'
            ],
            weekdaysShort: [
                'Dom',
                'Seg',
                'Ter',
                'Qua',
                'Qui',
                'Sex',
                'Sab'
            ],
            weekdaysAbbrev: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S']
        }
    }
}
