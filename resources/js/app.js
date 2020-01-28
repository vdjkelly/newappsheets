require('./bootstrap');

window.Vue = require('vue')

import VueGAPI from "vue-gapi";


import { HotTable } from '@handsontable/vue';
import Handsontable from 'handsontable';

import Vue from 'vue'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

// Install BootstrapVue
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)

const config = {
  apiKey: process.env.API_KEY_GOOGLE,
  clientId: process.env.CLIENT_ID,
  discoveryDocs: ["https://sheets.googleapis.com/$discovery/rest?version=v4"],
  scope: process.env.SCOPE_GOOGLE,
}
Vue.use(VueGAPI, config)


Vue.component('login', require('./components/Login').default);
Vue.component('hot-table', HotTable);