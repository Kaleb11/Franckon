require('./bootstrap');
import Vue from 'vue'
import router from './router'
import store from './store'
import ViewUI from 'view-design';
import 'view-design/dist/styles/iview.css';
// import Slider from 'view-ui-plus';
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import 'material-design-icons-iconfont/dist/material-design-icons.css'
import locale from 'view-design/dist/locale/en-US'
import DisableAutocomplete from 'vue-disable-autocomplete';
import 'view-ui-plus/dist/styles/viewuiplus.css'
import Treeselect from '@riophae/vue-treeselect'
// import the styles
import '@riophae/vue-treeselect/dist/vue-treeselect.css'
Vue.use(DisableAutocomplete);

Vue.use(ViewUI, { locale: locale });
Vue.use(Vuetify);
Vue.use(require('vue-moment'));

import common from './common'

// new Vue({ vuetify }).$mount('#app')
Vue.mixin(common);
import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');

window.Echo = new Echo({

    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    wsHost: '127.0.0.1',
    wsPort: 6001,
    forceTLS: false,
    disableStats: true,
    encrypted: false,
    // enabledTransports: ['ws', 'wss']
});

Vue.component('mainapp', require('./components/mainapp.vue').default)
const app = new Vue({
    el: '#app',
    router,
    store,
    vuetify: new Vuetify(),
    transpileDependencies: ['vuetify']
})