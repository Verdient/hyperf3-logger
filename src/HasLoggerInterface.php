<?php

declare(strict_types=1);

namespace Verdient\Hyperf3\Logger;

use Psr\Log\LoggerInterface;

/**
 * 包含日志接口
 * @author Verdient。
 */
interface HasLoggerInterface
{
    /**
     * 设置记录器
     * @param LoggerInterface 记录器
     * @return static
     * @author Verdient。
     */
    public function setLogger(LoggerInterface $logger): static;

    /**
     * 获取日志组件
     * @return LoggerInterface
     * @author Verdient。
     */
    public function logger(): LoggerInterface;
}
