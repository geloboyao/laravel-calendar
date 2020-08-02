<template>
  <div
    class="calendar-day col-md-12 row"
    v-bind:class="{ 'bg-success text-white' : is_event }"
  >
    <div class="col-md-4">
      <span class="event-date">{{ date }}</span>
      <span class="event-day">{{ day }}</span>
    </div>

    <div class="col-md-8">
      <span v-if="is_event" class="event-name">{{ event_name }}</span>
      <span v-else>&nbsp;</span>
    </div>
  </div>
</template>

<script>
  export default {
    props: ['day', 'date', 'is_event', 'event_name']
  }
</script>
