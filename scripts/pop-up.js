const bgofshop = document.querySelector('#bgofshop');
const shop = document.querySelector('#shop');
const openerr = document.querySelector('.opener');

bgofshop.addEventListener('click', () => {
    shop.style.display = 'none';
    bgofshop.style.display = 'none';
});

openerr.addEventListener('click', () => {
    shop.style.display = 'flex';
    bgofshop.style.display = 'flex';
});