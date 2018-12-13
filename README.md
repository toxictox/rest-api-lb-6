DEPLOY INSTRUCTIONS:

* composer install
* php bin/console doctrine:schema:update --force
* php bin/console server:start

Application now is available on URL: http://127.0.0.1:8000

REQUIREMENTS:

* PHP ^7.0
* MySQL 5.6
* Composer package manager

USAGE:
* http://127.0.0.1:8000/users/create - for create operation
* http://127.0.0.1:8000/users/read/{ID} - for read operation
* http://127.0.0.1:8000/users/update/{ID} - for update operation
* http://127.0.0.1:8000/users/delete/{ID} - for delete operation

    
    Mandatory fields for create client:
        
        lastname,
        name,
        gender,
        address,
        birthdate,
        city,
        pasport,
        pasportNum,
        patronymic,
        secondCity,
        nationality,
        
    All existing fields:
    
            'lastname',
            'name',
            'gender',
            'address',
            'birthdate',
            'city',
            'homePhone',
            'secondCity',
            'nationality',
            'mobilePhone',
            'pasport',
            'pasportNum',
            'passportID',
            'patronymic',
       
* Create operation available by POST REQUEST
* Read operation available by GET REQUEST
* Update operation available by POST REQUEST
* Delete operation available by POST REQUEST

Postman is good solution for REST-API testing.