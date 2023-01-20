let expandCollapseButton = document.querySelector("#expand-collapse-button");
let container = document.querySelector(".description__text");
let isExpanded = false;

expandCollapseButton.addEventListener("click", function() {
    if(isExpanded){
        container.style.maxHeight = "240px";
        container.style.transition = "max-height 0.5s ease-out";
        expandCollapseButton.innerText = "En savoir plus";
    }
    else{
        container.style.maxHeight = "10000px";
        container.style.transition = "max-height 0.5s ease-in";
        expandCollapseButton.innerText = "En savoir moins";
    }
    isExpanded = !isExpanded;
});