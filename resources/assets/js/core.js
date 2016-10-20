(function() {

    // make sure u use delegation!
    $(document.body).on('submit', 'form[data-remote]', function(e) {
        var form = $(this);
        var method = form.find('input[name="_method"]').val() || 'POST';
        var url = form.attr('action');

        $.ajax({
            url: url,
            type: method,
            data: form.serialize(),
            success: function()
            {
                var redirect = form.data('remote-success-redirect');
                redirect && (window.location = redirect);

                // refresh the form using pjax
                $.vain.pjax.refresh(function () {
                    var message = form.data('remote-success-message');
                    message && $.vain.notify.success(message);
                });
            },
            error: function()
            {
                // refresh the form using pjax
                $.vain.pjax.refresh(function () {
                    var message = form.data('remote-error-message');
                    message && $.vain.notify.error(message);
                });
            }
        });

        e.preventDefault();
    });

    // make sure u use delegation!
    $(document.body).on('click', 'input[data-confirm], button[data-confirm]', function(e) {
        var input = $(this);
        var form = input.closest('form');

        $.vain.confirm(input.data('confirm'), function (result) {
            if (result)
                form.submit();
        });

        e.preventDefault();
    });

    // make sure u use delegation!
    $(document.body).on('click', 'a[data-submit]', function(e) {
        $(this).closest('form').submit();

        e.preventDefault();
    });

    // may be used to serve automatically expanding textareas
    $(document.body).on('focus', 'textarea[data-expand]', function(e) {

        var textarea = $(this);
        var maxRows = textarea.data('expand-rows-max');
        // min-rows is optional - current rows are taken instead then
        var minRows = textarea.data('expand-rows-min') ? textarea.data('expand-rows-min') : textarea.attr('rows');
        textarea.data('expand-rows-min', minRows);

        textarea.attr('rows', maxRows);

        textarea.on('blur', function(e) {

            var self = $(this);

            if (self.val().length < 1)
                self.attr('rows', textarea.data('expand-rows-min'));
        });

        e.preventDefault();
    });

    /**
     * this actions will be triggered on every ().ready and ().vain.pjax.complete
     */
    var onLoad = function() {

        $('[data-dependent-field]').each(function () {
            var el = $(this);
            var field = el.data('dependent-field');
            var monitor = el.data('dependent-value');

            // define resuable visibility handler
            var handleVisible = function(el, value, monitor) {
                value == monitor ? el.show() : el.hide();
            };

            // initial state
            handleVisible(el, $('[name="'+ field +'"]').val(), monitor);

            // bind events for runtime state changes
            $(document.body).on('change', '[name="'+ field +'"]', function(e) {
                handleVisible(el, $(this).val(), monitor);
            });
        });

        $('[data-editor]').each(function() {

            // set language if possible
            var lang = $(this).data('editor-lang');
            lang && (CKEDITOR.config.language = lang);

            // replace the editor
            var id = $(this).attr('id') ;
            id && CKEDITOR.replace(id);
        });

        $('[data-auto-active]').each(function() {

            var element = $(this);

            var cls = element.data('auto-active') || 'active';
            element.find(':first-child').first().addClass(cls);
        });

        $('[data-treegrid]').treegrid({
            expanderExpandedClass: 'fa fa-minus-square-o',
            expanderCollapsedClass: 'fa fa-plus-square-o',
            initialState: 'collapsed'
        });

        $('[data-select]').selectpicker();
    };

    $(function() {
        $(document).on('ready', onLoad);

        $.vain.pjax.options.complete = onLoad;
    });
})();

