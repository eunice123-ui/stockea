document.getElementById("togglePassword").addEventListener("click", function () {
  const password = document.getElementById("password");
  const type = password.getAttribute("type") === "password" ? "text" : "password";
  password.setAttribute("type", type);
  this.textContent = type === "password" ? "👁️" : "🙈";
});
