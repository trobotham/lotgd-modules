var
	gulp = require('gulp-help')(require('gulp')),

	//-- Tasks
	build = require('./gulp/tasks/build'),
	del = require('./gulp/tasks/delete')

;

require('./gulp/tasks/collections/copy')(gulp);

/**
 * Task
 */
gulp.task('default', false, [
  'build'
]);

gulp.task('build' , 'Builds all files from source', build);

gulp.task('delete' , 'Delete dist folder', del);
