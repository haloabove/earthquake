<template>
  <div class="container map" id="map"></div>
</template>
<script>
const loadGoogleMapsApi = require("load-google-maps-api");


axios
  .get(
    "https://earthquake.usgs.gov/earthquakes/feed/v1.0/summary/all_day.geojson"
  )
  .then(response => {
    initGoogleMaps(response.data.features);
  })
  .catch(error => {
    console.log(error);
  });

function initGoogleMaps(locations) {
  loadGoogleMapsApi()
    .then(googleMaps => {
      var map = new googleMaps.Map(document.querySelector(".map"), {
        key: "AIzaSyDB-SzdChBCrHAUu5WighnanxnLx2xKOB4",
        zoom: 1.9,
        center: new googleMaps.LatLng(0, 0)
      });

      var infowindow = new googleMaps.InfoWindow();
      var marker, i;

      for (let location of locations) {
        marker = new googleMaps.Marker({
          position: new googleMaps.LatLng(
            location.geometry.coordinates[1],
            location.geometry.coordinates[0]
          ),
          map: map
        });

        googleMaps.event.addListener(
          marker,
          "click",
          ((marker, i) => {
            return () => {
              infowindow.setContent(
                '<div class="tiho">' +
                  location.properties.title +
                  "<p>" +
                  Date(location.properties.time) +
                  "</p>"
              );
              infowindow.open(map, marker);
            };
          })(marker, i)
        );
      }
    })
    .catch(error => {
      console.error(error);
    });
}

export default {};
</script>

<style lang="scss">
.intro-lead-in,
.intro-heading {
  color: #292b2c;
  font-style: italic;
  line-height: 40px;
  margin-bottom: 25px;
  font-family: "Droid Serif", -apple-system, BlinkMacSystemFont, "Segoe UI",
    Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji",
    "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
}
.intro-heading.text-left {
  max-width: 50%;
  font-size: 25px;
  line-height: 35px;
}
.map {
  color: #292b2c;
  height: 500px;
}
@media (min-width: 768px) {
  header.masthead .intro-text {
    padding-top: 130px;
    padding-bottom: 10px;
  }
  section {
    padding: 50px 0;
  }
  header.masthead .intro-text .intro-heading {
    font-size: 25px;
  }
}
</style>

