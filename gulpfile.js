'use strict';
var gulp = require('gulp'),
    jshint = require('gulp-jshint'),
    uglify = require('gulp-uglify'),
    rename = require('gulp-rename'),
    clean = require('gulp-clean'),
    concat = require('gulp-concat'),
    notify = require('gulp-notify');
    
var paths = {
    js: ['gulpfile.js','public/init.js', 'public/**/*.js', '!public/bower_components/**'],
    html: ['public/**/views/**'],
    css: ['public/**/css/*.css', '!public/bower_components/**']
};
gulp.task('lint', function() {
  return gulp.src(paths.js)
    .pipe(jshint('.jshintrc'))
    .pipe(jshint.reporter('default'));
});
gulp.task('scripts', function() {
  return gulp.src(['public/**/*.js','!public/bower_components/**'])
    .pipe(jshint('.jshintrc'))
    .pipe(jshint.reporter('default'))
    .pipe(concat('main.js'))
    .pipe(gulp.dest('public/dist/js'))
    .pipe(rename({suffix: '.min'}))
    .pipe(uglify())
    .pipe(gulp.dest('public/dist/js'))
    .pipe(notify({ message: 'Scripts task complete' }));
});
gulp.task('default', function() {
  gulp.start('scripts');
});