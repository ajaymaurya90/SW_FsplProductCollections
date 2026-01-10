<template>
  <div class="sw-cms-el-product-collection">
    <h3>Product Collection</h3>
    <p>
      Type: {{ element.config.collectionType.value }} <br>
      Products: {{ element.config.limit.value }}
    </p>
  </div>
</template>

<script>
export default {
  props: {
    element: {
      type: Object,
      required: true
    }
  }
};
</script>
