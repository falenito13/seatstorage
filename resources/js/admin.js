/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');

import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import { Pagination } from 'element-ui';
import CKEditor from '@ckeditor/ckeditor5-vue';

import elementLocale from 'element-ui/lib/locale/lang/en';

Vue.use(Pagination);
Vue.use(ElementUI, { locale: elementLocale });
Vue.use(CKEditor);

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// admin text
Vue.component('admin-text-list-save', require('./admin/text/page/TextListSave').default);

// User
Vue.component('admin-user-save-component', require('./admin/user/page/SaveComponent').default);
Vue.component('admin-profile-save-component', require('./admin/user/page/ProfileSaveComponent').default);

// User role
Vue.component('admin-role-save-component', require('./admin/role/page/SaveComponent').default);

//Base Component
Vue.component('delete-component', require('./components/admin/Delete').default);

//Test
Vue.component('test-save-component', require('./admin/test/SaveComponent').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#admin',
});
