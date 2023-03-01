// let expandCollapseButton = document.querySelector("#expand-collapse-button");
// let container = document.querySelector(".description__text");
// let isExpanded = false;

// expandCollapseButton.addEventListener("click", function() {
//     if(isExpanded){
//         container.style.maxHeight = "240px";
//         container.style.transition = "max-height 0.5s ease-out";
//         expandCollapseButton.innerText = "En savoir plus";
//     }
//     else{
//         container.style.maxHeight = "10000px";
//         container.style.transition = "max-height 0.5s ease-in";
//         expandCollapseButton.innerText = "En savoir moins";
//     }
//     isExpanded = !isExpanded;
// });
window.onload = function () {
var expandCollapseButton = document.getElementById("expand-collapse-button");
var d1 = document.getElementById("d1");

expandCollapseButton.addEventListener("click", function() {
  if (d1.classList.contains("collapsed")) {
    d1.classList.remove("collapsed");
    d1.classList.add("expanded");

    expandCollapseButton.innerHTML = "Réduire";
  } else {
    d1.classList.remove("expanded");
    d1.classList.add("collapsed");
    expandCollapseButton.innerHTML = "En savoir plus";
  }
});

}



