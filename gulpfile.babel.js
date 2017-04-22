const fs = require('fs');

const gulp = require('gulp');
const sequence = require('run-sequence');
const shell = require('gulp-shell');

const config = require('./config.json');
const author = require('./author.json');

let tracking = require('./tracking.json');

const timer = {
    /**
     * Start the timer.
     *
     * @return {Object}
     */
    start() {
        tracking.start = Date.now();

        return timer;
    },

    /**
     * Stop the timer.
     *
     * @return {Object}
     */
    stop() {
        tracking.end = Date.now();

        let milliseconds = tracking.end - tracking.start;

        let seconds = parseInt(milliseconds / 1000);
        seconds = seconds < 9 ? `0${seconds}` : seconds;

        let minutes = parseInt(seconds / 60);
        minutes = minutes < 9 ? `0${minutes}` : minutes;

        tracking.duration = `${minutes} minutes, ${seconds} seconds`;

        return timer;
    },

    /**
     * Save the tracking data.
     *
     * @return {Void}
     */
    save() {
        fs.writeFile('./tracking.json', JSON.stringify(tracking, null, '    '), 'utf8');

        return timer;
    },
};

/**
 * Start the challenge.
 */
gulp.task('start', () => {
    sequence(
        'timer:start',
        'resume',
    );
});

/**
 * Start the challenge.
 */
gulp.task('resume', () => {
    return gulp.watch('src/**/*.php', ['submit']);
});

/**
 * Run the PHPUnit test suite.
 */
gulp.task('test', shell.task(['vendor/bin/phpunit']));

/**
 * Submit the challenge attempt.
 */
gulp.task('submit', ['test'], () => {
    sequence(
        'timer:stop',
        'submit:force',
        'exit',
    );
});

/**
 * Actually submit the challenge attempt.
 */
gulp.task('submit:force', shell.task([
    'git add src',
    'git add author.json',
    'git add tracking.json',
    `git commit -m "Challenge complete by '${author.name} <${author.email}>'!" --author "${author.name} <${author.email}>"`,
    'git push',
]));

/**
 * Start the task timer.
 */
gulp.task('timer:start', () => {
    timer.start().save();
});

/**
 * Stop the task timer.
 */
gulp.task('timer:stop', () => {
    timer.stop().save();
});

/**
 * Exit gulp.
 */
gulp.task('exit', () => {
    process.exit();
});

/**
 * Reset the challenge.
 */
gulp.task('reset', shell.task([
    `git checkout ${config.reset} src`,
    'git add src',
    `git checkout ${config.reset} author.json`,
    'git add author.json',
    `git checkout ${config.reset} tracking.json`,
    'git add tracking.json',
    'git commit -m "Challenge reset."',
    'git push',
]));
