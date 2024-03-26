<?php

namespace CommitM\MultiTenant\Multitenancy\Exception;

class EntityNotDefinedInTenant extends \Exception
{
    public function __construct()
    {
        parent::__construct('Entity is not defined. Probably tenant is scalar value or was not set');
    }
}
