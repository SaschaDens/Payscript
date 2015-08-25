var gulp = require('gulp');
var phpspec = require('gulp-phpspec');
var run = require('gulp-run');
var plumber = require('gulp-plumber');

gulp.task('test', function() {
    gulp.src('spec/**/*.php')
        .pipe(run('clear'))
        .pipe(phpspec('', { 'verbose': 'v', notify: true }))
        .on('error', function () {
            console.log('error');
        });
});

gulp.task('watch', function() {
    gulp.watch(['spec/**/*.php', 'src/**/*.php'], ['test']);
});

gulp.task('default', ['test', 'watch']);