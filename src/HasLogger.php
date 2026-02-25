<?php

namespace Verdient\Hyperf3\Logger;

use Psr\Log\LoggerInterface;
use Verdient\Logger\HasLogger as LoggerHasLogger;

/**
 * 包含记录器
 *
 * @author Verdient。
 */
trait HasLogger
{
    use LoggerHasLogger;

    /**
     * 创建默认的记录器
     *
     * @author Verdient。
     */
    protected function createDefaultLogger(): LoggerInterface
    {
        return Utils::createLogger($this->groupsForCreateDefaultLogger());
    }

    /**
     * 创建默认的记录器的组名集合
     *
     * @return array<int|string,string>
     * @author Verdient。
     */
    protected function groupsForCreateDefaultLogger(): array
    {
        return [];
    }
}
