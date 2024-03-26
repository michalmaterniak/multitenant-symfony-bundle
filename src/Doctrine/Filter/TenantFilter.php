<?php

namespace CommitM\MultiTenant\Doctrine\Filter;

use CommitM\MultiTenant\Multitenancy\TenantInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;

class TenantFilter extends SQLFilter
{
    protected TenantInterface $tenant;

    public function setTenant(TenantInterface $tenant): void
    {
        $this->tenant = $tenant;
    }

    protected function findFieldName(ClassMetadataFieldName $classMetadataFieldName): array {
        return $classMetadataFieldName->getFieldName();
    }

    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias): string
    {
        if (!(new \ReflectionClass($targetEntity->getName()))->implementsInterface($this->tenant->getInterfaceAware())) {
            return '';
        }

        $conditions = [];

        foreach ($this->findFieldName(new ClassMetadataFieldName($targetEntity, $this->tenant->getProperty())) as $column) {
            $conditions[] = "{$targetTableAlias}.{$column} = {$this->tenant->getEntity()->getId()}";
        }

        if ($conditions) {
            return implode(' AND ', $conditions);
        }

        return '';
    }
}
