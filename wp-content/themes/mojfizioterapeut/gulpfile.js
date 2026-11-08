// dependencies
const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const concat = require('gulp-concat');
const uglify = require('gulp-uglify');
const postcss = require('gulp-postcss');
const autoprefixer = require('autoprefixer');
const cssnano = require('cssnano');
const sortMediaQueries = require('postcss-sort-media-queries');

// config
const config = {
    resources: './resources/',
    destination: './assets/'
}

// images
function images() {
    return gulp
        .src(config.resources + 'images/**/*', { allowEmpty: true })
        .pipe(gulp.dest(config.destination + 'images'));
}

// css
function css() {
    return gulp
        .src(config.resources + 'sass/**/*.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(postcss([
            sortMediaQueries(),
            autoprefixer(),
            cssnano()
        ]))
        .pipe(gulp.dest(config.destination + 'css'))
}

// javascript
function scripts() {
    return gulp
		.src([config.resources + 'js/vendor/*.js', config.resources + 'js/*.js'])
        .pipe(concat('scripts.js'))
        .pipe(uglify())
        .pipe(gulp.dest(config.destination + 'js'));
}

// fonts
function fonts() {
    return gulp
		.src(config.resources + 'fonts/**/*')
        .pipe(gulp.dest(config.destination + 'fonts'))
}

// watch
function watch() {
    gulp.watch('resources/sass/**/*.scss', css);
    gulp.watch('resources/js/**/*.js', scripts);
    gulp.watch('resources/images/**/*', images);
    gulp.watch('resources/fonts/**/*', fonts);
}

const build = gulp.parallel(css, images, fonts, scripts);

// export tasks
exports.images = images;
exports.css = css;
exports.scripts = scripts;
exports.build = build;
exports.watch = watch;
exports.default = build;