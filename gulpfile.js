var gulp = require('gulp'),
    $ = require('gulp-load-plugins')(),
    _ = require('lodash');

gulp.task('test', function() {
    gulp.src('spec/**/*.php')
        .pipe($.phpspec('', {notify: true}))
        .on('error', $.notify.onError(notification('fail')))
        .pipe($.notify(notification('pass', {'onLast' : true})));
});

gulp.task('watch', ['test'], function() {
    gulp.watch(['src/**/*.php', 'spec/**/*.php'], ['test']);
})

function notification(status, override) {
    var options = {
        title:   ( status == 'pass' ) ? 'Tests Passed' : 'Tests Failed',
        message: ( status == 'pass' ) ? 'All tests have passed!' : 'One or more tests failed...',
        icon:    __dirname + '/node_modules/gulp-phpspec/assets/test-' + status + '.png'
    };
    options = _.merge(options, override);
    return options;
}