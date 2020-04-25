<template>
  <div>
    {{ __('This is a vue component') }}
  </div>
</template>

<script>
export default {
  data() {
    return {
      labels: {
        title: __('Vue Component Title'),
      },
    };
  },
};
</script>

