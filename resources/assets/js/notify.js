(function($) {

    var Notify = function() {
        this.$responseCodes = {
            HTTP_OK: 200,
            HTTP_UNAUTHORIZED: 401,
            HTTP_FORBIDDEN: 403,
            HTTP_NOT_FOUND: 404,
            HTTP_ERROR: 500
        };

        this.configure({
            "newestOnTop": true,
            "preventDuplicates": true,
            "positionClass": "toast-bottom-right"
        });

    };

    /**
     * overwrite the current config
     *
     * @param options
     */
    Notify.prototype.configure = function(options) {
        $.extend(toastr.options, options);
    }

    Notify.prototype.info = function(message, title) {
        toastr["info"](message, title);
    }

    Notify.prototype.success = function(message, title) {
        toastr["success"](message, title);
    }

    Notify.prototype.warning = function(message, title) {
        toastr["warning"](message, title);
    }

    Notify.prototype.error = function(message, title) {
        toastr["error"](message, title);
    }

    /**
     * automatically handles an error from an jQuery
     * jqXHR object
     *
     * @param object
     */
    Notify.prototype.handle = function(object) {
        var code = object.status;
        var message = this._parse(object.responseText);

        //noinspection FallthroughInSwitchStatementJS
        switch (code) {
            case this.$responseCodes.HTTP_OK:
                this.success(message);
                break;

            case this.$responseCodes.HTTP_UNAUTHORIZED:
            case this.$responseCodes.HTTP_FORBIDDEN:
            case this.$responseCodes.HTTP_NOT_FOUND:
            case this.$responseCodes.HTTP_ERROR:
            default:
                this.error(message);
                break;
        }
    }

    /**
     * helper to parse an exception
     * message content
     *
     * @param data
     * @returns {*}
     * @private
     */
    Notify.prototype._parse = function(data) {
        try
        {
            var obj = $.parseJSON(data);
            if (obj.message)
                return obj.message;
        }
        catch (e)
        {
            return null;
        }
    }
    
    $(function() {
        $.vain.extend({
            notify: new Notify()
        });
    });

})(jQuery);