window._ = require('lodash');
window.Vue = require('vue');

Vue.use(require('vue-resource'));

Vue.component('photo', require('../vue/photo.vue'));
Vue.component('hero-photo', require('../vue/hero-photo.vue'));
Vue.component('gallery', require('../vue/gallery.vue'));
Vue.component('gallery-photo', require('../vue/gallery-photo.vue'));

new Vue({
    el: '#app',
});
