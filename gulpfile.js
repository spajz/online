var gulp = require('gulp');
var watch = require('gulp-watch');
var clean = require('gulp-clean');

var paths = {
    scripts: [
        'app/modules/admin/assets/js/**/*'
    ],
    css: [
        'app/modules/admin/assets/css/**/*'
    ],
    images: [
        'app/modules/admin/assets/images/**/*'
    ],
    img: [
        'app/modules/admin/assets/img/**/*'
    ],
    fonts: [
        'app/modules/admin/assets/fonts/**/*'
    ],
    rte: [
        'app/modules/admin/assets/rte/**/*'
    ]
};

gulp.task('scripts', function () {
    watch({glob: paths.scripts}, function (files) {
        return files.pipe(gulp.dest('public/packages/module/admin/assets/js/'));
    });
});

gulp.task('css', function () {
    watch({glob: paths.css}, function (files) {
        return files.pipe(gulp.dest('public/packages/module/admin/assets/css/'));
    });
});

gulp.task('fonts', function () {
    watch({glob: paths.fonts}, function (files) {
        return files.pipe(gulp.dest('public/packages/module/admin/assets/fonts/'));
    });
});

gulp.task('rte', function () {
    watch({glob: paths.rte}, function (files) {
        return files.pipe(gulp.dest('public/packages/module/admin/assets/rte/'));
    });
});

//Copy all static images
gulp.task('img', function () {
    watch({glob: paths.img}, function (files) {
        return files.pipe(gulp.dest('public/packages/module/admin/assets/img/'));
    });
});

gulp.task('images', function () {
    watch({glob: paths.images}, function (files) {
        return files.pipe(gulp.dest('public/packages/module/admin/assets/images/'));
    });
});

// Rerun the task when a file changes
//gulp.task('watch', function () {
//    gulp.watch(paths.scripts, ['scripts']);
//    gulp.watch(paths.css, ['css']);
//    gulp.watch(paths.images, ['images']);
//    gulp.watch(paths.fonts, ['fonts']);
//});

gulp.task('cleanall', function () {
    return gulp.src('public/packages/module/admin/assets', {read: false})
        .pipe(clean());
});

// The default task (called when you run `gulp` from cli)
gulp.task('default', ['rte', 'scripts', 'css', 'fonts', 'images', 'img']);

////////////////////////////////////////////////
// Front

var module = 'front';

var pathsFront = {
    scripts: [
        'app/modules/' + module + '/assets/js/**/*'
    ],
    css: [
        'app/modules/' + module + '/assets/css/**/*'
    ],
    images: [
        'app/modules/' + module + '/assets/images/**/*'
    ],
    img: [
        'app/modules/' + module + '/assets/img/**/*'
    ],
    fonts: [
        'app/modules/' + module + '/assets/fonts/**/*'
    ]
};

gulp.task('scriptsFront', function () {
    watch({glob: pathsFront.scripts}, function (files) {
        return files.pipe(gulp.dest('public/packages/module/' + module + '/assets/js/'));
    });
});

gulp.task('cssFront', function () {
    watch({glob: pathsFront.css}, function (files) {
        return files.pipe(gulp.dest('public/packages/module/' + module + '/assets/css/'));
    });
});

gulp.task('fontsFront', function () {
    watch({glob: pathsFront.fonts}, function (files) {
        return files.pipe(gulp.dest('public/packages/module/' + module + '/assets/fonts/'));
    });
});

//Copy all static images
gulp.task('imgFront', function () {
    watch({glob: pathsFront.img}, function (files) {
        return files.pipe(gulp.dest('public/packages/module/' + module + '/assets/img/'));
    });
});

gulp.task('imagesFront', function () {
    watch({glob: pathsFront.images}, function (files) {
        return files.pipe(gulp.dest('public/packages/module/' + module + '/assets/images/'));
    });
});

gulp.task('cleanallFront', function () {
    return gulp.src('public/packages/module/' + module + '/assets', {read: false})
        .pipe(clean());
});

gulp.task('front', ['scriptsFront', 'cssFront', 'fontsFront', 'imgFront']);
gulp.task('holiday', ['cleanallFront', 'scriptsFront', 'cssFront', 'fontsFront', 'imgFront']);