<?php

function renderHTMLMenu($menu) {
    $html = '<ul>';
    
    foreach ($menu['lnk'] as $item) {
        if ( $item['lnk'] ) {
            $html .= '<li><a href="' . htmlspecialchars($item['cmd']) . '" target="_blank">' . htmlspecialchars($item['lbl']) . '</a>';
            $html .= renderHTMLMenu($item);
            $html .= '</li>';
        } else {
            $html .= '<li><a href="' . htmlspecialchars($item['cmd']) . '" target="_blank">' . htmlspecialchars($item['lbl']) . '</a></li>';
        }
    }
    
    return $html .= '</ul>';
}

// Example data
$exampleMenu = [
    'cmd' => '#',
    'lnk' => [
        [
            'cmd' => 'http://google.com',
            'lbl' => 'Google',
            'lnk' => [
                [
                    'cmd' => 'http://mail.google.com',
                    'lbl' => 'G-mail',
                    'lnk' => []
                ],
                [
                    'cmd' => 'http://maps.google.com',
                    'lbl' => 'Maps',
                    'lnk' => []
                ],
                [
                    'cmd' => 'http://docs.google.com',
                    'lbl' => 'Docs',
                    'lnk' => []
                ]
            ],
        ],
        [
            'cmd' => 'http://facebook.com',
            'lbl' => 'Facebook',
            'lnk' => []
        ],
        [
            'cmd' => 'http://twitter.com',
            'lbl' => 'Twitter',
            'lnk' => [
                [
                    'cmd' => 'http://twitter.com/home',
                    'lbl' => 'Home',
                    'lnk' => []
                ],
                [
                    'cmd' => 'http://twitter.com/notifications',
                    'lbl' => 'Notifications',
                    'lnk' => []
                ]
            ]
        ]
    ]
];

echo renderHTMLMenu($exampleMenu);
