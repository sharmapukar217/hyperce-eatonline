<?php
$config['form']['fields'] = [
    'id' => [
        'type' => 'hidden',
    ],
    'priority' => [
        'type' => 'hidden',
    ],
    'location_id' => [
        'type' => 'hidden',
    ],
    'title' => [
        'span' => 'left',
        'type' => 'text',
        'label' => 'hyperce.eatonline::default.headers.label_title',
    ],
    'href' => [
        'type' => 'text',
        'span' => 'full',
        'label' => 'hyperce.eatonline::default.headers.label_href',
    ],
];

return $config;
