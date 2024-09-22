'use strict';

// Load plugins
const autoprefixer = require('autoprefixer');
const cp = require('child_process');
const cssnano = require('cssnano');
const del = require('del');
const gulp = require('gulp');
const newer = require('gulp-newer');
const plumber = require('gulp-plumber');
const postcss = require('gulp-postcss');
const rename = require('gulp-rename');
const sass = require('gulp-sass')(require('sass'));
const uglify = require('gulp-uglify');
const concat = require('gulp-concat');
const terser = require('gulp-terser');

// clean
function clean()
{
  return del(['./assets/dist/']);
}

// imges
function images()
{
  return gulp
  .src('./assets/src/image/**/*')
  .pipe(newer('./assets/dist/image'))
  .pipe(gulp.dest('./assets/dist/image'));
}

// css
function css()
{
  return gulp
  .src([
    './node_modules/owl.carousel/dist/assets/owl.carousel.min.css',
    './node_modules/owl.carousel/dist/assets/owl.theme.default.min.css',
    './node_modules/magnific-popup/dist/magnific-popup.css',
    './node_modules/select2/dist/css/select2.min.css',
    './node_modules/@fortawesome/fontawesome-free/css/all.css',
    './assets/src/scss/main.scss',
  ])
  .pipe(plumber())
  .pipe(concat('main.css'))
  .pipe(sass({ outputStyle: "expanded" }))
  .pipe(gulp.dest("./assets/dist/css/"))
  .pipe(postcss([autoprefixer()]))
  .pipe(gulp.dest("./assets/dist/css/"))
  .pipe(gulp.dest("./assets/dist/css/"))
  .pipe(rename({ suffix: ".min" }))
  .pipe(postcss([cssnano()]))
  .pipe(gulp.dest("./assets/dist/css/"))
  .pipe(browsersync.stream());
}

// scripts
function scripts()
{
  return (
    gulp
      .src([
      './node_modules/jquery/dist/jquery.js',
      './node_modules/bootstrap/dist/js/bootstrap.min.js',
      './node_modules/owl.carousel/dist/owl.carousel.js',
      './node_modules/magnific-popup/dist/jquery.magnific-popup.js',
      './node_modules/select2/dist/js/select2.full.min.js',
      './node_modules/jquery-inview/jquery.inview.min.js',
      './node_modules/@fortawesome/fontawesome-free/js/all.js',
      './assets/src/js/**/*',
      '!./assets/src/js/lazy-load.js',
      ])
      .pipe(plumber())
      .pipe(concat('main.js'))
      .pipe(gulp.dest('./assets/dist/js/'))
      .pipe(terser())
      .pipe(rename({ suffix: '.min' }))
      .pipe(gulp.dest('./assets/dist/js/'))
      .pipe(browsersync.stream()
    )
  )
}

function lazyload()
{
  return (
    gulp
      .src(['./assets/src/js/lazy-load.js',])
      .pipe(terser())
      .pipe(rename({ suffix: '.min' }))
      .pipe(gulp.dest('./assets/dist/js')
    )
  )
}

// fonts
function fonts()
{
  return (
  gulp
    .src('./assets/src/fonts/**/*')
    .pipe(plumber())
    .pipe(gulp.dest('./assets/dist/fonts'))
    .pipe(browsersync.stream())
  );
}

// watch changes
function watchFiles()
{
  gulp.watch('./assets/src/scss/**/*', css);
  gulp.watch('./assets/src/js/**/*', scripts);
  gulp.watch('./assets/src/js/**/*', lazyload);
  gulp.watch('./assets/src/image/**/*', images);
  gulp.watch('./assets/src/fonts/**/*', fonts);
}

const start = gulp.series(clean, images, fonts, css, scripts, lazyload);
const watch = gulp.parallel(watchFiles, browserSync);

// export tasks
exports.images = images;
exports.css = css;
exports.scripts = scripts;
exports.clean = clean;
exports.watch = watch;
exports.default = gulp.series(start, watch);
