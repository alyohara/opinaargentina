import './bootstrap';
import './telefonos.js';

Echo.channel('exports.' + userId)
    .listen('.export.completed', (e) => {
        let notification = document.getElementById('notification');
        notification.style.display = 'block';
        setTimeout(() => {
            notification.style.display = 'none';
        }, 5000); // Hide after 5 seconds
    });
