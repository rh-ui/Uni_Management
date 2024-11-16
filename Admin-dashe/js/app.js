let shrink_btn = document.querySelector(".shrink-btn");
const search = document.querySelector(".search1");
const sidebar_links = document.querySelectorAll(".sidebar-links a");
const active_tab = document.querySelector(".active-tab");
const shortcuts = document.querySelector(".sidebar-links h4");
const tooltip_elements = document.querySelectorAll(".tooltip-element");

let activeIndex;

shrink_btn.addEventListener("click", () => {
  document.body.classList.toggle("shrink");
  setTimeout(moveActiveTab, 400);

  shrink_btn.classList.add("hovered");

  setTimeout(() => {
    shrink_btn.classList.remove("hovered");
  }, 500);
});

search.addEventListener("click", () => {
  document.body.classList.remove("shrink");
  search.lastElementChild.focus();
});

function moveActiveTab() {
  let topPosition = activeIndex * 58 + 2.5;

  if (activeIndex > 3) {
    topPosition += shortcuts.clientHeight;
  }

  active_tab.style.top = `${topPosition}px`;
}

function changeLink() {
  sidebar_links.forEach((sideLink) => sideLink.classList.remove("active"));
  this.classList.add("active");

  activeIndex = this.dataset.active;

  moveActiveTab();
}

sidebar_links.forEach((link) => link.addEventListener("click", changeLink));

function showTooltip() {
  let tooltip = this.parentNode.lastElementChild;
  let spans = tooltip.children;
  let tooltipIndex = this.dataset.tooltip;

  Array.from(spans).forEach((sp) => sp.classList.remove("show"));
  spans[tooltipIndex].classList.add("show");

  tooltip.style.top = `${(100 / (spans.length * 2)) * (tooltipIndex * 2 + 1)}%`;
}

tooltip_elements.forEach((elem) => {
  elem.addEventListener("mouseover", showTooltip);
});








// Cette fonction permet de filtrer les data du tableau selon les champs dans les td:
function filtrer() {
  const filtre = document.getElementById('maRecherche');
        rows = document.querySelectorAll('tbody tr');
  filtre.addEventListener('input', function (event) {
    rows.forEach((row,i) => {
      console.log(row.textContent);
      // row.textContent.toLowerCase('td').startsWith(letter) ?
      //   (row.style.display = "") : (row.style.display = "none");
      let table_data = row.textContent.toLowerCase(row.value);
      search_data = filtre.value.toLowerCase(filtre.value);
      if(table_data.indexOf(search_data) < 0){
        row.style.display = "none";
      }
      else{
        row.style.display = "";
        row.style.setProperty('--delay',i/25+'s')
      }
    });
  });

  // filtre.addEventListener('click', function (e) {
  //   const letter = e.target.value;
  //   rows.forEach((row) => {
  //     row.querySelector('td').textContent.toLowerCase();
  //     (row.style.display = "");
  //   });
  // });
}

























