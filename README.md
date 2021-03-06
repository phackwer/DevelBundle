# README

## Requires

```json
        "sansis/basebundle" : "dev-master"
        "friendsofsymfony/jsrouting-bundle" : "1.4.*@dev",
        "braincrafted/bootstrap-bundle" : "2.0.*",
        "twitter/bootstrap" : "3.1.*",
        "knplabs/knp-menu-bundle" : "1.1.2",
        "knplabs/knp-paginator-bundle" : "~2.4",
        "psliwa/pdf-bundle" : "dev-master"
```
        
## Use it in another project

composer.json:
```json
    [...]
    "require-dev" : {
        [...]
        "sansis/develbundle" : "dev-master"
    },
    "repositories" : [{
        "type" : "vcs",
        "url" : "https://github.com/phackwer/DevelBundle.git"
    }],
    [...]
```

## Add to AppKernel

```php
         //SanSIS Core Production Bundles
         new SanSIS\Core\DevelBundle\SanSISCoreDevelBundle(),
```

## Add to routing.yml

```yml  
san_sis_core_devel:
    resource: "@SanSISCoreDevelBundle/Resources/config/routing.yml"
    prefix:   /devel
```
