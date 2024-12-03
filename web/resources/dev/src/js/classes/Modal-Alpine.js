import Alpine from "alpinejs";
import { disablePageScroll, enablePageScroll } from 'scroll-lock';

document.addEventListener('alpine:init', () => {
    Alpine.store('app', {
        init() {
        },

        popupOpen(popup_name) {
            window.dispatchEvent(new CustomEvent('popup-open', {
                detail: {
                    popup_name: popup_name
                }
            }))
        },

        popupClose(popup_name) {
            window.dispatchEvent(new CustomEvent('popup-close', {
                detail: {
                    popup_name: popup_name
                }
            }))
        },

        popupUpdateContent(popup_name, content) {
            window.dispatchEvent(new CustomEvent('popup-update-content', {
                detail: {
                    popup_name: popup_name,
                    content: content
                }
            }))
        }
    })

    Alpine.data('popup', (popup_name) => ({
        opened: false,
        name: popup_name,
        content: [],

        init() {
            window.addEventListener('popup-open', this.openHandler.bind(this))
            window.addEventListener('popup-close', this.closeHandler.bind(this))
            window.addEventListener('popup-update-content', this.updateContentHandler.bind(this))
        },

        openHandler(e) {
            if (this.name == e.detail.popup_name) {
                this.open()
            } else {
                this.close()
            }
        },

        closeHandler(e) {
            if (this.name == e.detail.popup_name) {
                this.close()
            }
        },

        updateContentHandler(e) {
            this.updateContent(e.detail)
        },

        open() {
            disablePageScroll(this.$root);
            this.opened = true

            setTimeout(() => {
                this.$dispatch('popup-opened', this.name)
            }, 100)
        },

        close() {
            enablePageScroll(this.$root)

            this.opened = false

            this.$dispatch('popup-closed', this.name)
        },

        updateContent(data) {
            if (this.name == data.popup_name) {
                for (let key in data.content) {
                    this.content[key] = data.content[key]
                }
            }
        }
    }))

    Alpine.data('form', () => ({
        send() {
            this.$store.app.popupOpen('popup_3')
            this.$store.app.popupUpdateContent('popup_3', {
                title: 'Данные загружены',
                text: 'Этот текст подгружен динамически'
            })
        }
    }))
})