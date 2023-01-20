var slideIndex = 0;
var slides = document.getElementsByClassName("carousel-slide");

function showSlides() {
  for (var i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  slideIndex++;
  if (slideIndex > slides.length) {
    slideIndex = 1;
  }
  slides[slideIndex-1].style.display = "block";
  setTimeout(showSlides, 3000); 
}

showSlides();

function prevSlide() {
  slideIndex--;
  if (slideIndex < 0) {
    slideIndex = slides.length-1;
  }
  for (var i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  slides[slideIndex].style.display = "block";
}

function nextSlide() {
  slideIndex++;
  if (slideIndex > slides.length-1) {
    slideIndex = 0;
  }
  for (var i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  slides[slideIndex].style.display = "block";
}
