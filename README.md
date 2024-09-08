<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>



## About Vending Project

A Laravel Application that allows users to vend airtime while from different network providers while being able to switch between different vending partners

- [Simple, fast routing engine](https://laravel.com/docs/routing).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Setting up and installation

clone this project by running 
##
<tab><tab>git clone https://github.com/Seyikins27/vending-project
After Cloning this project, navigate to the directory of this project and run the following command on the terminal
##
<tab><tab>composer install

This install all the vendor packages associated with this project.

Connfigure your environment file (.env) file with the appropriate parameters.

## Migrations and Data Seeding
This project comes with already seeded data to enable you quickly simulate and test the functions.

## Run the following command to setup the database and also to seed the sample data
<tab><tab>php artisan migrate --seed

## Startup the server by running 
<tab><tab>php artisan serve  //this serves by default on port 8000
However if you wish to specify a port you can add the "--port={desired port number}" to serve the project on a specified port

### Accessing the features

## Register a user or use a seeded data

To Register a user 

{base_url}/api/user/register using the POST method using the following fields

-name 
-email
-password
-password_confirmation

## login with the created user or one of the seeded user
POST: {base_url}/api/login 

A token is then gotten from the request body which will then be used for subsequent requests

## header information
Accept:application/json
Authorization: Bearer {token}

### Endpoints
- Check wallet balance
    - GET: {base_url}/api/user/wallet/balance

- Topup wallet
    - POST: {base_url}/api/user/wallet/topup
    - fields
        - amount : has to be a number

- Check wallet transactions
    - GET: {base_url}/api/user/wallet/transactions
 
- Purchase Airtime
** This invloves matching a network provider e.g "MTN" to an airtime vending service like e.g. "Shaggo"

    - POST: {base_url}/api/user/airtime/vend
    - fields
        - network_provider : requires the id of any of the network providers that exists in the database,
        - vending_partner : requires the id of any of the network providers that exists in the database,
        - data: this is an array contains all of the fields required by any of the vending partners to be able to make a request to vend
          - amount : compulsory
          - phone: compulsory
          - .. all other fields as specified in the documentation of the vending service provider

    ## sample request to vend airtime
    {
      "network_provider":1,
      "vending_partner":1,
      "data":{
         "amount":200,
         "phone":"08065324736",
         "Accept":"application/json",
         "email":"test@shagopayments.com",
         "password":"test123",
         "Content-Type":"application/json",
         "vend_type":"VTU",
         "serviceCode":"QAB",
         "request_id":"647929258018"
      }
    }

** note: The parameters within the "data" array are subject to the specific vending service, 

only "amount" and "phone" are required and consistent across all requests regardless of the vending service


## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
