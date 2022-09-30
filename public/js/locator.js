let map;
const locationPointer = document.getElementById('location-point');
console.log(locationPointer);

async function initMap() {
    map = new google.maps.Map(document.getElementById("map"), {
        mapId: "981b93be4c70d164",
        center: { lat: 50.62936847746803, lng: 3.0572192078331324 },
        zoom: 16,
    });
    
infoWindow = new google.maps.InfoWindow();

    console.log('hello', infoWindow);

    locationPointer.addEventListener('click', () => {
        map = new google.maps.Map(document.getElementById("map"), {
            mapId: "981b93be4c70d164",
            center: { lat: 50.62936847746803, lng: 3.0572192078331324 },
            zoom: 16,
        });
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude,
                    };
                    console.log(pos);
                    infoWindow.setPosition(pos);
                    infoWindow.setContent("Location found.");
                    infoWindow.open(map);
                    map.setCenter(pos);
                },
                () => {
                    handleLocationError(true, infoWindow, map.getCenter());
                }
            );
        } else {
            // Browser doesn't support Geolocation
            handleLocationError(false, infoWindow, map.getCenter());
        };

        function handleLocationError(browserHasGeolocation, infoWindow, pos) {
            infoWindow.setPosition(pos);
            infoWindow.setContent(
                browserHasGeolocation
                    ? "Error: The Geolocation service failed."
                    : "Error: Your browser doesn't support geolocation."
            )
        };
        infoWindow.open(map);

    });
    
    
}

window.initMap = initMap;
