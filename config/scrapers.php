<?php

return [
    '*.canva.site' => [
        'pattern'  => '//span[contains(@class, "OYPEnA")]',
        'fields' => [
            // 'name' => ['xpath' => '//span[contains(@class, "OYPEnA")][1]'],
            // 'job_position' => ['xpath' => '//span[contains(@class, "OYPEnA")][2]'],
            // 'summary_experience' => ['xpath' => '//span[contains(@class, "OYPEnA")][4]'],
            'name' => ['position' => 0],
            'job_position' => ['position' => 1],
            'summary_experience' => ['position' => 3],
        ]
    ],

    'dellinzhang.com' => [
        'fields' => [
            'title' => ['xpath' => '//h1'],
            'projects' => ['xpath' => '//div[contains(@class, "project") or contains(@class, "video")]', 'multiple' => true],
        ]
    ],
];
