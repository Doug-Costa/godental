<?php
$content = file_get_contents('/var/www/dentalpress/app/Http/Controllers/PagesController.php');
$methods = file_get_contents('/root/update_methods.txt');
$lines = explode("\n", $content);
// We want to replace lines 410 to 635 (indices 409 to 634)
$newLines = array_merge(
    array_slice($lines, 0, 409),
    [$methods],
    array_slice($lines, 635)
);
file_put_contents('/var/www/dentalpress/app/Http/Controllers/PagesController.php', implode("\n", $newLines));
echo "Merge successful\n";
