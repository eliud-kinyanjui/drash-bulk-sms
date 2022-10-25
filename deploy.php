<?php

namespace Deployer;

require 'recipe/laravel.php';
require 'recipe/deploy/cleanup.php';
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

desc('Cleanup old releases');

set('cleanup_use_sudo', false);
set('keep_releases', 3);

task('deploy:cleanup', function () {
    $releases = get('releases_list');
    $keep = get('keep_releases');
    $sudo = get('cleanup_use_sudo') ? 'sudo' : '';

    run('cd {{deploy_path}} && if [ -e release ]; then rm release; fi');

    if ($keep > 0) {
        foreach (array_slice($releases, $keep) as $release) {
            run("$sudo rm -rf {{deploy_path}}/releases/$release");
        }
    }
});

desc('End deploying the application.');
