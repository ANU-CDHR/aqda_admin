<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">AQDA Administration System</h1>
    <br>
</p>

The AQDA is an online digital archive about LGBTIQA+ forced displacement. It is part of the PhD research. The AQDA Administration System is a data management system that records metadata about interviews. It also provides a REST API that can be used to provide data to a public-facing system and allows it to display data in various ways, such as the AQDA Public System. 

Please find further details at [The Assembling Queer Displacement Archive (AQDA)](https://aqda.au/).

# Requirements
Yii 2.0 <br/>
PHP 5.6+ <br/>
MYSQL 5.5+ <br/>

# Installation
The system was built with the Yii framework (http://www.yiiframework.com/) and Yii Advanced Project Template (https://www.yiiframework.com/extension/yiisoft/yii2-app-advanced). 

## Composer
```
composer install
```
Please refer to Yii 2.0 (https://www.yiiframework.com/doc/guide/2.0/en/start-installation) and extensions (https://www.yiiframework.com/doc/guide/2.0/en/structure-extensions) for their installation steps. 

## Vagrant and Docker
Please refer to https://github.com/yiisoft/yii2-app-advanced/blob/master/docs/guide/start-installation.md

For customisation or configuration, please refer to the Yii guide (https://www.yiiframework.com/doc/guide/2.0/) and Yii Advanced Template guide (https://github.com/yiisoft/yii2-app-advanced).

# Update

## Minor Update single extension or core
```
composer require extension-name-version
```
Example:
```
composer require "yiisoft/yii2:~2.0.50" 
```
## Major update for all extensions and core
```
composer update 
```
## Check and audit extension version and security
```
composer show
composer audit
```
<br/><br/>



<a href="https://fairsoftwarechecklist.net/v0.2?f=21&a=31112&i=31222&r=123">
  <img src="https://fairsoftwarechecklist.net/badge.svg" alt="FAIR checklist badge">
</a>
