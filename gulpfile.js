'use strict';

var gulp = require('gulp');
var sass = require('gulp-sass')(require('sass'));
var uglify = require('gulp-uglify-es').default;
var concat = require('gulp-concat');
var babel = require('gulp-babel');
var cleanCSS = require('gulp-clean-css');


gulp.task('sass', function () {
    return gulp.src('./dist/scss/*.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(cleanCSS())
        .pipe(gulp.dest('./assets/css/'));
});

gulp.task('uglify', function() {
    return gulp.src('./dist/js/*.js')
        .pipe(uglify())
        .pipe(babel({
            presets: ['@babel/env']
        }))
        .pipe(concat('main.min.js'))
        .pipe(gulp.dest('./assets/js/'));
});

gulp.task('sass:watch', function () {
    gulp.watch('./dist/scss/*.scss', gulp.series('sass'));
    gulp.watch('./dist/js/*.js', gulp.series('uglify'));
});