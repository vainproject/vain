(function($) {

    var Parallax = function(selector) {
        selector = selector || this.options.element; // default value
        this.init(selector); // autoboot this plugin
    };

    Parallax.prototype.options = {
        element: '[data-parallax]',
        threshold: 125,
        thwart: 4
    }

    /**
     * constructs this instance and auto-configures the
     * plugin to the current context
     *
     * @param selector
     */
    Parallax.prototype.init = function(selector) {
        var self = this;

        // default positon
        this._position(selector);

        // hook on scroll event and modify position
        $(window).on('scroll', function() {
            var offset = self._calculate(
                self.options.threshold,
                self.options.thwart);

            self._position(selector, offset);
        });
    }

    /**
     * calculates the necessary offset for an background image
     * depending on current scroll position to create
     * a parallax effect
     *
     * @param threshold
     * @param thwart
     * @returns {number}
     * @private
     */
    Parallax.prototype._calculate = function(threshold, thwart) {
        var scroll = $(window).scrollTop(),
            offset = -(scroll / thwart);

        // we need some boundaries
        if (offset < -threshold)
            offset = -threshold;

        return offset;
    }

    /**
     * Sets the background position relative to an offset
     * to generate a smooth parallax effect
     *
     * @param selector
     * @param offset
     * @private
     */
    Parallax.prototype._position = function(selector, offset) {
        offset = offset || 0; // default value

        $(selector).stop().css("background-position", "50% " + offset + "px");
    }

    $(function() {
        $.vain.extend({
            parallax: new Parallax()
        });
    });

})(jQuery);