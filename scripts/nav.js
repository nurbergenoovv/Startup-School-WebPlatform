const navbar = document.getElementById('navbar');
let prevScrollPos = window.pageYOffset;

window
    .onscroll = () => {
    const currentScrollPos = window.pageYOffset;
    if (prevScrollPos > currentScrollPos || currentScrollPos < 100) {
        navbar.style.top = '0';
    } else {
        navbar.style.top = '-60px';
    }
    prevScrollPos = currentScrollPos;
};




const dropdowns = document.querySelectorAll('.dropdown');

dropdowns.forEach((dropdown) => {
    const dropdownContent = dropdown.querySelector('.dropdown-content');

    dropdown.addEventListener('mouseenter', () => {
        dropdownContent.style.display = 'block';
    });

    dropdown.addEventListener('mouseleave', () => {
        dropdownContent.style.display = 'none';
    });
});
