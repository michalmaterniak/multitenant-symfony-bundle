<?php

namespace CommitM\MultiTenant\Doctrine\Filter;

use Doctrine\ORM\Mapping\ClassMetadata;

class ClassMetadataFieldName
{
    public function __construct(protected ClassMetadata $classMetadata, protected readonly string $property)
    {}

    public function getFieldName(): array
    {
        switch (true) {
            case isset($this->classMetadata->fieldMappings[$this->property]):
                return [$this->classMetadata->fieldMappings[$this->property]['fieldName']];
            case isset($this->classMetadata->associationMappings[$this->property]):
                return array_column(
                    $this->classMetadata->associationMappings[$this->property]['joinColumns'],
                    'name'
                );
        }

        return [];
    }
}
