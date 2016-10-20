(function($) {

    var Pjax = function() {};

    Pjax.prototype.options = {
        element: '[data-pjax]',
        complete: null
    }

    /**
     * refreshes the current page via pjax
     * once finished the callback is called
     *
     * @param callback
     */
    Pjax.prototype.refresh = function(callback) {
        this.load(location.href, callback);
    }

    /**
     * loads the url into the current page
     * once finished the callback is called
     *
     * @param url
     * @param callback
     */
    Pjax.prototype.load = function(url, callback) {
        var self = this;

        $.ajax({
            url: url,
            success: function(page)
            {
                // replace the target document
                self._replace(self.options.element, page);

                // notify we are finished
                callback && callback();
            },
            complete: function()
            {
                // if a global notifier is set we use this
                self.options.complete && self.options.complete();
            }
        });
    }

    /**
     * replaces the content of the selector
     * with the fetched page
     *
     * @param selector
     * @param page
     * @private
     */
    Pjax.prototype._replace = function(selector, page) {
        var scroll = $(window).scrollTop(); // save the scroll position

        var body = this._locate(selector, page).html();
        $(selector).html(body); // replace the selector

        $(window).scrollTop(scroll); // set the scroll position
    }

    /**
     * somehow $.filter() is not always working
     * but then $.find() does although it should not...
     * we handle the cases here.
     *
     * @param selector
     * @param page
     * @returns {*}
     * @private
     */
    Pjax.prototype._locate = function(selector, page) {
        var body = $(page).filter(selector);

        if (body.length === 0)
        {
            body = $(page).find(selector);
        }

        return body;
    }

    $(function() {
        $.vain.extend({
            pjax: new Pjax()
        });
    });

})(jQuery);