import './bootstrap'

import Alpine from 'alpinejs'
import intersect from '@alpinejs/intersect'

window.Alpine = Alpine
Alpine.plugin(intersect)

// REGISTER STORE DULU
Alpine.store('confirm', {
    open: false,
    title: '',
    message: '',
    action: null,

    show(title, message, callback) {
        this.title = title
        this.message = message
        this.action = callback
        this.open = true
    },

    close() {
        this.open = false
    },

    confirm() {
        if (this.action) this.action()
        this.close()
    }
})

// BARU START ALPINE
Alpine.start()


/* ===== SMOOTH SCROLL WITH ANIMATION ===== */
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('[data-scroll]').forEach(link => {
    link.addEventListener('click', e => {
      e.preventDefault()
      const target = document.querySelector(link.getAttribute('href'))
      if (!target) return

      const offset = 80
      const top =
        target.getBoundingClientRect().top + window.pageYOffset - offset

      window.scrollTo({
        top,
        behavior: 'smooth'
      })
    })
  })
})
