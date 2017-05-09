var gulp = require('gulp');
var sass = require('gulp-sass');
var jshint = require('gulp-jshint');
var concat = require('gulp-concat');
var imagemin = require('gulp-imagemin');
var plumber = require('gulp-plumber');
var notify = require('gulp-notify');
var livereload = require('gulp-livereload');

var config = {
    assetBase: './web/assets/',
    materializeSrc: './node_modules/materialize-css/',
    jQuery: './node_modules/jquery/dist/jquery.min.js',
    matchHeight: './node_modules/jquery-match-height/dist/jquery.matchHeight-min.js'
};

var plumberErrorHandler = {errorHandler: notify.onError({
        title: 'Gulp',
        message: 'Error: <%= error.message %>'
    })
};

gulp.task('copySrc', function () {
    gulp.src(config.materializeSrc + "sass/**/**.scss").pipe(gulp.dest(config.assetBase + "sass"));
    gulp.src(config.materializeSrc + "js/**/**.js").pipe(gulp.dest(config.assetBase + "js/src/material/"));
    gulp.src(config.materializeSrc + "fonts/**/**.{eot,ttf,woff,woff2}").pipe(gulp.dest(config.assetBase + "fonts/"));
});

gulp.task('sass', function () {
    gulp.src([
        config.assetBase + "sass/**/**.scss",
        '!' + config.assetBase + "sass/_style.scss",
        '!' + config.assetBase + "sass/materialize.scss",
        '!' + config.assetBase + "sass/ghpages-materialize.scss"
    ])
            .pipe(plumber(plumberErrorHandler))
            .pipe(sass())
            .pipe(gulp.dest(config.assetBase + "css"))
            .pipe(livereload());
});

gulp.task('img', function () {
    gulp.src(config.assetBase + "src/img/*.{png,jpg,gif}")
            .pipe(imagemin({
                optimizationLevel: 10,
                progressive: true
            }))
            .pipe(gulp.dest(config.assetBase + "img"));
});

gulp.task('js', function () {
    gulp.src([
        config.jQuery,
        config.matchHeight,
        config.assetBase + "js/src/material/initial.js",
        config.assetBase + "js/src/material/jquery.easing.1.3.js",
        config.assetBase + "js/src/material/animation.js",
        config.assetBase + "js/src/material/velocity.min.js",
        config.assetBase + "js/src/material/hammer.min.js",
        config.assetBase + "js/src/material/jquery.hammer.js",
        config.assetBase + "js/src/material/global.js",
        config.assetBase + "js/src/material/collapsible.js",
        config.assetBase + "js/src/material/dropdown.js",
        config.assetBase + "js/src/material/modal.js",
        config.assetBase + "js/src/material/materialbox.js",
        config.assetBase + "js/src/material/parallax.js",
        config.assetBase + "js/src/material/tabs.js",
        config.assetBase + "js/src/material/tooltip.js",
        config.assetBase + "js/src/material/waves.js",
        config.assetBase + "js/src/material/toasts.js",
        config.assetBase + "js/src/material/sideNav.js",
        config.assetBase + "js/src/material/scrollspy.js",
        config.assetBase + "js/src/material/forms.js",
        config.assetBase + "js/src/material/slider.js",
        config.assetBase + "js/src/material/cards.js",
        config.assetBase + "js/src/material/chips.js",
        config.assetBase + "js/src/material/pushpin.js",
        config.assetBase + "js/src/material/buttons.js",
        config.assetBase + "js/src/material/transitions.js",
        config.assetBase + "js/src/material/scrollFire.js",
        config.assetBase + "js/src/material/date_picker/picker.js",
        config.assetBase + "js/src/material/date_picker/picker.date.js",
        config.assetBase + "js/src/material/character_counter.js",
        config.assetBase + "js/src/material/carousel.js",
        config.assetBase + "js/src/material/tapTarget.js"

    ])
            .pipe(concat('app.js'))
            .pipe(gulp.dest(config.assetBase + "js/"));
});
gulp.task('watch', function () {
    livereload.listen();
    gulp.watch(config.assetBase + "sass/**/**.scss", ['sass']);
    gulp.watch(config.assetBase + 'js/src/**/**.js', ['js']);
    gulp.watch(config.assetBase + 'img/src/*.{png,jpg,gif}', ['img']);
});

gulp.task('default', ['copySrc', 'sass', 'img', 'js', 'watch']);
//gulp.task('default', ['sass', 'img', 'js', 'watch']);
//gulp.task('default', ['sass', 'js', 'img', 'watch']);