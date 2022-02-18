<p align="center">
    <h1 align="center">Calendar Solution </h1>
    <br>
</p>

Getting Started
---------------
 Run the service

    docker-compose up --build backend db

for unit tests use the following command

     docker-compose run backend tests/bin/yii migrate
     docker-compose run backend ./vendor/bin/codecept run

login credentials

    username: test
    password: ArT.1969

API usage
    
    Get Login Token
    POST: http://localhost:21080/login

    Create Booking
    POST: http://localhost:21080/books


TODOs

    1.move credentials into environment
    2.split config into production,development, e.t.c
    3.implement openAPI (e.g. swagger) for apis documentation
    4.add more tests
    5.implement better way of authentication (without storing tokens in db)

DIRECTORY STRUCTURE
-------------------
    common
    config/              contains shared configurations
    controllers/         contains console controllers (commands)
    migrations/          contains database migrations
    repositories/        contains database repositories
    runtime/             contains files generated during runtime
    services/            contains model services
    tests/               contains tests for common classes    
    models/              contains model classes used in both backend and 
    vendor/              contains dependent 3rd-party packages
    web/                 contains the entry script and Web resources


# Routes

###### Login: *POST*
[login](http://localhost:21080/login)
###### Index: *GET*
[index](http://localhost:21080/bookings)
###### View: *GET*
[View](http://localhost:21080/bookings/1)
###### Create Method: *POST*
[Create](http://localhost:21080/bookings)
###### Update Method: *PATCH*
[Update](http://localhost:21080/bookings/1)
###### Delete Method: *DELETE*
[Delete](http://localhost:21080/bookings/1)


###Table structure
####users
| Key  | Description|Type|
|:---|:---|:---|
| id | primary   |integer|
| username| username   |string|
| password_hash| user's password hashed  |string|
| access_token| user's access token for authentication |string|
| created_at| when user created |int|
| updated_at| when user updated |int|

####bookings
| Key| Description|Type|
|:---|:---|:---|
| id | primary   |integer|
| inviter| user id who invite meeting |integer|
| participant| meeting participant id |integer|
| date_start| when meeting will start |integer|
| date_end| when meeting will end |integer|
