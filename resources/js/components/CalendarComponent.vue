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
                            <div class="form-group">
                              <label for="event-name">Event Name</label>
                              <input id="event-name" class="form-control" name="event_name" v-model="event_name" placeholder="Event Name">
                            </div>
                          </div>

                          <div class="col-md-6 row">
                            <div class="form-group">
                              <label for="event-from">From</label>
                              <input id="event-from" class="form-control" name="event_from" v-model="event_from">
                              <!-- <functional-calendar v-model="this.event_from" :configs="this.calendarConfigs">
                                <template v-slot:datePickerInput="props">
                                  <div>
                                    <input id="event-from" class="form-control" name="event_from" readonly="true">
                                  </div>
                                </template>
                              </functional-calendar> -->
                            </div>
                          </div>

                          <div class="col-md-6 row">
                            <div class="form-group">
                              <label for="event-to">To</label>
                              <input id="event-to" class="form-control" name="event_to" v-model="event_to">
                              <!-- <functional-calendar v-model="this.event_to" :configs="this.calendarConfigs">
                                <template v-slot:datePickerInput="props">
                                  <div>
                                    <input id="event-to" class="form-control" name="event_to" readonly="true">
                                  </div>
                                </template>
                              </functional-calendar> -->
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
  import { FunctionalCalendar } from 'vue-functional-calendar';

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
        /*event_from: {
          selectedDates: [],
          selectedDate: false,
          selectedDateTime: false,
          selectedHour: '00',
          selectedMinute: '00',
          selectedDatesItem: '',
          dateRange: {
            'start': {
              'date': false,
              'dateTime': false,
              'hour': '00',
              'minute': '00'
            },
            'end': {
              'date': false,
              'dateTime': false,
              'hour': '00',
              'minute': '00'
            }
          }
        },
        event_to: {
          selectedDates: [],
          selectedDate: false,
          selectedDateTime: false,
          selectedHour: '00',
          selectedMinute: '00',
          selectedDatesItem: '',
          dateRange: {
            'start': {
              'date': false,
              'dateTime': false,
              'hour': '00',
              'minute': '00'
            },
            'end': {
              'date': false,
              'dateTime': false,
              'hour': '00',
              'minute': '00'
            }
          }
        },*/
        event_from: '',
        event_to: '',
        event_day: {},
        errors: [],
        calendarConfigs: {
          dateFormat: 'mm/dd/yyyy',
          sundayStart: true,
          isDatePicker: true,
          isModal: true,
          limits: {min: '08/01/2020', max: '08/31/2020'}
        },
      }
    },
    methods: {
      async read() {
        // this.event_from.selectedDates = [];
        // this.event_to.selectedDates = [];
        const { data } = await window.axios.get('/api/calendar/show');

        for (var i = 0; i < data['dates'].length; i++) {
          this.$set(this.days, i, new Day(data['dates'][i]));
          this.$set(this.days, i, new Day(data['dates'][i]));
        }

        this.$set(this, 'event_name', data['event_name']);
        this.$set(this, 'event_day', data['event_day']);
        this.$set(this, 'event_from', data['event_from']);
        this.$set(this, 'event_to', data['event_to']);

        // this.event_from.selectedDates.push({'date': data['event_from'], 'dateTime': false});
        // this.event_to.selectedDates.push({'date': data['event_to'], 'dateTime': false});
      },
      async update(event_name, event_day, event_from, event_to) {
        var days = JSON.stringify(event_day);

        await window.axios.put(`/api/calendar/1`, { event_name, days, event_from, event_to });

        this.read();
      },
      async submitForm(e) {
        this.validate();

        this.update(this.event_name, this.event_day, this.event_from, this.event_to);
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

        if (this.errors.length) {
          e.preventDefault();
        }
      }
    },
    created() {
      this.read();
    },
    components: {
      EventComponent,
      FunctionalCalendar
    }
  }
</script>
