@servers(['local' => '127.0.0.1', 'stg' => ['www@35.75.10.253']])

@setup
    $repository = 'ssh://git@git.amaisoft.com:2224/tungpd/riparo-work.git';
    $defaultEnv = 'local';
    $env = isset($env) ? $env : $defaultEnv;
    $configs = [
        'prod' => [
            'on' => 'prod',
            'app_dir' => 'prod',
            'branch' => 'master',
        ],
        'stg' => [
            'on' => 'stg',
            'app_dir' => '/www/riparo-work',
            'branch' => 'develop',
        ],
        'local' => [
            'on' => 'local',
            'app_dir' => '/home/www/riparo_deploy',
            'branch' => 'develop',
        ],
    ];

    $symlinks = [
        'storage/app/public',
        'storage/framework',
        'storage/logs',
    ];

    $config = $configs[$env] ?? $configs[$defaultEnv];
    $now = new DateTime;
    $appDir = $config['app_dir'];
    $branch = $config['branch'];
    $on = $config['on'];
    $shareDir = $appDir . '/share';
    $releasesDir = $appDir . '/releases';
    $release = date('YmdHis');
    $newReleaseDir = $env == 'stg' ? $appDir : $releasesDir .'/'. $release;
@endsetup

@story('deploy', ['on' => $on])
    @if ($env == 'stg')
        fetch_branch
        install_composer_dev
        migrate
        build_script
    @else
        clone_repository
        link_share
        install_composer_prod
        cache_config
        migrate
        build_script
        update_symlinks
    @endif
@endstory

@task('fetch_branch')
    echo "Fetch branch"
    cd "{{ $appDir }}"
    git fetch origin {{ $branch }}
    git reset --hard origin/{{ $branch }}
@endtask

@task('install_composer_dev')
    echo "Starting deployment"
    cd "{{ $newReleaseDir }}"
    composer install --no-interaction
@endtask

@task('migrate')
    echo "Starting migrate"
    cd "{{ $newReleaseDir }}"
    php artisan migrate --force
@endtask

@task('cache_config')
    echo "Cache config"
    cd "{{ $newReleaseDir }}"
    php artisan config:cache
@endtask

@task('build_script')
    echo "Build script"
    cd "{{ $newReleaseDir }}"
    yarn install --non-interactive
    yarn build
@endtask

@task('clone_repository')
    echo "Cloning repository"
    @if (!file_exists($releasesDir))
        mkdir -p "{{ $releasesDir }}"
    @endif
    git clone -b "{{ $branch }}" "{{ $repository }}" "{{ $newReleaseDir }}"
@endtask

@task('link_share')
    echo "Link share"
    @foreach ($symlinks as $symlink)
        @if (!file_exists($shareDir . '/' . $symlink))
            mkdir -p "{{ $shareDir . '/' . $symlink }}"
        @endif

        rm -rf "{{ $newReleaseDir . '/' . $symlink }}"
        ln -nfs "{{ $shareDir . '/' . $symlink }}" "{{ $newReleaseDir . '/' . $symlink }}"
    @endforeach

    echo "All symlinks share have been set"

    @if (!file_exists($shareDir . '/.env'))
        cp "{{ $newReleaseDir . '/.env.example' }}" "{{ $shareDir . '/.env' }}"
    @endif

    ln -nfs "{{ $shareDir . '/.env' }}" "{{ $newReleaseDir . '/.env' }}"
@endtask

@task('install_composer_prod')
    echo "Starting deployment"
    cd "{{ $newReleaseDir }}"
    composer install --no-interaction --no-dev
@endtask

@task('update_symlinks')
    echo "Linking current release"
    rm -rf "{{ $appDir }}/current"
    ln -nfs "{{ $newReleaseDir }}" "{{ $appDir }}/current"
@endtask

@finished
    echo 'Finished';
@endfinished

@error
   echo $task;
   exit;
@enderror
