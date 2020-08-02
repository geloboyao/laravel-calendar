<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">Calendar Event for the Month</div>

          <div class="card-body">
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-4">
                  <div class="row">
                    <h2>Event</h2>

                    <form id="submit-form" class="submit-form" @submit.prevent="submitForm">
                      <div class="col-md-12">
                        <div class="row">
                          <p v-if="this.errors.length">
                            <b>Please correct the following error(s):</b>
                            <ul>
                              <li v-for="error in errors">{{ error }}</li>
                            </ul>
                          </p>

                          <div class="col-md-12 row">
                            <label for="event-name">Event Name</label>
                            <input
                              id="event-name"
                              class="form-control"
                              name="event_name"
                              v-model="event_name"
                              placeholder="Event Name"
                            >
                          </div>

                          <div class="col-md-6 row">
                            <div class="form-group">
                              <label for="event-from">From</label>
                              <date-picker
                                v-model="event_from"
                                format="YYYY-MM-DD"
                                :editable="false"
                                :disabled-date="date_range"
                                :default-value="event_from"
                                :type="'date'"
                                :clearable="false"
                                :input-class="'form-control'"
                              ></date-picker>
                            </div>
                          </div>

                          <div class="col-md-6 row date-to">
                            <div class="form-group">
                              <label for="event-to">To</label>
                              <date-picker
                                v-model="event_to"
                                format="YYYY-MM-DD"
                                :editable="false"
                                :disabled-date="date_range"
                                :default-value="event_to"
                                :type="'date'"
                                :clearable="false"
                                :input-class="'form-control'"
                              ></date-picker>
                            </div>
                          </div>

                          <div class="col-md-12 row">
                            <div class="event-days form-group">
                              <label for="event-days">Days</label><br>
                              <input type="checkbox" id="sun" value="0" v-model="event_day">
                              <label for="sun">Sun</label>
                              <input type="checkbox" id="mon" value="1" v-model="event_day">
                              <label for="mon">Mon</label>
                              <input type="checkbox" id="tue" value="2" v-model="event_day">
                              <label for="tue">Tue</label>
                              <input type="checkbox" id="wed" value="3" v-model="event_day">
                              <label for="wed">Wed</label>
                              <input type="checkbox" id="thu" value="4" v-model="event_day">
                              <label for="thu">Thu</label>
                              <input type="checkbox" id="fri" value="5" v-model="event_day">
                              <label for="fri">Fri</label>
                              <input type="checkbox" id="sat" value="6" v-model="event_day">
                              <label for="sat">Sat</label>
                            </div>
                          </div>

                          <div class="col-md-12 row">
                            <input type="submit" value="Save" class="btn btn-primary">
                          </div>
                        </div>
                      </div>
                    </form>
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
  import DatePicker from 'vue2-datepicker';
  import VueToast from 'vue-toast-notification';
  import VueMoment from 'vue-moment'
  import moment from 'moment-timezone'

  import 'vue2-datepicker/index.css';
  import 'vue-toast-notification/dist/theme-default.css';

  Vue.use(VueToast);
  Vue.use(VueMoment, {
    moment
  });

  function Day({id, day, date, is_event, event_name}) {
    this.id = id;
    this.day = day;
    this.date = date;
    this.is_event = is_event;
    this.event_name = event_name;
  }

  export default {
    mounted() {
      document.getElementById('date').innerHTML = window.month + ' ' + window.year;
    },
    data() {
      return {
        days: [],
        event_name: '',
        event_from: '',
        event_to: '',
        event_day: {},
        errors: []
      }
    },
    methods: {
      async read() {
        const { data } = await window.axios.get('/api/calendar/show');

        for (var i = 0; i < data['dates'].length; i++) {
          this.$set(this.days, i, new Day(data['dates'][i]));
          this.$set(this.days, i, new Day(data['dates'][i]));
        }

        this.$set(this, 'event_name', data['event_name']);
        this.$set(this, 'event_day', data['event_day']);
        this.$set(this, 'event_from', new Date(data['event_from']));
        this.$set(this, 'event_to', new Date(data['event_to']));
      },
      async update(event_name, event_day, event_from, event_to) {
        var days = JSON.stringify(event_day);

        await window.axios.put(`/api/calendar/1`, { event_name, days, event_from, event_to });

        let toast = Vue.$toast.open({
          message: 'Event successfully updated.',
          type: 'success',
          position: 'top-right'
        });

        this.read();
      },
      async submitForm(e) {
        this.validate();

        var event_from = moment(this.event_from).format('YYYY-MM-DD');
        var event_to = moment(this.event_to).format('YYYY-MM-DD');

        if (this.errors.length < 1) {
          this.update(this.event_name, this.event_day, event_from, event_to);
        }
      },
      async validate() {
        this.errors = [];

        if (!this.event_name) {
          this.errors.push('Event Name required');
        }

        if (this.event_day.length < 1) {
          this.errors.push('At least one day is required');
        }

        if (!this.event_from) {
          this.errors.push('Event From Date required');
        }

        if (!this.event_to) {
          this.errors.push('Event To Date required');
        }

        var date_to = new Date(this.event_to);
        var date_from = new Date(this.event_from);

        if (date_from > date_to) {
          this.errors.push('Event To must be greater than Event From');
        }

        if (this.errors.length) {
          e.preventDefault();
        }
      },
      date_range(date) {
        const start = new Date('2020-07-31');

        return date < start || date > new Date('2020-08-31');
      }
    },
    created() {
      this.read();
    },
    components: {
      EventComponent,
      DatePicker
    }
  }
</script>
