<?php

declare(strict_types=1);

namespace CommitM\MultiTenant\Doctrine\EventListener;

use CommitM\MultiTenant\Multitenancy\Exception\EntityNotDefinedInTenant;
use CommitM\MultiTenant\Multitenancy\Provider\TenantsProvider;
use CommitM\MultiTenant\Multitenancy\TenantAware;
use CommitM\MultiTenant\Multitenancy\TenantInterface;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;

final class TenantListener
{
    protected TenantAware $entity;

    public function __construct(protected TenantsProvider $tenantsProvider)
    {}

    public function preUpdate(PreUpdateEventArgs $preUpdateEventArgs): void
    {}

    public function prePersist(PrePersistEventArgs $prePersistEventArgs): void
    {
        $entity = $prePersistEventArgs->getObject();

        if ($entity instanceof TenantAware) {

            $this->entity = $entity;

            foreach ((new \ReflectionClass($entity))->getInterfaces() as $interface) {
                foreach ($interface->getInterfaces() as $implementedInterface) {
                    if ($implementedInterface->getName() === TenantAware::class) {
                        if ($this->tenantsProvider->hasTenantByInterfaceAware($interface->getName())) {
                            $this->setValue(
                                $this->tenantsProvider->getTenantByInterfaceAware($interface->getName())
                            );

                            return;
                        }
                    }
                }
            }
        }
    }

    protected function setValue(TenantInterface $tenant): void {
        $reflectionProperty = new \ReflectionProperty(
            $this->entity,
            $tenant->getProperty()
        );

        $tenantEntity = null;

        if ($tenant->hasEntity()) {
            $tenantEntity = $tenant->getEntity();
        }

        if (!$tenantEntity) {
            throw new EntityNotDefinedInTenant();
        }

        $reflectionProperty->setValue(
            $this->entity,
            $tenantEntity
        );
    }
}
