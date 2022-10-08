// console.log('hola');
async function getAddress(){
  try{
      let data = await fetch('http://127.0.0.1:8080/store/address_list',
      {method:'GET',
      headers: {
          'Content-Type': 'application/json',
          'X-Requested-With' : 'XMLHttpRequest'
      },
      });
      let res = await data.json();
      console.log(res);

      return res.position;
  }catch(error){
      console.error('ERROR',error)
  }

}

addressList = getAddress().address;
console.log(addressList);


async function initMap() {
    const position = await getPosition()
  
    if (position) {
      map = await new google.maps.Map(document.getElementById('map'), {
        mapId: '981b93be4c70d164',
        center: { lat: position.lat, lng: position.lng },
        zoom: 16,
      })
    } else {
      map = await new google.maps.Map(document.getElementById('map'), {
        mapId: '981b93be4c70d164',
        center: { lat: 50.271196466416896, lng: 3.141769201769933 },
        zoom: 9,
      })
    }
  }
  
  window.initMap = initMap
  


    // infoWindow = new google.maps.InfoWindow();

    //     console.log('hello', infoWindow);




    //         map = new google.maps.Map(document.getElementById("map"), {
    //             mapId: "981b93be4c70d164",
    //             center: { lat: 50.62936847746803, lng: 3.0572192078331324 },
    //             zoom: 16,
    //         });
    //         if (navigator.geolocation) {
    //             navigator.geolocation.getCurrentPosition(
    //                 (position) => {
    //                     const pos = {
    //                         lat: position.coords.latitude,
    //                         lng: position.coords.longitude,
    //                     };
    //                     console.log(pos);
    //                     infoWindow.setPosition(pos);
    //                     infoWindow.setContent("Location found.");
    //                     infoWindow.open(map);
    //                     map.setCenter(pos);
    //                 },
    //                 () => {
    //                     handleLocationError(true, infoWindow, map.getCenter());
    //                 }
    //             );
    //         } else {
    //             // Browser doesn't support Geolocation
    //             handleLocationError(false, infoWindow, map.getCenter());
    //         };

    //         function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    //             infoWindow.setPosition(pos);
    //             infoWindow.setContent(
    //                 browserHasGeolocation
    //                     ? "Error: The Geolocation service failed."
    //                     : "Error: Your browser doesn't support geolocation."
    //             )
    //         };
    //         infoWindow.open(map);




