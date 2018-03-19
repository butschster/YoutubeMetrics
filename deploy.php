<?php

namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'YouTubeMeter');

// Project repository
set('repository', 'git@bitbucket.org:butsch/youtube.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

// Shared files/dirs between deploys 
add('shared_files', []);
add('shared_dirs', []);

set('allow_anonymous_stats', false);

host('youtube-collector')
    ->configFile('~/.ssh/config')
    ->set('deploy_path', '/var/www');

// Tasks

task('build', function () {
    run('cd {{release_path}} && build');
});

desc('Execute queue:restart');
task('supervisor:queue:restart', function () {
    run('supervisorctl restart all');
});

desc('Execute php:reload');
task('php:reload', function () {
    run('systemctl reload php7.2-fpm.service');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.
before('deploy:symlink', 'artisan:migrate');
after('artisan:config:cache', 'artisan:route:cache');
after('deploy:writable', 'php:reload');
after('deploy:symlink', 'supervisor:queue:restart');
after('deploy:symlink', 'php:reload');

