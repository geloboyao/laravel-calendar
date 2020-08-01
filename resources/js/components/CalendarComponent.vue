<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">Calendar</div>

          <div class="card-body">
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-4">
                  <div class="row">
                    <form></form>
                    Event
                  </div>
                </div>

                <div class="col-md-8">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="date">
                        <h2 id="date"></h2>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <event-component
                        v-for="day in days"
                        v-bind="day"
                        :key="day.id"
                      ></event-component>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import EventComponent from './EventComponent.vue';

  function Day({id, day, date, is_event}) {
    this.id = id;
    this.day = day;
    this.date = date;
    this.is_event = is_event;
  }

  export default {
    mounted() {
      document.getElementById('date').innerHTML = window.month + ' ' + window.year;
      console.log('Component mounted.');
    },
    data() {
      return {
        days: []
      }
    },
    methods: {
      async read() {
        const { data } = await window.axios.get('/api/calendar/show');
        data.forEach(day => this.days.push(new Day(day)));
        this.days.forEach(day => console.log(day));
        // console.log(this.days);
      },
      async update(id, first_name, last_name, email) {
        this.mute = true;
        await window.axios.put(`/api/users`, { first_name, last_name, email });

        this.events.find(user => user.id === id).first_name = first_name;
        this.events.find(user => user.id === id).last_name = last_name;
        this.events.find(user => user.id === id).email = email;
        this.mute = false;
      },
      async delete(id) {
        await window.axios.delete(`/api/users/${id}`);
        let index = this.users.findIndex(user => user.id === id);
        this.events.splice(index, 1);
      }
    },
    created() {
      this.read();
    },
    components: {
      EventComponent
    }
  }
</script>
