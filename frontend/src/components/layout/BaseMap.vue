<template>
  <div ref="map" style="height:800px">
    <div class="geolocation-control">
      <button ref="geolocateButton" class="geolocate-button" title="Geolocate" @click="geolocation.setTracking(true)"></button>
    </div>
  </div>
</template>

<script>
import Map from 'ol/Map';
import View from 'ol/View';
import {Feature, Geolocation} from 'ol';
import {Control} from 'ol/control';
import Point from 'ol/geom/Point';
import {OSM, Vector as VectorSource} from 'ol/source';
import {Circle as CircleStyle, Fill, Stroke, Style} from 'ol/style';
import {Tile as TileLayer, Vector as VectorLayer} from 'ol/layer';

import {ref} from 'vue';
import {defineComponent} from 'vue';

export default defineComponent({
  name: 'BaseMap',
  setup() {
    const data = {
      rotation: ref(0),
      zoom: ref(8),
      projection: ref('EPSG:4326'),
      center: ref([40, 40]),
      map: ref(null),
      geolocateButton: ref(null),
    };

    const view = ref(
      new View({
        center: data.center.value,
        zoom: data.zoom.value,
      })
    );
    const geolocation= ref(
      new Geolocation({
        trackingOptions: {
          enableHighAccuracy: true,
        },
        projection: view.value.getProjection(),
      })
    );
    return {...data, view, geolocation};
  },
  mounted() {
    const geolocation = this.geolocation
    const geolocationControl = new Control({
      element: this.geolocateButton,
    });

    geolocationControl.setProperties({geolocation});

    const map = new Map({
      target: this.map,
      layers: [
        new TileLayer({
          source: new OSM(),
        }),
      ],
      view: this.view,
      controls: [
        geolocationControl,
      ],
    });

    const accuracyFeature = new Feature();
    geolocation.on('change:accuracyGeometry', function () {
      accuracyFeature.setGeometry(geolocation.getAccuracyGeometry());
    });

    const positionFeature = new Feature();
    positionFeature.setStyle(
      new Style({
        image: new CircleStyle({
          radius: 6,
          fill: new Fill({
            color: '#3399CC',
          }),
          stroke: new Stroke({
            color: '#fff',
            width: 2,
          }),
        }),
      })
    );

    geolocation.on('change:position', function () {
      const coordinates = geolocation.getPosition();
      positionFeature.setGeometry(coordinates ? new Point(coordinates) : null);
    });

    new VectorLayer({
      map: map,
      source: new VectorSource({
        features: [accuracyFeature, positionFeature],
      }),
    });
    
  }
});
</script>

<style>
.geolocation-control {
  position: absolute;
  top: 10px;
  left: 10px;
}

.geolocate-button {
  width: 32px;
  height: 32px;
  background-color: black;
  background-repeat: no-repeat;
  background-position: center;
  background-size: 24px;
  border: none;
  outline: none;
}
</style>
