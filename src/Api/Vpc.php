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

namespace DigitalOceanV2\Api;

use DigitalOceanV2\Entity\Vpc as VpcEntity;
use DigitalOceanV2\Exception\ExceptionInterface;

/**
 * @author SnapShooter <support@snapshooter.com>
 */
class Vpc extends AbstractApi
{
    /**
     * Get all VPCs.
     *
     * @throws ExceptionInterface
     *
     * @return VpcEntity[]
     */
    public function getAll(): array
    {
        $vpcs = $this->get('vpcs');

        return \array_map(function ($vpc) {
            return new VpcEntity($vpc);
        }, $vpcs->vpcs ?? []);
    }

    /**
     * Get a VPC by ID.
     *
     * @param string $id
     *
     * @throws ExceptionInterface
     *
     * @return VpcEntity
     */
    public function getById(string $id): VpcEntity
    {
        $vpc = $this->get(\sprintf('vpcs/%s', $id));

        return new VpcEntity($vpc->vpc);
    }

    /**
     * Create a new VPC.
     *
     * @param string      $name        A human-readable name for the VPC
     * @param string      $region      The region slug where the VPC will be created
     * @param string|null $description Free-form text field for description
     * @param string|null $ipRange     The range of IP addresses in the VPC in CIDR notation
     *
     * @throws ExceptionInterface
     *
     * @return VpcEntity
     */
    public function create(
        string $name,
        string $region,
        ?string $description = null,
        ?string $ipRange = null
    ): VpcEntity {
        $data = [
            'name' => $name,
            'region' => $region,
        ];

        if (null !== $description) {
            $data['description'] = $description;
        }

        if (null !== $ipRange) {
            $data['ip_range'] = $ipRange;
        }

        $vpc = $this->post('vpcs', $data);

        return new VpcEntity($vpc->vpc);
    }

    /**
     * Update a VPC.
     *
     * @param string      $id          The VPC ID
     * @param string      $name        A human-readable name for the VPC
     * @param string|null $description Free-form text field for description
     * @param bool|null   $default     Whether this VPC is the default for the region
     *
     * @throws ExceptionInterface
     *
     * @return VpcEntity
     */
    public function update(
        string $id,
        string $name,
        ?string $description = null,
        ?bool $default = null
    ): VpcEntity {
        $data = ['name' => $name];

        if (null !== $description) {
            $data['description'] = $description;
        }

        if (null !== $default) {
            $data['default'] = $default;
        }

        $vpc = $this->put(\sprintf('vpcs/%s', $id), $data);

        return new VpcEntity($vpc->vpc);
    }

    /**
     * Delete a VPC.
     *
     * @param string $id
     *
     * @throws ExceptionInterface
     *
     * @return void
     */
    public function remove(string $id): void
    {
        $this->delete(\sprintf('vpcs/%s', $id));
    }

    /**
     * List members of a VPC.
     *
     * @param string $id The VPC ID
     *
     * @throws ExceptionInterface
     *
     * @return array
     */
    public function listMembers(string $id): array
    {
        $members = $this->get(\sprintf('vpcs/%s/members', $id));

        return $members->members ?? [];
    }
}
