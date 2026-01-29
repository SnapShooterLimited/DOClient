<?php

declare(strict_types=1);

/*
 * This file is part of the DigitalOcean API library.
 *
 * (c) Antoine Kirk <contact@sbin.dk>
 * (c) Graham Campbell <hello@gjcampbell.co.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DigitalOceanV2\Entity;

/**
 * @author SnapShooter <support@snapshooter.com>
 */
final class VpcNatGateway extends AbstractEntity
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $region;

    /**
     * @var int
     */
    public $size;

    /**
     * @var array
     */
    public $vpcs = [];

    /**
     * @var array
     */
    public $egresses = [];

    /**
     * @var int|null
     */
    public $udpTimeoutSeconds;

    /**
     * @var int|null
     */
    public $icmpTimeoutSeconds;

    /**
     * @var int|null
     */
    public $tcpTimeoutSeconds;

    /**
     * @var string
     */
    public $state;

    /**
     * @var string
     */
    public $createdAt;

    /**
     * @var string
     */
    public $updatedAt;

    /**
     * @param string $createdAt
     *
     * @return void
     */
    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = static::convertToIso8601($createdAt);
    }

    /**
     * @param string $updatedAt
     *
     * @return void
     */
    public function setUpdatedAt(string $updatedAt): void
    {
        $this->updatedAt = static::convertToIso8601($updatedAt);
    }

    /**
     * Get the public gateway IP from egresses.
     *
     * @return string|null
     */
    public function getPublicGatewayIp(): ?string
    {
        if (empty($this->egresses)) {
            return null;
        }

        return $this->egresses[0]['public_gateway_ip'] ?? null;
    }
}
