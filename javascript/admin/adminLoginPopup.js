export function adminLoginPopup() {
  const showPasswordBtn = document.querySelector(".password-wrapper span");
  const passwordInput = document.querySelector(".password-wrapper input");
  showPasswordBtn.addEventListener("click", () => {
    passwordInput.type =
      passwordInput.type === "password" ? "text" : "password";
  });
}
