<template>
  <div class="sw-cms-el-config-product-collection">

    <sw-single-select
        label="Collection Type"
        :options="collectionTypeOptions"
        v-model="element.config.collectionType.value"
    />

    <sw-number-field
        label="Number of products"
        min="1"
        max="50"
        v-model="element.config.limit.value"
    />

    <sw-single-select
        label="Layout"
        :options="layoutOptions"
        v-model="element.config.layout.value"
    />

    <sw-number-field
        v-if="element.config.collectionType.value === 'new_arrivals'"
        label="Show products from last X days"
        min="1"
        max="365"
        v-model="element.config.days.value"
    />

  </div>
</template>

<script>
export default {
  props: {
    element: {
      type: Object,
      required: true
    }
  },

  computed: {
    collectionTypeOptions() {
      return [
        { label: 'New Arrivals', value: 'new_arrivals' },
        { label: 'Trending Products', value: 'trending' },
        { label: 'Featured Products', value: 'featured' },
        { label: 'Seasonal Products', value: 'seasonal' }
      ];
    },

    layoutOptions() {
      return [
        { label: 'Grid', value: 'grid' },
        { label: 'Slider', value: 'slider' }
      ];
    }
  }
};
</script>
