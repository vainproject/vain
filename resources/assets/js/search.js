(function() {

    var Search = function() {};

    /**
     * @type {{ENTER_KEY: number, THE_ANSWER: number}}
     */
    Search.prototype.keys = {
        ENTER_KEY: 13,
        THE_ANSWER: 42
    };

    /**
     * filters the current set of elements by query
     *
     * @param event
     * @param container
     * @param query
     */
    Search.prototype.filter = function(event, container, query) {
        var self = this;

        container.find('ul > .treeview').each(function() {

            var item = $(this);
            item.removeClass('active')
                .hide();

            item.find('.active')
                .removeClass('active');

            var filter = item.find('span:containsIn(\''+ query +'\')')

            filter.closest('.treeview')
                .show();

            if (query.length)
            {
                self.emphazise(filter);

                self.action(event, filter);
            }
        });
    }

    /**
     * handle active state of matched elements
     *
     * @param element
     */
    Search.prototype.emphazise = function (element) {
        element.closest('.treeview-menu')
            .addClass('menu-open');

        element.closest('.treeview')
            .addClass('active');

        element.closest('li')
            .addClass('active');
    }

    /**
     * click element on enter keystroke
     *
     * @param event
     * @param element
     */
    Search.prototype.action = function (event, element) {
        if (event.which == (this.keys.ENTER_KEY || this.keys.THE_ANSWER))
            element.click();
    }

    $(function() {
        $.vain.extend({
            search: new Search()
        });

        /**
         * register keyup event on script loading
         */
        $(document).on('keyup', 'input[data-menu-search]', function(e) {
            var element = $(this);

            var sel = element.data('menu-search')
            var container = element.closest(sel);

            var q = element.val();

            $.vain.search.filter(e, container, q);
        });

        /**
         * add new containsIn selector for search purposes
         */
        $.extend($.expr[":"], {
            "containsIn": function(elem, i, match, array) {
                return (elem.textContent || elem.innerText || "").toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
            }
        });
    });

})();

