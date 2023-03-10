<?php

/*
 * This file is part of the Predis package.
 *
 * (c) Daniele Alessandri <suppakilla@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Predis\Command\Redis;

use Predis\Command\Command as RedisCommand;

/**
 * @link http://redis.io/commands/zpopmin
 *
 * @author Daniele Alessandri <suppakilla@gmail.com>
 */
class ZPOPMIN extends RedisCommand
{
    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return 'ZPOPMIN';
    }

    /**
     * {@inheritdoc}
     */
    public function parseResponse($data)
    {
        $result = array();

        for ($i = 0; $i < count($data); ++$i) {
            $result[$data[$i]] = $data[++$i];
        }

        return $result;
    }
}
