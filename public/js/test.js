console.log('hola')
async function getAddress() {
  try {
    let data = await fetch('http://127.0.0.1:8080/store/address_list', {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
      },
    })
    let res = await data.json()
    console.log(res)

    return res
  } catch (error) {
    console.error('ERROR', error)
  }

}

// const storePosition = getAddress().storeCoords;

  
  

async function initMap() {
  let coordinates= await getAddress()

  map = new google.maps.Map(document.getElementById("map"), {
    mapId: "981b93be4c70d164",
    center: { lat: 50.62936847746803, lng: 3.0572192078331324 },
    zoom: 16,
  }); 
  
  userPosition = coordinates.userCoords;
  storePosition = coordinates.storeCoords;
  console.log(typeof userPosition);
  
  infoWindow = new google.maps.InfoWindow();
  if (storePosition) {
    map =  new google.maps.Map(document.getElementById('map'), {
      mapId: '981b93be4c70d164',
      center:  { lat: userPosition.lat, lng: userPosition.lng },
      zoom: 14,
    })

    storePosition.forEach(async (coords) => {
      console.log(coords);
      await new google.maps.Marker({
        position: new google.maps.LatLng(parseFloat(coords.lat), parseFloat(coords.lng)),
        map: map,
        title: 'Hello World!',
      })
    })
  } else {
    console.log('Erreur');
    map = await new google.maps.Map(document.getElementById('map'), {
      mapId: '981b93be4c70d164',
      center: { lat: 50.6364791975973, lng: 3.069550812929656 },
      zoom: 9,
    })
  }
}

window.initMap = initMap

