<?php

namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'BotsMeter');

// Project repository
set('repository', 'git@bitbucket.org:butsch/youtube.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

// Shared files/dirs between deploys 
add('shared_files', []);
add('shared_dirs', []);

set('allow_anonymous_stats', false);

host('botsmeter', 'botsmeter-db')
    ->port(60022)
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

desc('Clear opcache');
task('opcache:clear', function () {
    run('{{bin/php}} {{release_path}}/artisan opcache:clear');
});


desc('Execute php:reload');
task('php:reload', function () {
    run('systemctl reload php7.2-fpm.service');
})->onHosts('botsmeter');

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.
before('deploy:symlink', 'artisan:migrate');
after('artisan:config:cache', 'artisan:route:cache');

after('deploy:writable', 'php:reload');
after('deploy:writable', 'opcache:clear');

after('deploy:symlink', 'supervisor:queue:restart');
after('deploy:symlink', 'opcache:clear');

after('deploy:symlink', 'php:reload');

