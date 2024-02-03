<?php

namespace Verdient\Hyperf3\Logger;

use Hyperf\Context\ApplicationContext;
use Hyperf\Logger\LoggerFactory;
use Psr\Log\LoggerInterface;
use function Hyperf\Config\config;

/**
 * 包含记录器
 * @author Verdient。
 */
trait HasLogger
{
    /**
     * 记录器
     * @author Verdient。
     */
    protected ?LoggerInterface $logger = null;

    /**
     * 获取记录器名称
     * @return string
     * @author Verdient。
     */
    protected function getLoggerName()
    {
        return static::class;
    }

    /**
     * 获取记录器分组
     * @return string
     * @author Verdient。
     */
    protected function getLoggerGroup()
    {
        $loggerConfig = config('logger');
        if (isset($loggerConfig[static::class])) {
            return static::class;
        }
        return 'default';
    }

    /**
     * 获取日志组件
     * @return LoggerInterface
     * @author Verdient。
     */
    public function logger(): LoggerInterface
    {
        if (!$this->logger) {
            if (ApplicationContext::hasContainer()) {
                /** @var LoggerFactory|null */
                $loggerFactory = ApplicationContext::getContainer()->get(LoggerFactory::class);
                if ($loggerFactory) {
                    $this->logger = $loggerFactory->get($this->getLoggerName(), $this->getLoggerGroup());
                }
            }
            if (!$this->logger) {
                $this->logger = new Logger(new StdoutLogger);
            }
        }
        return $this->logger;
    }

    /**
     * 设置记录器
     * @param LoggerInterface 记录器
     * @return static
     * @author Verdient。
     */
    public function setLogger(LoggerInterface $logger): static
    {
        $this->logger = $logger;
        return $this;
    }
}
