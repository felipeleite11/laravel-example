const cepApiUrl = 'https://viacep.com.br/ws/#zip#/json/'

const loadAddressReady = new CustomEvent('loadAddressReady')
const loadStateCityReady = new CustomEvent('loadStateCityReady')

window.getAddressByZipcode = (zipcode) => {
    const url = cepApiUrl.replace('#zip#', zipcode)

    window.axios.get(url)
        .then(function ({ data: addressData }) {
            loadAddressReady.addressData = addressData

            window.dispatchEvent(loadAddressReady)
        })
}

async function getStateByInitials(stateInitials) {
    const url = `/api/state/byInitials/${stateInitials}`

    const { data } = await window.axios.get(url)

    return data
}

async function getStateById(stateId) {
    throw new Error('Not implemented on file resources/js/cep.js!')

    // const url = `/api/state/byId/${stateId}`

    // const { data } = await window.axios.get(url)

    // return data
}

async function getCityByName(stateId, cityName) {
    const url = `/api/city/byName/${stateId}/${cityName}`

    const { data } = await window.axios.get(url)

    return data
}

// Because the CEP API
window.getStateCityData = async (state, city) => {
    let stateData

    if(typeof state === 'number') {
        stateData = loadStateCityReady.stateData = await getStateById(state)
    } else if(state.length === 2) {
        stateData = loadStateCityReady.stateData = await getStateByInitials(state)
    }

    loadStateCityReady.cityData = await getCityByName(stateData.id, city)

    window.dispatchEvent(loadStateCityReady)
}
