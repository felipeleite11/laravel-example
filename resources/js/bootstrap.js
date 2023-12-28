window._ = require('lodash');

const axios = require('axios');

window.axios = axios.create({
    baseURL: 'http://127.0.0.1:8000',
    timeout: 10000
});

