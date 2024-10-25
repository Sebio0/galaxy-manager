<?php
return [
    'host' => env('GIT_SSH_HOST','localhost'),
    'port' => env('GIT_SSH_PORT', 22),
    'user' => env('GIT_SSH_USER','root'),
    'base_dir' => env('GIT_SSH_BASE_DIR',''),
    'repository' => env('GIT_REPOSITORY',''),
    'private_key' => file_get_contents(base_path('keys/private.key')),
    'gitlab' => [
        'url' => env('GITLAB_API_URL', ''),
        'project'=> env('GITLAB_PROJECT_ID', ''),
        'token' => env('GITLAB_API_TOKEN', '')
    ],
];
