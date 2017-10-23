
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component(
	'afh-animals', 
	require('./components/AFH-Animals.vue')
);

Vue.component(
	'afh-animal-edit', 
	require('./components/AFH-AnimalEdit.vue')
);

// import VueAxios from 'vue-axios'
// Vue.use(VueAxios, axios)

var VueQuillEditor = require('vue-quill-editor')
Vue.use(VueQuillEditor)

const app = new Vue({
    el: '#app',
    methods: {
    	Edit() {
    		return "";
    	}
    }
});
