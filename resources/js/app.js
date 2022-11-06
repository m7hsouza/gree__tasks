require('vuetify/dist/vuetify.min.css')

window.Vue = require('vue');
import Vuetify from 'vuetify';

Vue.use(Vuetify)
Vue.component('task-list', require('./components/tasks/TaskList.vue').default);

const app = new Vue({
    vuetify: new Vuetify(),
    el: '#app',
});
