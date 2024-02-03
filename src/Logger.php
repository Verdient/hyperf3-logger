<?php

declare(strict_types=1);

namespace Verdient\Hyperf3\Logger;

use Hyperf\Context\ApplicationContext;
use Hyperf\ExceptionHandler\Formatter\FormatterInterface;
use Psr\Log\LoggerInterface;
use Stringable;
use Throwable;

/**
 * 记录器
 * @author Verdient。
 */
class Logger implements LoggerInterface
{
    /**
     * @var LoggerInterface 记录器
     * @author Verdient。
     */
    protected $logger;

    /**
     * @var string 前缀
     * @author Verdient。
     */
    protected $prefix;

    /**
     * @param LoggerInterface $logger 记录器
     * @param string|null $prefix 前缀
     * @author Verdient。
     */
    public function __construct(LoggerInterface $logger, string|null $prefix = null)
    {
        $this->logger = $logger;
        $this->prefix = (string) $prefix;
    }

    /**
     * 设置前缀
     * @param string $prefix 前缀
     * @return static
     * @author Verdient。
     */
    public function setPrefix(string $prefix)
    {
        $this->prefix = $prefix;
        return $this;
    }

    /**
     * 获取日志组件
     * @return LoggerInterface
     * @author Verdient。
     */
    public function getLogger(): LoggerInterface
    {
        return $this->logger;
    }

    /**
     * 格式化消息
     * @param string|Stringable $message 消息
     * @return string
     * @author Verdient。
     */
    public function formatMessage(string|Stringable $message)
    {
        if ($message instanceof Throwable) {
            if (ApplicationContext::hasContainer()) {
                if ($formatter = ApplicationContext::getContainer()->get(FormatterInterface::class)) {
                    $message = $formatter->format($message);
                }
            }
            if (!is_string($message)) {
                $message = (string) $message;
            }
        }
        if (!empty($this->prefix)) {
            return trim($this->prefix) . ' ' . $message;
        }
        return $message;
    }

    /**
     * @inheritdoc
     * @author Verdient。
     */
    public function emergency(string|Stringable $message, array $context = []): void
    {
        $this->logger->emergency($this->formatMessage($message), $context);
    }

    /**
     * @inheritdoc
     * @author Verdient。
     */
    public function alert(string|Stringable $message, array $context = []): void
    {
        $this->logger->alert($this->formatMessage($message), $context);
    }

    /**
     * @inheritdoc
     * @author Verdient。
     */
    public function critical(string|Stringable $message, array $context = []): void
    {
        $this->logger->critical($this->formatMessage($message), $context);
    }

    /**
     * @inheritdoc
     * @author Verdient。
     */
    public function error(string|Stringable $message, array $context = []): void
    {
        $this->logger->error($this->formatMessage($message), $context);
    }

    /**
     * @inheritdoc
     * @author Verdient。
     */
    public function warning(string|Stringable $message, array $context = []): void
    {
        $this->logger->warning($this->formatMessage($message), $context);
    }

    /**
     * @inheritdoc
     * @author Verdient。
     */
    public function notice(string|Stringable $message, array $context = []): void
    {
        $this->logger->notice($this->formatMessage($message), $context);
    }

    /**
     * @inheritdoc
     * @author Verdient。
     */
    public function info(string|Stringable $message, array $context = []): void
    {
        $this->logger->info($this->formatMessage($message), $context);
    }

    /**
     * @inheritdoc
     * @author Verdient。
     */
    public function debug(string|Stringable $message, array $context = []): void
    {
        $this->logger->debug($this->formatMessage($message), $context);
    }

    /**
     * @inheritdoc
     * @author Verdient。
     */
    public function log($level, string|Stringable $message, array $context = []): void
    {
        $this->logger->log($level, $this->formatMessage($message), $context);
    }
}
