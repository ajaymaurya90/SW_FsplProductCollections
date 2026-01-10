<template>
  <div class="sw-cms-el-preview-product-collection">
    <strong>Product Collection</strong>
    <div class="sw-cms-el-preview-product-collection__type">
      {{ element.config.collectionType.value }}
    </div>
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
