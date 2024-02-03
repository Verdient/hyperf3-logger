<?php

declare(strict_types=1);

namespace Verdient\Hyperf3\Logger;

use Hyperf\Contract\StdoutLoggerInterface;
use Psr\Log\LogLevel;
use Stringable;
use Verdient\cli\Console;

use function sprintf;
use function str_replace;

/**
 * 打印记录器
 * @author Verdient。
 */
class StdoutLogger implements StdoutLoggerInterface
{
    /**
     * @inheritdoc
     * @author Verdient。
     */
    public function emergency(string|Stringable $message, array $context = []): void
    {
        $this->log(LogLevel::EMERGENCY, $message, $context);
    }

    /**
     * @inheritdoc
     * @author Verdient。
     */
    public function alert(string|Stringable $message, array $context = []): void
    {
        $this->log(LogLevel::ALERT, $message, $context);
    }

    /**
     * @inheritdoc
     * @author Verdient。
     */
    public function critical(string|Stringable $message, array $context = []): void
    {
        $this->log(LogLevel::CRITICAL, $message, $context);
    }

    /**
     * @inheritdoc
     * @author Verdient。
     */
    public function error(string|Stringable $message, array $context = []): void
    {
        $this->log(LogLevel::ERROR, $message, $context);
    }

    /**
     * @inheritdoc
     * @author Verdient。
     */
    public function warning(string|Stringable $message, array $context = []): void
    {
        $this->log(LogLevel::WARNING, $message, $context);
    }

    /**
     * @inheritdoc
     * @author Verdient。
     */
    public function notice(string|Stringable $message, array $context = []): void
    {
        $this->log(LogLevel::NOTICE, $message, $context);
    }

    /**
     * @inheritdoc
     * @author Verdient。
     */
    public function info(string|Stringable $message, array $context = []): void
    {
        $this->log(LogLevel::INFO, $message, $context);
    }

    /**
     * @inheritdoc
     * @author Verdient。
     */
    public function debug(string|Stringable $message, array $context = []): void
    {
        $this->log(LogLevel::DEBUG, $message, $context);
    }

    /**
     * @inheritdoc
     * @author Verdient。
     */
    public function log($level, string|Stringable $message, array $context = []): void
    {
        $keys = array_keys($context);

        foreach ($context as $key => $value) {
            if (is_object($value) && !$value instanceof Stringable) {
                $context[$key] = '<OBJECT> ' . $value::class;
            }
        }

        $search = array_map(function ($key) {
            return sprintf('{%s}', $key);
        }, $keys);

        $message = str_replace($search, $context, (string) $message);

        $formats = match ($level) {
            LogLevel::EMERGENCY, LogLevel::ALERT, LogLevel::CRITICAL => [Console::BG_RED],
            LogLevel::ERROR => [Console::FG_RED],
            LogLevel::WARNING, LogLevel::NOTICE => [Console::FG_YELLOW],
            default => [Console::FG_GREEN],
        };

        Console::output(Console::colour('[' . strtoupper($level) . ']', ...$formats) . ' ' . $message);
    }
}
