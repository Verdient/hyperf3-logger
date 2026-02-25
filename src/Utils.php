<?php

declare(strict_types=1);

namespace Verdient\Hyperf3\Logger;

use Hyperf\Contract\ConfigInterface;
use Hyperf\Logger\LoggerFactory;
use Psr\Log\LoggerInterface;
use Verdient\Hyperf3\Di\Container;

/**
 * 工具
 *
 * @author Verdient。
 */
class Utils
{
    /**
     * 创建默认的记录器
     *
     * @param array<int|string,string> $groups 组名集合
     *
     * @author Verdient。
     */
    public static function createLogger(array $groups): LoggerInterface
    {
        if (!$loggerFactory = Container::getOrNull(LoggerFactory::class)) {
            return new StdoutLogger();
        }

        if (!$config = Container::getOrNull(ConfigInterface::class)) {
            return new StdoutLogger();
        }

        if (!$loggerConfig = $config->get('logger')) {
            return new StdoutLogger();
        }

        foreach ($groups as $name => $group) {
            if (isset($loggerConfig[$group])) {
                if (ctype_digit((string) $name)) {
                    $name = $group;
                }
                return $loggerFactory->get($name, $group);
            }

            try {
                if ($logger = Container::getOrNull($group)) {
                    if ($logger instanceof LoggerInterface) {
                        return $logger;
                    }
                }
            } catch (\Throwable) {
            }
        }

        return new StdoutLogger();
    }
}
