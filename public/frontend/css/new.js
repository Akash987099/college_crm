function toggleButtons() {
    if ($(window).width() <= 767) { // Adjust the breakpoint according to your needs
        $('#desktopButtons').hide();
        $('#mobileButtons').show();
    } else {
        $('#desktopButtons').show();
        $('#mobileButtons').hide();
    }
}

// Initial call to set the initial state
toggleButtons();

// Call the function on window resize
$(window).resize(function () {
    toggleButtons();
});

$(document).ready(function () {
    var owl = $('.new-carousel');

    owl.owlCarousel({
        loop: true,
        margin: 10,
        nav: false, // Disable default navigation
        dots: true,  // Enable dots
        autoplay: true,
        autoplayTimeout: 3000,
        responsive: {
            0: { items: 1 },
            600: { items: 3 },
            1000: { items: 5 }
        },
        slideBy: 6,
    });

    // Custom navigation buttons
    $('.custom-next-btn').on('click', function () {
        owl.trigger('next.owl.carousel');
    });

    $('.custom-prev-btn').on('click', function () {
        owl.trigger('prev.owl.carousel');
    });
});

$(document).ready(function(){
    var currentButton = null;

    $('#Management').on('click', function(){
        if (currentButton !== null) {
            currentButton.css('background-color', ''); 
        }

        currentButton = $(this);

        currentButton.css('background-color', 'gray');
        alert('Hello');
    });

    $('#Engineering').on('click', function(){
        if (currentButton !== null) {
            currentButton.css('background-color', '');
        }

        currentButton = $(this);

        currentButton.css('background-color', 'gray');
        alert('Hello');
    });
});
let currentIndex = 0;
const slides = document.querySelectorAll(".slide");
const totalSlides = slides.length;

function moveSlide(direction) {
  currentIndex = (currentIndex + direction + totalSlides) % totalSlides;
  updateSlider();
}

function updateSlider() {
  const offset = -currentIndex * 100;
  document.querySelector(".slider-wrapper").style.transform = `translateX(${offset}%)`;
  updateDots();
}

function updateDots() {
  const dotsContainer = document.querySelector(".dots-container");
  dotsContainer.innerHTML = "";

  for (let i = 0; i < totalSlides; i++) {
    const dot = document.createElement("div");
    dot.classList.add("dot");
    dot.addEventListener("click", () => goToSlide(i));
    dotsContainer.appendChild(dot);
    if (i === currentIndex) {
      dot.classList.add("active");
    }
  }
}

function goToSlide(index) {
  currentIndex = index;
  const offset = -currentIndex * 100;
  document.querySelector(".slider-wrapper").style.transform = `translateX(${offset}%)`;
  updateDots();
}

// Initial setup
document.addEventListener("DOMContentLoaded", () => {
  const dotsContainer = document.createElement("div");
  dotsContainer.classList.add("dots-container");
  document.querySelector(".slider-container").appendChild(dotsContainer);
  updateDots();
});

$(document).ready(function(){
    $('#Colleges').click(function(){
        $('#courseInput').attr('placeholder', 'Enter College Name');
    });

    $('#Exams').click(function(){
        $('#courseInput').attr('placeholder', 'Enter Exam Name');
    });

    $('#Courses').click(function(){
        $('#courseInput').attr('placeholder', 'Enter Course Name');
    });
});

$(document).ready(function () {
    $('.packages-carousel').owlCarousel({
        items: 1,
        loop: true,
        nav: true,
        dots: false,
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
    });
});