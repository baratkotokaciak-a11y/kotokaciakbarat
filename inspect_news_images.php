<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
use App\Models\News;
foreach (News::all() as $news) {
    echo $news->id . " => " . ($news->image ?? 'null') . PHP_EOL;
}
?>
