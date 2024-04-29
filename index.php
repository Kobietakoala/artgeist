<?php declare(strict_types=1);
namespace App;

require_once 'config/global_const.php'; //constraints
require_once 'vendor/autoload.php';

use App\Decorator\UnixDecorator;
use App\Model\File;
use App\Proxy\FileProxy;
use App\Service\Factory\FileReadStrategyFactory;

$file = new File(SAMPLE_FILE_NAME);
$fileReader = new UnixDecorator(new FileReadStrategyFactory());
$proxy = new FileProxy($fileReader);

echo $proxy->read($file);