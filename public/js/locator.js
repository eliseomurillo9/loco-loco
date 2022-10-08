let map
const locationPointer = document.getElementById('location-point')
console.log(locationPointer)

// Geolocation
locationPointer.addEventListener('click', () => {
  window.navigator.geolocation.getCurrentPosition(
    async function (position) {
      console.log(
        'Position trouvée : Latitude=' +
          position.coords.latitude +
          ' Longitude=' +
          position.coords.longitude,
      )
    let lat= position.coords.latitude;
    let lng= position.coords.longitude;
    let positionInfo = {lat, lng};
      try {
        const rawResponse = await fetch('http://127.0.0.1:8080/location', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          
          body: JSON.stringify({ geolocation: positionInfo }),
          
        })
        const content = await rawResponse.json()        
        console.log('response', content)
      } catch (error) {
        console.error(error)
      }
      console.log(position.coords)
    },
    function (error) {
      console.log('Erreur de géoloc N°' + error.code + ' : ' + error.message)
      console.log(error)
    },
    )
})



