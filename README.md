astroweb-php
============

Light Php client to work with astroweb

There are examples in src/examples which show how to use this code.

To generate json for use with html5chart, you will need to add some properties using
WheelJson::setLegendData which takes an associative array. The following keys are used
name1, date1, time1, in biwheel charts, name2, date2 and time2 refer to these fields in the other wheel.
In a ntal chart name2, date2, and time2 are location, longitude and latitude
