<template>
  <div ref="map" class="mapContainer" style="height:800px">
    <div ref="controls" class="mapControl">
      <button
        ref="geolocateButton"
        class="geolocate-button"
        title="Geolocate"
        @click="geolocation.setTracking(true)"
      >
        <i class="fa-solid fa-location-dot"></i>
      </button>
    </div>

  </div>
</template>

<script>
import Map from 'ol/Map';
import View from 'ol/View';
import {Feature, Geolocation} from 'ol';
import {Control, Zoom} from 'ol/control';
import Point from 'ol/geom/Point';
import {OSM, Vector as VectorSource} from 'ol/source';
import {Fill, Stroke, Style, Text} from 'ol/style';
import {Tile as TileLayer, Vector as VectorLayer} from 'ol/layer';
import "ol/ol.css"
import {ref} from 'vue';
import {defineComponent} from 'vue';
import {useLocationStore} from "~/stores";

export default defineComponent({
  name: 'BaseMap',
  setup() {
    const locationStore = useLocationStore();
    
    const data = {
      rotation: ref(0),
      zoom: ref(3),
      projection: ref('EPSG:4326'),
      center: ref([0, 0]),
      map: ref(null),
      geolocateButton: ref(null),
      controls: ref(null),
    };

    const view = ref(
      new View({
        center: data.center.value,
        zoom: data.zoom.value,
      })
    );
    const geolocation = ref(
      new Geolocation({

        projection: view.value.getProjection(),
      })
    );
    return {...data, view, geolocation, locationStore};
  },
  async mounted() {
    const geolocation = this.geolocation

    const controls = [
      new Control({
        element: this.geolocateButton,
        target: this.controls
      }),
      new Zoom({
        target: this.controls
      })
    ];

    controls[0].setProperties({geolocation});

    const map = new Map({
      target: this.map,
      layers: [
        new TileLayer({
          source: new OSM(),
        }),
      ],
      view: this.view,
      controls: controls,
    });

    const positionFeature = new Feature();
    positionFeature.setStyle(
      new Style({
        text: new Text({
          text: '\uf015',
          scale: 1.5,
          font: '900 18px "Font Awesome 6 Free"',
          textBaseline: 'bottom',
          fill: new Fill({
            color: '#505050',
          }),
          stroke: new Stroke({
            color: '#fff',
            width: 3,
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
        features: [positionFeature],
      }),
    });

    await this.locationStore.getData()
    
    console.log(this.locationStore.elements)
    
  },
});
</script>

<style lang="scss">
.mapContainer {
  position: relative;
}

.mapControl {
  position: absolute;
  z-index: 1;
  right: 10px;
  top: 10px;
  display: flex;
  flex-direction: column;
  box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);

  button {
    width: 32px;
    height: 32px;
    background-color: white;
    border: none;

    &:hover {
      background: #eee;
      outline: none;
    }
  }

  .geolocate-button {
    border-radius: 4px 4px 0 0;
    background-color: white;

  }

  .ol-zoom {
    top: 0;
    left: 0;

    .ol-zoom-in {
      border-radius: 0;
      margin: 0;
      border-top: 1px solid #e0e0e0;
      border-bottom: 1px solid #e0e0e0;
    }

    .ol-zoom-out {
      margin: 0;
      border-radius: 0 0 4px 4px;

    }
  }
}


.ol-zoom {
  position: relative;

}
</style>
