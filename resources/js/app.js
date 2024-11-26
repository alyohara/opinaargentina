import './bootstrap';
import './telefonos.js';

Echo.channel('exports.' + userId)
    .listen('.export.completed', (e) => {
        alert('Export job completed!');
    });
