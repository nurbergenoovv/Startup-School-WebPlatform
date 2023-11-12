const slider = document.querySelector('.slider');
const dotsContainer = document.querySelector('.dots');
const images = Array.from(slider.children);
const dots = [];

let currentSlide = 0;
let sliderInterval;

for (let i = 0; i < images.length; i++) {
  const dot = document.createElement('div');
  dot.classList.add('dot');
  dotsContainer.appendChild(dot);
  dots.push(dot);
  
  dot.addEventListener('click', () => {
    currentSlide = i;
    updateSlider();
    resetInterval();
  });
}

function updateSlider() {
  slider.style.transform = `translateX(-${currentSlide * 100}%)`;
  
  dots.forEach((dot, index) => {
    dot.classList.toggle('active', index === currentSlide);
  });
}

function nextSlide() {
  currentSlide = (currentSlide + 1) % images.length;
  updateSlider();
}

function resetInterval() {
  clearInterval(sliderInterval);
  sliderInterval = setInterval(nextSlide, 3000);
}

resetInterval();

