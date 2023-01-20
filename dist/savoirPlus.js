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

let togg1 = document.getElementById("expand-collapse-button");
let d1 = document.getElementById("d1");
togg1.addEventListener("click", () => {
  if(getComputedStyle(d1).display != "none"){
    d1.style.display = "none";
    
  } else {
    d1.style.display = "block";
  }
})
