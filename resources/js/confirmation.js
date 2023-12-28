window.confirmation = function confirmation(event, elem) {
    event.preventDefault()

    const confirmed = confirm('Deseja realmente excluir este item?')

    if(confirmed) {
        const { href } = elem

        const position = href.indexOf('/sie')

        const url = href.substring(position)

        window.location.href = url
    }
}
