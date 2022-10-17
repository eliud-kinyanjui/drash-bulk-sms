<?php

namespace Deployer;

require 'recipe/laravel.php';
// require 'contrib/npm.php';
require 'contrib/rsync.php';

set('application', 'Drash Bulk SMS');
set('repository', 'git@github.com:nwaweru/drash-bulk-sms.git');
set('ssh_multiplexing', true);

set('rsync_src', function () {
    return __DIR__;
});

add('rsync', [
    'exclude' => [
        '.git',
        '/vendor/',
        '/node_modules/',
        '.github',
        'deploy.php',
    ],
]);

host('prod')
    ->setHostname('drash.co.ke')
    ->set('remote_user', 'nwaweru')
    ->set('identity_file', '~/.ssh/id_rsa')
    ->set('branch', 'master')
    ->set('deploy_path', '/var/www/drash-bulk-sms');

after('deploy:failed', 'deploy:unlock');

desc('Start deploying the application...');

task('npm:build', function () {
    run('cd {{release_path}} && npm install && npm run build');
});

task('deploy', [
    'deploy:prepare',
    'rsync',
    'deploy:vendors',
    'deploy:shared',
    'npm:build',
    'artisan:storage:link',
    'artisan:view:cache',
    'artisan:config:clear',
    'artisan:migrate',
    'artisan:queue:restart',
    'deploy:publish',
]);

desc('End deploying the application.');
