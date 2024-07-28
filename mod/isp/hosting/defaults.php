<?
$PHP_ADMIN_VALUES = [
        [
                'name' => 'error_log',
                'label' => _PHP_ADMIN_VALUE_ENABLE_ERROR_LOG,
                'values' => [
                                [ 'value' => '',
                                  'txt' => _PHP_ADMIN_VALUE_ENABLE_ERROR_LOG_ON
                                ],
                                [ 'value' => '/dev/null',
                                  'txt' => _PHP_ADMIN_VALUE_ENABLE_ERROR_LOG_OFF
                                ]
                            ], 
		'default' => 'off',
                'help_tooltip' => _PHP_ADMIN_VALUE_ENABLE_ERROR_LOG_HELP_TOOLTIP
        ],
         [
                'name' => 'max_execution_time',
                'label' => _PHP_ADMIN_VALUE_MAX_EXECUTION_TIME,
                'values' => [
                                [ 'value' => '30',
                                  'txt' => _PHP_ADMIN_VALUE_MAX_EXECUTION_TIME_30
                                ],
                                [ 'value' => '180',
                                  'txt' => _PHP_ADMIN_VALUE_MAX_EXECUTION_TIME_180
                                ],
                                [ 'value' => '640',
                                  'txt' => _PHP_ADMIN_VALUE_MAX_EXECUTION_TIME_640
                                ],
                                [ 'value' => '1200',
                                  'txt' => _PHP_ADMIN_VALUE_MAX_EXECUTION_TIME_1200
                                ],
                                [ 'value' => '3600',
                                  'txt' => _PHP_ADMIN_VALUE_MAX_EXECUTION_TIME_3600
                                ],
                            ], 
		'default' => '180',
                'help_tooltip' => _PHP_ADMIN_VALUE_MAX_EXECUTION_TIME_HELP_TOOLTIP
        ],
         [
                'name' => 'max_memory_limit',
                'label' => _PHP_ADMIN_VALUE_MEMORY_LIMIT,
                'values' => [
                                [ 'value' => '128M',
                                  'txt' => _PHP_ADMIN_VALUE_MEMORY_LIMIT_128
                                ],
                                [ 'value' => '256M',
                                  'txt' => _PHP_ADMIN_VALUE_MEMORY_LIMIT_256
                                ],
                                [ 'value' => '384M',
                                  'txt' => _PHP_ADMIN_VALUE_MEMORY_LIMIT_384
                                ],
                            ], 
		'default' => '256M',
                'help_tooltip' => _PHP_ADMIN_VALUE_MEMORY_LIMIT_HELP_TOOLTIP
        ],
        [
                'name' => 'default_charset',
                'label' => _PHP_ADMIN_VALUE_DEFAULT_CHARSET,
                'values' => [
                                [ 'value' => 'UTF8',
                                  'txt' => _PHP_ADMIN_VALUE_DEFAULT_CHARSET_UTF8
                                ],
                                [ 'value' => 'UTF8MB4',
                                  'txt' => _PHP_ADMIN_VALUE_DEFAULT_CHARSET_UTF8MB4
                                ]
                            ], 
		'default' => 'UTF8',
                'help_tooltip' => _PHP_ADMIN_VALUE_DEFAULT_CHARSET_HELP_TOOLTIP
        ],
        [
                'name' => 'max_input_vars',
                'label' => _PHP_ADMIN_VALUE_MAX_INPUT_VARS,
                'values' => [
                                [ 'value' => '1000',
                                  'txt' => _PHP_ADMIN_VALUE_MAX_INPUT_VARS_1000
                                ],
                                [ 'value' => '2500',
                                  'txt' => _PHP_ADMIN_VALUE_MAX_INPUT_VARS_2500
                                ],
                                [ 'value' => '5000',
                                  'txt' => _PHP_ADMIN_VALUE_MAX_INPUT_VARS_5000
                                ],
                                [ 'value' => '10000',
                                  'txt' => _PHP_ADMIN_VALUE_MAX_INPUT_VARS_10000
                                ],
                            ], 
		'default' => '1000',
                'help_tooltip' => _PHP_ADMIN_VALUE_MAX_INPUT_VARS_HELP_TOOLTIP
        ],
        [
                'name' => 'session_cookie_lifetime',
                'label' => _PHP_ADMIN_VALUE_SESSION_COOKIE_LIFETIME,
                'values' => [
                                [ 'value' => '0',
                                  'txt' => _PHP_ADMIN_VALUE_SESSION_COOKIE_LIFETIME_0
                                ],
                                [ 'value' => '300',
                                  'txt' => _PHP_ADMIN_VALUE_SESSION_COOKIE_LIFETIME_300
                                ],
                                [ 'value' => '1200',
                                  'txt' => _PHP_ADMIN_VALUE_SESSION_COOKIE_LIFETIME_1200
                                ],
                                [ 'value' => '5000',
                                  'txt' => _PHP_ADMIN_VALUE_SESSION_COOKIE_LIFETIME_5000
                                ],
                                [ 'value' => '10000',
                                  'txt' => _PHP_ADMIN_VALUE_SESSION_COOKIE_LIFETIME_10000
                                ],
                            ], 
		'default' => '300',
                'help_tooltip' => _PHP_ADMIN_VALUE_SESSION_COOKIE_LIFETIME_HELP_TOOLTIP
        ],
        [
                'name' => 'post_max_size',
                'label' => _PHP_ADMIN_VALUE_POST_MAX_SIZE,
                'values' => [
                                [ 'value' => '128',
                                  'txt' => _PHP_ADMIN_VALUE_POST_MAX_SIZE_128
                                ],
                                [ 'value' => '256',
                                  'txt' => _PHP_ADMIN_VALUE_POST_MAX_SIZE_256
                                ],
                                [ 'value' => '512',
                                  'txt' => _PHP_ADMIN_VALUE_POST_MAX_SIZE_512
                                ],
                                [ 'value' => '1024',
                                  'txt' => _PHP_ADMIN_VALUE_POST_MAX_SIZE_1024
                                ],
                            ], 
		'default' => '256M',
                'help_tooltip' => _PHP_ADMIN_VALUE_POST_MAX_SIZE_HELP_TOOLTIP
        ],
        [
                'name' => 'upload_max_filesize',
                'label' => _PHP_ADMIN_VALUE_UPLOAD_MAX_FILESIZE,
                'values' => [
                                [ 'value' => '128M',
                                  'txt' => _PHP_ADMIN_VALUE_UPLOAD_MAX_FILESIZE_128
                                ],
                                [ 'value' => '256M',
                                  'txt' => _PHP_ADMIN_VALUE_UPLOAD_MAX_FILESIZE_256
                                ],
                                [ 'value' => '512',
                                  'txt' => _PHP_ADMIN_VALUE_UPLOAD_MAX_FILESIZE_512
                                ],
                                [ 'value' => '1024',
                                  'txt' => _PHP_ADMIN_VALUE_UPLOAD_MAX_FILESIZE_1024
                                ],
                            ], 
		'default' => '256M',
                'help_tooltip' => _PHP_ADMIN_VALUE_UPLOAD_MAX_FILESIZE_HELP_TOOLTIP
        ],
]
?>

