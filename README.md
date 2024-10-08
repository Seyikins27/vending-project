<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>



## About the Vending Project

A Laravel Application that allows users to vend airtime while from different network providers while being able to switch between different vending partners

- [Simple, fast routing engine](https://laravel.com/docs/routing).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Setting up and installation

clone this project by running 

<code><pre><tab><tab>git clone https://github.com/Seyikins27/vending-project </pre></code>

After Cloning this project, navigate to the directory of this project and run the following command on the terminal

<code><pre><tab><tab>composer install </pre></code>

This install all the vendor packages associated with this project.

Connfigure your environment file (.env) file with the appropriate parameters.

## Migrations and Data Seeding
This project comes with already seeded data to enable you quickly simulate and test the functions.

Run the following command to setup the database and also to seed the sample data
<code><pre><tab><tab>php artisan migrate --seed </pre></code>

## Startup the server by running 
<code><pre><tab><tab>php artisan serve  </pre></code> 

This will be served by default on port 8000  

However if you wish to specify a port you can add the "--port={desired port number}" to serve the project on a specified port

### Accessing the features

## Register a user or use a seeded data

To Register a user 

<pre>POST: {base_url}/api/user/register </pre>using the POST method using the following fields

<pre>
-name 
-email
-password
-password_confirmation </pre>

## login with the created user or one of the seeded user
<pre>POST: {base_url}/api/login </pre>

 using the following fields

 <pre>
-email
-password </pre>
 
A token is then gotten from the request body which will then be used for subsequent requests

## header information
Accept:application/json
Authorization: Bearer {token}

### Endpoints
- Check wallet balance
   <pre> - GET: {base_url}/api/user/wallet/balance </pre>

- Topup wallet
    <pre>- POST: {base_url}/api/user/wallet/topup </pre>
    - fields
        - amount : has to be a number

- Check wallet transactions
    <pre>- GET: {base_url}/api/user/wallet/transactions </pre>
 
- Purchase Airtime
** This invloves matching a network provider e.g "MTN" to an airtime vending service like e.g. "Shaggo"

    <pre>- POST: {base_url}/api/user/airtime/vend </pre>
    - fields
      <pre>
        - network_provider : requires the id of any of the network providers that exists in the database,
        - vending_partner : requires the id of any of the network providers that exists in the database,
        - data: this is an array contains all of the fields required by any of the vending partners to be able to make a request to vend
          - amount : compulsory
          - phone: compulsory
          - .. all other fields as specified in the documentation of the vending service provider </pre>

    ## sample request to vend airtime
    <code><pre>{
      "network_provider":1,
      "vending_partner":1,
      "data":{
         "amount":200,
         "phone":"080xxxxxxxx",
         "email":"test@shagopayments.com",
         "password":"test123",
         "Accept":"application/json",
         "Content-Type":"application/json",
         "vend_type":"VTU",
         "serviceCode":"QAB",
         "request_id":"647792580181",
         "hashKey":"c1df88d180d0163fc53f4efde6288a2c87a2ceaaefae0685fd4a8c01b217e70d",
         "x-api-key":"T7Wi2Q7tHFkq6sxU5WaUSBIGg3ynb96Qi74RnAeY6ys="
      }
}</pre></code>

** <strong>Note:</strong> The parameters within the "data" array are subject to the required request parameters for the specific vending service, 
<p>only "amount" and "phone" are required and consistent across all requests regardless of the vending service </p>
<p>however multiple parameters can be fixed in to accomodate all the possible vending requests, only the specific parameters for the vending service will be sent as a request. </p>



## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
