let map;
const locationPointer = document.getElementById('location-point');
console.log(locationPointer);

// Geolocation
locationPointer.addEventListener('click', () => {
  window.navigator.geolocation.getCurrentPosition(async function (position) {
    console.log("Position trouvée : Latitude=" + position.coords.latitude + " Longitude=" + position.coords.longitude);
    console.log(position.coords);
    try {
      const rawResponse = await fetch('http://127.0.0.1:8080/location', {
        method: 'POST',
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({ geolocation: position.coords })
      });
      const content = await rawResponse.json();

      console.log(content);
    }
    catch (error) {
      console.error(error);
    }
  }, function (error) {
    console.log("Erreur de géoloc N°" + error.code + " : " + error.message);
    console.log(error);
  });
});

// Location from form
async function getPosition(){
  try{
      let data = await fetch('http://127.0.0.1:8080/location',
      {method:'GET', 
      headers: {
          'Content-Type': 'application/json'
      },
      data:{data:'test'}
      });
      let res = await data.json();
      console.log(data.headers.get('Content-Type'));

      return res.position;
  }catch(error){
      console.error('ERROR',error)
  }

 
}



async function initMap() {
 const position = await getPosition();

 if (position) {
   map = await new google.maps.Map(document.getElementById("map"), {
       mapId: "981b93be4c70d164",
       center: { lat: position.lat, lng: position.lng},
       zoom: 16,
   });  
 }else{
  map = await new google.maps.Map(document.getElementById("map"), {
    mapId: "981b93be4c70d164",
    center: { lat: 50.271196466416896, lng: 3.141769201769933},
    zoom: 9,
});  

 }

}

window.initMap = initMap;



