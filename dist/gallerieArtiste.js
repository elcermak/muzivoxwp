console.log(arrayCarrousel);

setInterval(() => {
  prevSlide();
}, 5000);


var index = 0;
var slides = document.getElementById("carousel-slide");
let contenu = "";
slides.innerHTML = contenu;

function   display() {
  slides.setAttribute("src", arrayCarrousel[index].url);
  slides.setAttribute("alt", arrayCarrousel[index].alt);

}

showSlides();

function prevSlide() {
  index--;
  if (index < 0) {
    index = 2;
  } 
  display();
}

function nextSlide() {
  index++;
  if (index == 2) {
    index = 0;

  }
  display();
}
