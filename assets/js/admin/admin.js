import '../../bootstrap.js';

/* --- DEPS --- */
import $ from 'jquery';
import '@popperjs/core';
import 'bootstrap';
import 'select2';
import 'pretty-checkbox';

/* --- STYLES --- */
import '/assets/styles/admin/admin.scss'
import '/assets/styles/admin/animate.css';
import '/assets/styles/admin/styles.scss';
import '@fortawesome/fontawesome-free/css/all.min.css';
import '@fortawesome/fontawesome-free/css/regular.min.css';
import 'bootstrap/scss/bootstrap.scss';

/* --- SCRIPTS --- */
import './custom/sidemenu.js';
import './custom/sticky.js';
import './custom/custom.js';
import './custom/dataTables.bootstrap5.min.js';

$(function () {
    $('.select2').select2();
});