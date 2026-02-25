<?php

declare(strict_types=1);

namespace Verdient\Hyperf3\Logger;

use Hyperf\Contract\StdoutLoggerInterface;
use Verdient\Logger\StdoutLogger as LoggerStdoutLogger;

/**
 * 打印记录器
 *
 * @author Verdient。
 */
class StdoutLogger extends LoggerStdoutLogger implements StdoutLoggerInterface {}
