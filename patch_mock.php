<?php
$filePath = '/var/www/dentalpress/app/Http/Controllers/PagesController.php';
$content = file_get_contents($filePath);

// Update hardcoded mock
$content = str_replace(
    "'suggested_plan' => '',\n                'is_db' => false,",
    "'suggested_plan' => '',\n                'next_steps' => '',\n                'is_db' => false,",
    $content
);

// Update file-based mock
$content = str_replace(
    "'suggested_plan' => '',\n                 'is_db' => false,",
    "'suggested_plan' => '',\n                 'next_steps' => '',\n                 'is_db' => false,",
    $content
);

file_put_contents($filePath, $content);
echo "PagesController updated successfully.\n";
