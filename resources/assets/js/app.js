
import bootstrap from 'bootstrap';
import Vue from 'vue'
import App from './components/App'
import router from './router' 
import store from './store' 

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
	router,
	store,
	render: h => h(App),
    methods: {
    	Edit() {
    		return "";
    	}
    }
});
