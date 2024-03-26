<?php

namespace CommitM\MultiTenant\Multitenancy;

interface TenantInterface
{
    public function getProperty(): string;

    public function getInterfaceAware(): string;

    public function getEntityClass(): string;

    public function setEntity(TenantEntityInterface $tenantEntity);

    public function getEntity(): TenantEntityInterface;

    public function hasEntity(): bool;
}
