<?php

namespace CommitM\MultiTenant\Multitenancy\Tenant;

use CommitM\MultiTenant\Multitenancy\TenantEntityInterface;
use CommitM\MultiTenant\Multitenancy\TenantInterface;
use CommitM\MultiTenant\Multitenancy\Exception\EntityNotDefinedInTenant;

class Tenant implements TenantInterface
{
    protected TenantEntityInterface $entity;

    public function __construct(protected TenantConfig $tenantConfig)
    {}

    public function getProperty(): string
    {
        return $this->tenantConfig->getProperty();
    }

    public function getInterfaceAware(): string
    {
        return $this->tenantConfig->getAware();
    }

    public function getEntityClass(): string
    {
        return $this->tenantConfig->getClass();
    }

    public function getEntity(): TenantEntityInterface
    {
        if (!$this->hasEntity()) {
            throw new EntityNotDefinedInTenant();
        }

        return $this->entity;
    }

    public function hasEntity(): bool
    {
        return isset($this->entity);
    }

    public function setEntity(TenantEntityInterface $tenantEntity): void
    {
        $this->entity = $tenantEntity;
    }
}
