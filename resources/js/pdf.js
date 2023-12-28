window.handleGeneratePDF = model => {
    const form = $('#form')

    form.prop('action',`/sie/${model}/pdf`)

    form.submit()

    form.prop('action', `/sie/${model}/filter`)
}
