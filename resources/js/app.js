import './bootstrap';

// index.js
import 'preline'



document.addEventListener('livewire:navigated', () => {
    window.HSStaticMethods.autoInit();
})