<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Calendar</title>

    <link rel="stylesheet" type="text/css" href="css/app.css">

    {{-- Styles --}}
    <style>
      #app {
        margin-top: 10px;
      }
      .calendar-day {
        border-bottom: 1px #E5E5E5 solid;
        padding: 10px;
      }
      .calendar-day:first-child {
        border-top: 1px #E5E5E5 solid;
      }
      .mx-datepicker {
        position: inherit !important;
        display: inherit !important;
        width: auto !important;
      }
      .mx-icon-calendar {
        display: none;
      }
      .date-to {
        margin-left: 15px;
      }
    </style>

    <script>
      window.month = '{{ $month }}';
      window.year = '{{ $year }}';
    </script>
  </head>

  <body>
    <div id="app" class="content">
      <calendar-component></calendar-component>
    </div>

    <script src="js/app.js"></script>
  </body>
</html>
