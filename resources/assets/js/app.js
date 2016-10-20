(function() {

    // registring the vain namespace
    $.extend({
        vain: $.prototype
    });

    // setup jquery
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

})();

