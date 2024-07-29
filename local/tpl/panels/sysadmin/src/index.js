import Vue from 'vue'
import Jquery from 'jquery'

Vue.config.productionTip = false

Jquery.ready(function () {
    new Vue({
        el: '#app',
        data: {
            message: "Intergrid VUE Dashboard"
        }
    })
});