(function($) {

    var Confirm = function(element, callback) {
        this.$element = $(element);
        this.$callback = callback || function(){};

        this.$confirm = this.$element.find('a[data-positive="modal"], button[data-positive="modal"]');
        this.$dismiss = this.$element.find('a[data-dismiss="modal"], button[data-dismiss="modal"]');

        this.init();
    };

    /**
     * virtual contructor
     *
     * attaches click handlers and
     * treats the modal
     */
    Confirm.prototype.init = function() {
        this.$element.modal('show');
        var self = this;

        this.$dismiss.on('click', function() {
            self.$callback(false);

            self.destroy();
        });

        this.$confirm.on('click', function() {
            self.$element.modal('hide');
            self.$callback(true);

            self.destroy();
        });
    }

    /**
     * used to detach the click handlers
     */
    Confirm.prototype.destroy = function() {
        this.$dismiss.off('click');
        this.$confirm.off('click');
        this.$element.off('hidden.bs.modal');
    }

    $(function() {
        $.vain.extend({
            confirm: function (element, callback) {
                return new Confirm(element, callback);
            }
        });
    });

})(jQuery);