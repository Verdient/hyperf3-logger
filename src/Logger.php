<?php

declare(strict_types=1);

namespace Verdient\Hyperf3\Logger;

use Hyperf\ExceptionHandler\Formatter\FormatterInterface;
use Override;
use Stringable;
use Throwable;
use Verdient\Hyperf3\Di\Container;
use Verdient\Logger\Logger as LoggerLogger;

/**
 * 记录器
 *
 * @author Verdient。
 */
class Logger extends LoggerLogger
{
    /**
     * @author Verdient。
     */
    #[Override]
    protected function formatMessage(string|Stringable $message): string
    {
        if ($message instanceof Throwable) {
            if ($formatter = Container::getOrNull(FormatterInterface::class)) {
                $message = $formatter->format($message);
            }
        }
        return parent::formatMessage($message);
    }
}
