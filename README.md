
# MultiTenant Bundle for Symfony 7

simplify to configure multitenant bundle



## Deployment

To deploy this project run

in ``` packages/multi_tenant.yaml ``` add:

```yaml
multi_tenant:
    tenants:
        company_id:
            entity: App\Entity\Company
            aware: App\Entity\Interfaces\TenantAwares\CompanyAware
            property: company

```

```company_id``` name tenant

```entity``` entity name to limited others entities or automatically set tenant

```aware``` to following entities what you want and limited results
Aware interface have to implements 
```CommitM\MultiTenant\Multitenancy\TenantAware```

```property``` name property tenant

-------

```
CommitM\MultiTenant\Multitenancy\Provider\TenantsProvider
```
service to manage tenants

you can use like that:
```
$tenantsProvider->getTenantByClass(Company::class)->setEntity($this->company);
```

if tenant is set, you don't need remember using setter with tenant's entity
$product = new Product():
$product->setCompany(); // this will be set automatically