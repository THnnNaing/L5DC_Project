// JavaScript to handle the sidebar toggle
const menuButton = document.getElementById('menu-button');
const closeButton = document.getElementById('close-button');
const sidebar = document.getElementById('sidebar');
const form = document.getElementById('form');

menuButton.addEventListener('click', () => {
    sidebar.classList.toggle('-translate-x-full');
    
    
});

closeButton.addEventListener('click', () => {
    sidebar.classList.toggle('-translate-x-full');
    
    
});
