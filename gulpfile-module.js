var _ = require('lodash');

var scripts_include = [
    /*
     |--------------------------------------------------------------------------
     | Vendor Javascript
     |--------------------------------------------------------------------------
     */
    './node_modules/jquery/dist/jquery.js',
    './node_modules/bootstrap/dist/js/bootstrap.js',
    './node_modules/toastr/toastr.js',
    './node_modules/jquery-treegrid/js/jquery.treegrid.js',
    './node_modules/jquery-treegrid/js/jquery.treegrid.bootstrap3.js',
    './node_modules/bootstrap-select/dist/js/bootstrap-select.js',
    './node_modules/wowjs/dist/wow.js',

    /*
     |--------------------------------------------------------------------------
     | App Javascript
     |--------------------------------------------------------------------------
     */
    './node_modules/vain/resources/assets/js/app.js',
    './node_modules/vain/resources/assets/js/modal.js',
    './node_modules/vain/resources/assets/js/notify.js',
    './node_modules/vain/resources/assets/js/pjax.js',
    './node_modules/vain/resources/assets/js/hero.js',
    './node_modules/vain/resources/assets/js/parallax.js',
    './node_modules/vain/resources/assets/js/core.js',
    './node_modules/vain/resources/assets/js/frontend.js',
];

var scripts_admin_include = [
    './node_modules/admin-lte/dist/js/app.js',
    './node_modules/vain/resources/assets/js/search.js'
];

var styles_include = [
    './node_modules/vain/resources/assets/less/app.less',
    './node_modules/vain/resources/assets/less/frontend.less'
];

var styles_admin_include = [
    './node_modules/vain/resources/assets/less/app.less',
    './node_modules/vain/resources/assets/less/backend.less'
];

var default_opts = {
    'mix_less': true,
    'mix_js': true,
    'copy_fonts': true,
    'copy_placeholder_img': true,

    'extra_less': [],
    'extra_js': [],

    'extra_admin_less': [],
    'extra_admin_js': [],

    'output_dir': 'public/static',

    'css_file': 'frontend.css',
    'js_file': 'app.js',

    'admin_css_file': 'backend.css',
    'admin_js_file': 'admin.js'
};

module.exports = function (mix, opts) {

    opts = _.merge(default_opts, opts);

    // compile less
    if (opts.mix_less) {
        opts.extra_less.forEach(function (style) {
            styles_include.push(style)
        });

        opts.extra_admin_less.forEach(function (style) {
            styles_admin_include.push(style)
        });

        mix.less(styles_include, opts.output_dir + '/css/' + opts.css_file);
        mix.less(styles_admin_include, opts.output_dir + '/css/' + opts.admin_css_file);
    }

    // concat scripts
    if (opts.mix_js) {
        opts.extra_js.forEach(function (script) {
            scripts_include.push(script)
        });

        opts.extra_admin_js.forEach(function (script) {
            scripts_admin_include.push(script)
        });

        mix.scripts(scripts_include, opts.output_dir + '/js/' + opts.js_file, './');
        mix.scripts(scripts_admin_include, opts.output_dir + '/js/' + opts.admin_js_file, './');
        // NOTE: watcher for every given script are added automatically
    }

    // copy admin statics
    //mix.copy('./node_modules/admin-lte/plugins', 'public/static/plugins');

    // copy fonts
    if (opts.copy_fonts) {
        mix.copy('./node_modules/bootstrap/dist/fonts', opts.output_dir + '/fonts');
        mix.copy('./node_modules/font-awesome/fonts', opts.output_dir + '/fonts');
        mix.copy('./node_modules/vain/resources/assets/fonts', opts.output_dir + '/fonts');
    }

    // copy images
    if (opts.copy_placeholder_img) {
        mix.copy('./node_modules/vain/resources/assets/img', opts.output_dir + '/images');
    }
};

