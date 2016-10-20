(function($) {

    var Hero = function(selector) {
        selector = selector || this.options.element; // default value
        this.init(selector); // autoboot this plugin
    };

    Hero.prototype.options = {
        element: '[data-hero]',
        classes: [
            'image-bg',
            'image-bg2',
            'image-bg3'
        ]
    }

    /**
     * constructs this instance and auto-configures the
     * plugin to the current context
     */
    Hero.prototype.init = function(selector) {
        var clazz = this._randomize(this.options.classes);
        this.load(selector, clazz);
    }

    /**
     * adds the given class to the
     * specified selector
     *
     * @param selector
     * @param clazz
     */
    Hero.prototype.load = function(selector, clazz) {
        $(selector).addClass(clazz);
    }

    /**
     * randomizes through the given array
     * of classes and returns a single entry
     *
     * @param clazzes
     * @private
     */
    Hero.prototype._randomize = function(clazzes) {
        var rnd = Math.floor(Math.random() * clazzes.length);
        return clazzes[rnd];
    }

    $(function() {
        $.vain.extend({
            hero: new Hero()
        });
    });

})(jQuery);