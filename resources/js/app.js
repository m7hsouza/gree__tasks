require('./bootstrap');
require('vuetify/dist/vuetify.min.css')

window.Vue = require('vue');
import Vuetify from 'vuetify';

Vue.use(Vuetify)
Vue.component('task-list', require('./components/tasks/TaskList.vue').default);
Vue.component('add-task-form', require('./components/tasks/AddTaskForm.vue').default);
Vue.component('edit-task-form', require('./components/tasks/EditTaskForm.vue').default);
Vue.component('delete-task-dialog', require('./components/tasks/DeleteTaskDialog.vue').default);

const app = new Vue({
    mode: 'history',
    vuetify: new Vuetify(),
    el: '#app',
});
