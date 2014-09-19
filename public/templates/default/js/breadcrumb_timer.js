$(document).ready(function () {

    if ($('#breadcrumb-clock-timer-hours, #breadcrumb-clock-timer-minutes, #breadcrumb-clock-timer-seconds').length > 0) {
        var $hours = $('#breadcrumb-clock-timer-hours')
            ,$minutes = $('#breadcrumb-clock-timer-minutes')
            ,$seconds = $('#breadcrumb-clock-timer-seconds');

        window.setInterval(function () {
            var hours = parseInt($hours.html())
                ,minutes = parseInt($minutes.html())
                ,seconds = parseInt($seconds.html());

            seconds++;

            if (seconds == 60) {
                minutes++;
                $seconds.html('00');
            } else {
                if (seconds.toString().length < 2)
                    $seconds.html('0' + seconds.toString());
                else
                    $seconds.html(seconds);
            }

            if (minutes == 60) {
                hours++;
                $minutes.html('00');
            } else {
                if (minutes.toString().length < 2)
                    $minutes.html('0' + minutes.toString());
                else
                    $minutes.html(minutes);
            }

            if (hours == 25)
                $hours.html('01');
            else {
                if (hours.toString().length < 2)
                    $hours.html('0' + hours.toString());
                else
                    $hours.html(hours);
            }
        }, 1000);
    }

});