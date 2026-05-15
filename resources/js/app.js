// Import bootstrap dan dependencies dengan ES Module syntax yang benar
import './bootstrap';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import Swal from 'sweetalert2';

// Pasang Swal ke global window agar bisa dipanggil dari mana saja
window.Swal = Swal;

// Import seluruh modul bootstrap sebagai object, lalu pasang ke window.bootstrap
import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;