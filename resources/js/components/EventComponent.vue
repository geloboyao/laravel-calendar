<template>
  <div class="day">
    {{ date }} {{ day }}
  </div>
</template>

<script>
  export default {
    props: ['day', 'date', 'is_event', 'event_name']
  }
</script>
