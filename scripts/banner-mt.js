const bannerMt = [
    {
        $image:
            'https://cdn.pixabay.com/photo/2019/03/28/22/23/link-4088190_1280.png',
        $header:
            'Абай Құнанбаева',
        $description:
            'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry',
    },
    {
        $image:
            'https://cdn.pixabay.com/photo/2019/03/28/22/23/link-4088190_1280.png',
        $header:
            'Ыбрай Алтынсарим',
        $description:
            'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry',
    },
    {
        $image:
            'https://cdn.pixabay.com/photo/2019/03/28/22/23/link-4088190_1280.png',
        $header:
            'Илон Макс',
        $description:
            'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry',
    },
    {
        $image:
            'https://cdn.pixabay.com/photo/2019/03/28/22/23/link-4088190_1280.png',
        $header:
            'Сакенов Абдуррауф',
        $description:
            'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry',
    },
    {
        $image:
            'https://cdn.pixabay.com/photo/2019/03/28/22/23/link-4088190_1280.png',
        $header:
            'Маршалл Мэтерс',
        $description:
            'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry',
    }
];

let currentIndex = 0;

const imagePlace = document.getElementById('imageHere');
const headerPlace = document.getElementById('headerHere');
const descriptionPlace = document.getElementById('descriptionHere');

const updateSlider = (currentIndexInFunction) => {
    const now = bannerMt[currentIndexInFunction];

    // Calculate the translation to slide the card wrapper
    const translation = -currentIndexInFunction * 300; // 300px per card

    // Set the transform property to slide the cards
    document.querySelector('.card-wrapper').style.transform = `translateX(${translation}px)`;

    // Update the card content
    imagePlace.src = now.$image;
    imagePlace.alt = now.$header;
    headerPlace.innerHTML = `${now.$header}:`;
    descriptionPlace.innerHTML = now.$description;
};


document.getElementById('toLast').addEventListener('click', () => {
    if (currentIndex !== 0) {
        currentIndex -= 3; // Go back by three cards
        if (currentIndex < 0) {
            currentIndex = 0; // Ensure currentIndex doesn't go below 0
        }
        updateSlider(currentIndex);
    }
});

document.getElementById('toNext').addEventListener('click', () => {
    if (currentIndex < bannerMt.length - 3) {
        currentIndex += 3; // Move forward by three cards
        updateSlider(currentIndex);
    }
});


updateSlider(currentIndex);

// Функция для автоматической смены слайдов
function startAutoSlide() {
    setInterval(() => {
        if (currentIndex < bannerMt.length - 1) {
            currentIndex += 1;
        } else {
            currentIndex = 0; // Вернуться к первому слайду после последнего
        }
        updateSlider(currentIndex);
    }, 5000); // Интервал в миллисекундах (например, 5000 мс = 5 секунд)
}

// Запустить автоматическую смену слайдов при загрузке страницы
startAutoSlide();

// Остановить автопереключение, когда курсор находится над слайдером
document.getElementById('slider-container').addEventListener('mouseover', () => {
    clearInterval(autoSlideInterval);
});

// Возобновить автопереключение, когда курсор уходит с слайдера
document.getElementById('slider-container').addEventListener('mouseout', () => {
    startAutoSlide();
});
