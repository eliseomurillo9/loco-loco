const signupButton = document.getElementById('signup_button');
const signupWindow = document.querySelector('.signup_back');

signupButton.addEventListener('click', () => {
   signupWindow.classList.toggle("on");
})