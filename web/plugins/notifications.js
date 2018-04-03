import Vue from 'vue'
import VueNotifications from 'vue-notifications'
import 'jquery'
import 'toastr/build/toastr.min.css'
import toastr from 'toastr'

function toast({title, message, type, timeout, cb}) {
    if (type === VueNotifications.types.warn) type = 'warning'
    return toastr[type](message, title, {timeOut: timeout})
}

// Here we map vue-notifications method to function abowe (to mini-toastr)
// By default vue-notifications can have 4 methods: 'success', 'error', 'info' and 'warn'
// But you can specify whatever methods you want.
// If you won't specify some method here, output would be sent to the browser's console
const options = {
    success: toast,
    error: toast,
    info: toast,
    warn: toast
}

// Activate plugin
// VueNotifications have auto install but if we want to specify options we've got to do it manually.
Vue.use(VueNotifications, options)