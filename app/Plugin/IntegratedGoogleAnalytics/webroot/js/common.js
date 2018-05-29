function gaTrackerClass() {
    this.cookieVal = false;
    // Grab the cookie, if it exists, store in this.cookieVal
    if (typeof (document.cookie) != "undefined" && document.cookie.length > 0) {
        c_name = 'gatmp'; // Cookie name
        var c_start = document.cookie.indexOf(c_name + "=");
        if (c_start != -1) {
            var v_start = c_start + c_name.length + 1;
            var v_end = document.cookie.indexOf(";", v_start);
            if (v_end == -1) v_end = document.cookie.length;
            this.cookieVal = unescape(document.cookie.substring(v_start, v_end));
            // Unset the cookie so it doesn't get used multiple times
            document.cookie = c_name + "=; expires=Thu, 01-Jan-1970 00:00:10 GMT";
        }
    }
    // Our _trackPageview function. It emulates the behavior of the Google
    // function, using the cookie rather than query parameters in the URL.
    // If no cookie is found, just call the normal _trackPageview function
    this._trackPageview = function (str) {
        if (typeof (pageTracker) != "undefined") {
            if (this.cookieVal != false && typeof (window.location) != "undefined") {
                // Save the current fragment
                var hashtmp = window.location.hash;
                // Call Google Analytics and record the campaign variables
                window.location.hash = '#' + this.cookieVal;
                pageTracker._setAllowHash(true);
                pageTracker._trackPageview(str);
                // Restore the fragment to its original value
                window.location.hash = hashtmp;
            } else {
                pageTracker._trackPageView(str);
            }
        }
    }
}
var gaTracker = new gaTrackerClass();
gaTracker._trackPageview();