let favoriteButton = document.querySelector('#favorite_button');
let favoriteValue = document.querySelector('#favorite_id').value;
console.log(favoriteValue);

favoriteButton.addEventListener('click', async() => {
    try {
        const rawResponse = await fetch('http://127.0.0.1:8080/get/shop-id', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          
          body: JSON.stringify({ favoriteId: favoriteValue }),
          
        })
        const content = await rawResponse.json()        
        console.log('response', content)
      } catch (error) {
        console.error(error)
      }

})