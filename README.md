Yii2 Users module
==============

1 Introduction
----------------------------

**Users module** -- Module for the Yii2 framework, which provides user management with changing 
the next default profile data:
- name
- login
- email
- password
- status
- roles (if authManager exists in application and rbacManage is true)

2 Dependencies
----------------------------
- php >= 7
- composer
- MySql >= 5.5

3 Installation
----------------------------

Via composer:

```composer require "itstructure/yii2-users-module": "^1.0.0"```

or in section **require** of composer.json file set the following:
```
"require": {
    "itstructure/yii2-users-module": "^1.0.0"
}
```
and command ```composer install```, if you install yii2 project extensions first,

or command ```composer update```, if all yii2 project extensions are already installed.

4 Usage
----------------------------

### 4.1 Main properties

- The **name** of module: ```users```
- The **namespace** for used classes: ```Itstructure\UsersModule```.
- The **alias** to access in to module root directory: ```@users```.
- **There is not a layout !** It's taken from application layout **main** by default **or how it is 
configured**.
You cat set ```layout``` attribute in module by custom.
- **View** component is taken by default from the framework like **yii\web\View**. You cat set 
**View** component in module by custom.

### 4.2 Application config

Base application config must be like in example below:

```php
use Itstructure\UsersModule\Module;
use Itstructure\UsersModule\controllers\ProfileController;
```
```php
'modules' => [
    'users' => [
        'class' => Module::class,
        'controllerMap' => [
            'profile' => ProfileController::class,
        ],
    ],
],
```

### 4.3 Useful module attributes

- ```loginUrl``` - set url to be redirected if you are not authorized.
- ```rbacManage``` - if **true**, here will be involved the following functional:
    - ```roles``` field in **ProfileValidate** model to validate roles.
    - ```roles``` field in **create**, **update** and **_form** template.
    
    Roles, which are exist, will be loaded via **authManager** from application automatically.
        
- ```accessRoles``` - The roles of users who are allowed access.
- ```customRewrite``` - if **true**, there will be overwritten completely the next **profile** attributes instead of combining:
    - ```rules```, ```attributes```, ```attributeLabels``` in **ProfileValidate** model by custom
     values which can be set in **ProfileValidateComponent**.
    - form fields in **_form** template by custom ```formFields``` value which can be set in **ProfileValidateComponent**.
    - GridView columns in index template by custom ```indexViewColumns``` value which can be set in **ProfileValidateComponent**.
    - DetailView attributes in view template by custom ```detailViewAttributes``` value which can
     be set in **ProfileValidateComponent**.

    If ```customRewrite``` is **false**, then the above listed parameters will be merged with custom values.

Example:

```php
use Itstructure\UsersModule\Module;
use Itstructure\UsersModule\components\ProfileValidateComponent;
```
```php
'modules' => [
    'users' => [
        'class' => Module::class,
        'controllerMap' => [
            'profile' => ProfileController::class,
        ],
        'accessRoles' => ['admin', 'manager'],
        'components' => [
            'profile-validate-component' => [
                'class' => ProfileValidateComponent::class,
                'rules' => [...],
                'attributes' => [...],
                'attributeLabels' => [...],
                'formFields' => [...],
                'indexViewColumns' => [...],
                'detailViewAttributes' => [...],
            ],
        ]
    ],
],
```

**Warning!**
To set parameters of ProfileValidateComponent correctly, see how it's already done in the 
view profile templates and ProfileValidate model by default as example.

License
----------------------------
Copyright © 2018 Andrey Girnik girnikandrey@gmail.com.

Licensed under the [MIT license](http://opensource.org/licenses/MIT). See LICENSE.txt for details.
