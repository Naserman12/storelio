import { reactive } from "vue";
export const toastState = reactive({
    toasts: []
})
export function showToast(message, type= 'success'){
    const id = Date.now()

    toastState.toasts.push({
        id,
        message,
        type
    })
    setTimeout(() => {
        toastState.toasts = toastState.toasts.filter(t => t.id !== id)
    }, 3000)
}
