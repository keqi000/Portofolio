import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Theme Toggle Helper
window.initTheme = () => {
    if (localStorage.theme === 'dark') {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
};

window.toggleTheme = () => {
    if (document.documentElement.classList.contains('dark')) {
        document.documentElement.classList.remove('dark');
        localStorage.theme = 'light';
    } else {
        document.documentElement.classList.add('dark');
        localStorage.theme = 'dark';
    }
};

// Initialize theme on load
window.initTheme();

Alpine.start();
