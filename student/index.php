<?php
if (!isset($_COOKIE['id'])) {
  header("Location: ../index.php");
  exit();
}

require_once "../includes/functions.php";
if (isset($_POST['buy'])) {
  $id = $_POST['id'];
  buyGoods($id);
}

if (isset($_POST['logout'])) {
  exitCookie();
}

$res = getCards();
if ($res) {
  $cardRes = $res;
}

$result = getTypes();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>BilimBIL - Жеке кабнет</title>
  <link rel="stylesheet" href="../style/main.css" />
  <link rel="stylesheet" href="../style/page-index.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="shortcut icon" href="../icon.jpeg" />
  <link rel="stylesheet" href="../style/card.css" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link rel="stylesheet" href="../styles/error.css" />
  <style>
    .rightForm {
      display: flex;
      justify-content: center;
      align-items: center;
    }
  </style>
  <style>
    .loading {
      position: fixed;
      width: 100vw;
      height: 100vh;
      background-color: grey;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }

    .loader {
      width: 48px;
      height: 48px;
      display: inline-block;
      position: relative;
      z-index: 99;
    }

    .loader::after,
    .loader::before {
      content: '';
      box-sizing: border-box;
      width: 48px;
      height: 48px;
      border-radius: 50%;
      border: 4px solid #FFF;
      position: absolute;
      left: 0;
      top: 0;
      animation: animloader 2s linear infinite;
    }

    .loader::after {
      animation-delay: 1s;
    }

    @keyframes animloader {
      0% {
        transform: scale(0);
        opacity: 1;
      }

      100% {
        transform: scale(1);
        opacity: 0;
      }
    }
  </style>
  <link
    href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Montserrat:wght@400;500;600;700&display=swap"
    rel="stylesheet" />
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<body>
  <?php
  if (isset($_COOKIE['error'])) {
    $error = $_COOKIE['error'];
    echo "<div class='error-container'>
        <div class='error-message'>$error</div>
        </div>";
    setcookie("error", "", time() - 3600, "/"); // Вывод сообщения об ошибке
  }
  ?>
  <nav id="navbar">
    <span class="iconOfSite">
      <span class="lastName">
        <?php echo $_COOKIE['lname']; ?>
      </span>
      <span class="firstName">
        <?php echo $_COOKIE['fname']; ?>
      </span>
      <span class="firstName">
        <?php echo $_COOKIE['class']; ?>
      </span>
    </span>
    <div class="links">
      <div class="dropdown">
        <a href="./" class="nav-links">Тестілеу</a>
        <div class="dropdown-content">
          <?php if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()): ?>
              <a href="./startTest.php?id=<?php echo $row['id']; ?>"><?php echo $row['name']; ?></a>
            <?php endwhile;
          } else {
            echo "<p>Сурак категориялары алы косылмады</p>";
          } ?>
        </div>
      </div>
      <a href="./shop.php" class="nav-links opener">Онлайн дүкен</a>
    </div>
    <div class="rightForm">
      <span class="iconOfSite pts">
        <?php echo $_COOKIE['score']; ?>
      </span>
      <span class="iconOfSite">Балл</span>
      <form action="" method="post"><button name="logout" class="logout">Шығу</button></form>
    </div>
  </nav>


  <header class="firstSection">
    <h1>Bilim-BIL</h1>
    <strong>Оқуыңызды өзіңізбен бірге алыңыз!</strong>
    <span>Жаттығулар мен нақты түсініктемелері бар грамматикалық сабақтар, грамматикалық кестелер, транскрипциялары
      бар оқу және тыңдау тесттері, жазу сабақтары, лезде белгілеу, жауаптар кері байланысы және т.б.!</span>
  </header>
  <main>
    <div class="wrapper">
      <ul class="carousel">
        <?php while ($row = $cardRes->fetch_assoc()) {
          echo '<li class="card">
            <div class="img"><img src="../admin/' . $row['image_url'] . '" alt="img" draggable="false"></div>
            <h2>' . $row['namecard'] . '</h2>
            <span>' . $row['job_title'] . '</span>
          </li>';
        } ?>
      </ul>
    </div>
  </main>
  <div class="loading" id="preloader"><span class="loader"></span></div>
  <script>
    window.onload = function () {
      var preloader = document.getElementById('preloader');
      preloader.style.display = 'none';
    }
  </script>

  <script src="../scripts/nav.js"></script>
  <script>
    const wrapper = document.querySelector(".wrapper");
    const carousel = document.querySelector(".carousel");
    const firstCardWidth = carousel.querySelector(".card").offsetWidth;
    const arrowBtns = document.querySelectorAll(".wrapper i");
    const carouselChildrens = [...carousel.children];
    let isDragging = false, isAutoPlay = true, startX, startScrollLeft, timeoutId;
    // Get the number of cards that can fit in the carousel at once
    let cardPerView = Math.round(carousel.offsetWidth / firstCardWidth);
    // Insert copies of the last few cards to beginning of carousel for infinite scrolling
    carouselChildrens.slice(-cardPerView).reverse().forEach(card => {
      carousel.insertAdjacentHTML("afterbegin", card.outerHTML);
    });
    // Insert copies of the first few cards to end of carousel for infinite scrolling
    carouselChildrens.slice(0, cardPerView).forEach(card => {
      carousel.insertAdjacentHTML("beforeend", card.outerHTML);
    });
    // Scroll the carousel at appropriate postition to hide first few duplicate cards on Firefox
    carousel.classList.add("no-transition");
    carousel.scrollLeft = carousel.offsetWidth;
    carousel.classList.remove("no-transition");
    // Add event listeners for the arrow buttons to scroll the carousel left and right
    arrowBtns.forEach(btn => {
      btn.addEventListener("click", () => {
        carousel.scrollLeft += btn.id == "left" ? -firstCardWidth : firstCardWidth;
      });
    });
    const dragStart = (e) => {
      isDragging = true;
      carousel.classList.add("dragging");
      // Records the initial cursor and scroll position of the carousel
      startX = e.pageX;
      startScrollLeft = carousel.scrollLeft;
    }
    const dragging = (e) => {
      if (!isDragging) return; // if isDragging is false return from here
      // Updates the scroll position of the carousel based on the cursor movement
      carousel.scrollLeft = startScrollLeft - (e.pageX - startX);
    }
    const dragStop = () => {
      isDragging = false;
      carousel.classList.remove("dragging");
    }
    const infiniteScroll = () => {
      // If the carousel is at the beginning, scroll to the end
      if (carousel.scrollLeft === 0) {
        carousel.classList.add("no-transition");
        carousel.scrollLeft = carousel.scrollWidth - (2 * carousel.offsetWidth);
        carousel.classList.remove("no-transition");
      }
      // If the carousel is at the end, scroll to the beginning
      else if (Math.ceil(carousel.scrollLeft) === carousel.scrollWidth - carousel.offsetWidth) {
        carousel.classList.add("no-transition");
        carousel.scrollLeft = carousel.offsetWidth;
        carousel.classList.remove("no-transition");
      }
      // Clear existing timeout & start autoplay if mouse is not hovering over carousel
      clearTimeout(timeoutId);
      if (!wrapper.matches(":hover")) autoPlay();
    }
    const autoPlay = () => {
      if (window.innerWidth < 800 || !isAutoPlay) return; // Return if window is smaller than 800 or isAutoPlay is false
      // Autoplay the carousel after every 3000 ms (3 seconds)
      timeoutId = setTimeout(() => {
        const currentScrollLeft = carousel.scrollLeft;
        const nextScrollLeft = currentScrollLeft + firstCardWidth;

        // Check if the next scroll position will reach the end of the carousel
        if (nextScrollLeft >= carousel.scrollWidth) {
          // If at the end, reset scroll to the beginning without transition
          carousel.classList.add("no-transition");
          carousel.scrollLeft = carousel.offsetWidth;
          carousel.classList.remove("no-transition");
        } else {
          // Otherwise, scroll to the next card
          carousel.scrollLeft = nextScrollLeft;
        }

        // Schedule the next autoplay after 3 seconds
        autoPlay();
      }, 3000);
    }

    autoPlay();

    carousel.addEventListener("mousedown", dragStart);
    carousel.addEventListener("mousemove", dragging);
    document.addEventListener("mouseup", dragStop);
    carousel.addEventListener("scroll", infiniteScroll);
    wrapper.addEventListener("mouseenter", () => clearTimeout(timeoutId));
    wrapper.addEventListener("mouseleave", autoPlay);
  </script>
</body>

</html>