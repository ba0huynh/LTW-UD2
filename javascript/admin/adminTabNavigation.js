const Btn = document.querySelectorAll(".admin-nav-btn");
const views = document.querySelectorAll("main");
export function AdminTabNavigation() {
  views.forEach((view) => {
    view.style.display = "none";
  });
  views.forEach((view) => {
    if (view.attributes.page.value === "analytics") {
      view.style.display = "block";
    }
  });
  Btn.forEach((btn) => {
    btn.addEventListener("click", (e) => {
      views.forEach((view) => {
        view.style.display = "none";
      });
      views.forEach((view) => {
        if (view.attributes.page.value === e.target.attributes.page.value) {
          view.style.display = "block";
        }
      });
    });
  });
}
