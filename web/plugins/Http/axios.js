export default function ({$axios, store}) {
    $axios.onError(error => {
        if (error.response.status === 422) {
            console.log(error.response.data.errors)
            store.dispatch('validation/setErrors', error.response.data.errors)
        }

        return Promise.reject(error)
    })

    $axios.onRequest(() => {

    })
}