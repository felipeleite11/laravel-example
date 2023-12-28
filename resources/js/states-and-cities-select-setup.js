const stateSelect = $('select[name=state]')
const citySelect = $('select[name=city]')

const defaultStateId = 14
const defaultCityId = 2436

const loadCitiesReady = new CustomEvent('loadCitiesReady')

function loadCities(stateId) {
    citySelect.prop('disabled', true)

    try {
        window.axios.get(`/api/cities/${stateId}`)
            .then(function ({ data: cities }) {
                citySelect.empty()

                citySelect.append(
                    `<option value="0">Selecione...</option>`
                )

                cities.forEach(city => {
                    citySelect.append(
                        `<option value="${city.id}">${city.description}</option>`
                    )
                })

                // if(stateId === defaultStateId) {
                //     citySelect.val(defaultCityId)
                // }

                citySelect.prop('disabled', false)
                citySelect.formSelect()

                window.dispatchEvent(loadCitiesReady)
            });
    } catch(e) {
        alert('As cidades deste estado não foram encontrada.')
    }
}

window.onload = function() {

    window.axios.get('/api/states')
        .then(function ({ data: states }) {
            stateSelect.append(
                `<option value="0">Selecione...</option>`
            )

            states = states.filter(state => state.id === defaultStateId)

            states.forEach(state => {
                stateSelect.append(
                    `<option value="${state.id}">${state.description}</option>`
                )
            })

            stateSelect.val(defaultStateId)
            stateSelect.formSelect()

            loadCities(defaultStateId)
        });

    stateSelect.on('change', e => {
        const stateId = e.target.value

        if(Number(stateId) === 0) {
            citySelect.prop('disabled', true)
            citySelect.empty()
            citySelect.formSelect()
            return
        }

        loadCities(stateId)
    })
}

// Shared functions

window.setStateCity = (stateId, cityId) => {
    stateSelect.val(stateId)
    stateSelect.formSelect()

    citySelect.prop('disabled', false)
    citySelect.empty()

    window.axios.get(`/api/cities/${stateId}`)
        .then(function ({ data: cities }) {
            citySelect.append(
                `<option value="0">Selecione...</option>`
            )

            cities.forEach(city => {
                citySelect.append(
                    `<option value="${city.id}">${city.description}</option>`
                )
            })

            citySelect.val(cityId)
            citySelect.formSelect()
        });
}

window.resetStateCity = () => {
    stateSelect.val('0')
    citySelect.val('0')

    stateSelect.formSelect()
    citySelect.formSelect()
}
