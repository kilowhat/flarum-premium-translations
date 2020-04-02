<?php

return [
    'github_token' => env('GITHUB_TOKEN'),

    'repos' => [
        'wordpress' => [
            'name' => 'Wordpress integration',
            'repo' => 'clarkwinkelmann/flarum-ext-wordpress',
            'locales' => ['en'],
        ],
        'formulaire' => [
            'name' => 'Formulaire',
            'repo' => 'clarkwinkelmann/flarum-ext-formulaire',
            'locales' => ['en', 'fr'],
        ],
    ],
];
