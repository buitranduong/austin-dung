// Default Laravel bootstrapper, installs axios
import './bootstrap';
import * as bootstrap from 'bootstrap';
/* global bootstrap: false */
(() => {
    'use strict'

    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

    const toastElList = document.querySelectorAll('.toast')
    const toastList = [...toastElList].map(toastEl => new bootstrap.Toast(toastEl))
})()
