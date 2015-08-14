BREND = null;

jQuery(function() {
    function relative_time(time, basis) {
        var scales = [
            ['second', 60],
            ['minute', 60],
            ['hour', 24],
            ['day', 7],
            ['week', 4],
            ['month', 12],
            ['year', Number.MAX_VALUE]
        ];

        basis = basis || new Date();

        var delta = Math.floor(basis / 1000) - Math.floor(time / 1000);
        var future = (delta < 0);
        var delta = Math.abs(delta);

        if(delta < 10) {
            return future ? "momentarily" : "just now";
        }

        for(var i=0; i < scales.length; i++) {
            var scale = scales[i][0];
            var factor = scales[i][1];

            if(delta == 0) {
                return future
                    ? ("in less than 1 " + scale)
                    : ("less than 1 " + scale + "ago");
            } else if(delta == 1) {
                return future
                    ? ("in 1 " + scale)
                    : ("1 " + scale + " ago");
            } else if(delta < factor) {
                return future
                    ? ("in "+delta + " " + scale + "s")
                    : ("" + delta + " " + scale + "s ago");
            } else {
                delta = Math.floor(delta / factor);
            }
        }

        return "outside of time";
    }

    function update_relative_times() {
        jQuery('.stratatimetypes-relative').each(function() {
            var $x = jQuery(this);
            var time = Date.parse($x.attr('data-time'));
            $x.text(relative_time(time));
        });
    }

    setInterval(update_relative_times, 1000);
});
