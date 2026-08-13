import { ref } from "vue"

export const toastMessage = ref("")
export const toastType = ref("success")
export const toastVisible = ref(false)

export function showToast(message, type = "success") {
    toastMessage.value = message
    toastType.value = type
    toastVisible.value = true

    setTimeout(() => {
        toastVisible.value = false
    }, 5000)
}
