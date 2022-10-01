const signupButton = document.getElementById('signup_button');
console.log(signupButton);
const signupWindow = document.querySelector('.signup_back');
console.log(signupWindow);
const closeButton = document.getElementById('close-popup');
console.log(closeButton);

signupButton.addEventListener('click', () => {
   signupWindow.classList.add("on");

})


closeButton.addEventListener('mouseup', (e) => {
   signupWindow.classList.remove("on");
})


// Varible to create signup selector
const selectordiv = document.querySelector('.user_selector');
const selectorButtons = selectordiv.querySelectorAll('button');

var addSelectClass = function(){
   removeSelectClass();
   this.classList.add('bold');	
}

var removeSelectClass = function(){
   for (var i =0; i < selectorButtons.length; i++) {
      selectorButtons[i].classList.remove('bold')
   }
}


for (let index = 0; index < selectorButtons.length; index++) {
   const button = selectorButtons[index];

   button.addEventListener('click', addSelectClass)
}