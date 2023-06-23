// Get the input elements
const nameInput = document.getElementById("name");
const emailInput = document.getElementById("email");


nameInput.value = localStorage.getItem("nameInputValue");
emailInput.value = localStorage.getItem("emailInputValue");


nameInput.addEventListener("input", function() {
  localStorage.setItem("nameInputValue", nameInput.value);
});

emailInput.addEventListener("input", function() {
  localStorage.setItem("emailInputValue", emailInput.value);
});


