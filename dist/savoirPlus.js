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