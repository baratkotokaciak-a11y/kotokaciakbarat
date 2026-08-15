<?php
require __DIR__.'/vendor/autoload.php';
use App\Models\News;
foreach (News::all() as $news) {
    echo $news->id . " " . ($news->image ?? 'null') . PHP_EOL;
}
?>
