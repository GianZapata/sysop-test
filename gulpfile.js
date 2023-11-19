const { src, dest, watch, parallel } = require('gulp');

// CSS dependencies
const sass = require('gulp-sass')(require('sass'));
const plumber = require('gulp-plumber'); // Prevents stream crashing
const autoprefixer = require('autoprefixer'); // Adds vendor prefixes
const cssnano = require('cssnano'); // Minifies CSS
const postcss = require('gulp-postcss'); // Tool for transforming CSS with JS
const sourcemaps = require('gulp-sourcemaps'); // Source map support

// Image optimization dependencies
const cache = require('gulp-cache'); // Caching for faster re-run
const imagemin = require('gulp-imagemin'); // Image minification
const webp = require('gulp-webp'); // Converts images to WebP format
const avif = require('gulp-avif'); // Converts images to AVIF format

// JavaScript dependencies
const terser = require('gulp-terser-js'); // Minifies JavaScript
const concat = require('gulp-concat'); // Concatenates files
const rename = require('gulp-rename'); // Renames files

// Webpack for bundling JavaScript modules
const webpack = require('webpack-stream');

// File paths
const paths = {
    scss: 'src/scss/**/*.scss',
    js: 'src/js/**/*.js',
    images: 'src/img/**/*'
};

// CSS task
function css() {
    return src(paths.scss)
        .pipe(sourcemaps.init())
        .pipe(sass({outputStyle: 'expanded'}).on('error', sass.logError))
        .pipe(postcss([autoprefixer()]))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('public/build/css'));
}

// JavaScript task
function javascript() {
    return src(paths.js)
        .pipe(webpack({
            module: {
                rules: [
                    { test: /\.css$/i, use: ['style-loader', 'css-loader'] }
                ]
            },
            mode: 'production',
            watch: true, // Set to false in production
            entry: './src/js/app.js'
        }))
        .pipe(sourcemaps.init())
        .pipe(terser())
        .pipe(sourcemaps.write('.'))
        .pipe(rename({ suffix: '.min' }))
        .pipe(dest('./public/build/js'));
}

// Image optimization task
function images() {
    return src(paths.images)
        .pipe(cache(imagemin({ optimizationLevel: 3 })))
        .pipe(dest('public/build/img'));
}

// WebP conversion task
function versionWebp(done) {
    src('src/img/**/*.{png,jpg}')
        .pipe(webp({ quality: 50 }))
        .pipe(dest('public/build/img'));
    done();
}

// AVIF conversion task
function versionAvif(done) {
    src('src/img/**/*.{png,jpg}')
        .pipe(avif({ quality: 50 }))
        .pipe(dest('public/build/img'));
    done();
}

// Development task
function dev(done) {
    watch(paths.scss, css);
    watch(paths.js, javascript);
    watch(paths.images, images);
    watch(paths.images, versionWebp);
    watch(paths.images, versionAvif);
    done();
}

// Export tasks
exports.css = css;
exports.js = javascript;
exports.images = images;
exports.versionWebp = versionWebp;
exports.versionAvif = versionAvif;
exports.dev = parallel(css, images, versionWebp, versionAvif, javascript, dev);
