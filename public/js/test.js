// let userLat = parseFloat(document.getElementById('lat').value);
// let userLng = parseFloat(document.getElementById('lng').value);
console.log('hello');
async function getStores() 
    try{
        let data = await fetch('http://127.0.0.1:8080/store/locator',
        {method:'GET', 
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With' : 'XMLHttpRequest'
        },
        data:{data:'test'}
        });
        let res = await data.json();
        console.log(data.headers.get('Content-Type'));
        console.log(res);
        return res.position;
    }catch(error){
        console.error('ERROR',error)
    }


getStores();

function getDistanceFromLatLonInKm(userLat,userLng,storeLat,storeLng) {
    var R = 6371; // Radius of the earth in km
    var dLat = deg2rad(storeLat-userLat);  // deg2rad below
    var dLon = deg2rad(storeLng-userLng); 
    var a = 
      Math.sin(dLat/2) * Math.sin(dLat/2) +
      Math.cos(deg2rad(userLat)) * Math.cos(deg2rad(storeLat)) * 
      Math.sin(dLon/2) * Math.sin(dLon/2)
      ; 
    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
    var d = R * c; // Distance in km
    return d;
  }













// let getPosition = $.ajax({
//     url: "http://127.0.0.1:8080/store/locator", // point to server-side PHP script
//     dataType: 'json',
//     type: 'GET',
//     success: function (data) {
//         console.log(data);
//     }
// });

// $.get('http://127.0.0.1:8080/store/locator', { 'product': this.product },  data => {     
//     console.log(data);

// console.log(position);

;


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




