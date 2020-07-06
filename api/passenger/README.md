# Passenger API
Passenger API contains operations for passenger registration and data retrievals which is related to the passenger.


<details><summary>Registration</summary>

## Registration of Passenger:

### EXPECTED CLIENT
`Mobile App`

### ENDPOINT
`[website base address]/api/passenger/register.php`

### REQUEST DETAILS

#### Request Method:
`POST`

#### Request Body:
|Member|Data Type|Comment|
|--|--|--|
|firstname|string||
|lastname|string||
|email|string||
|password|string||
|address|string||
|mobile|string||
|panicmobile|string||

### RESPONSE DETAILS

#### Response Status Codes:
|Status|Description|
|--|--|
|201|Created|
|400|Bad Request|
|401|Unauthorized|
|405|Method Not Allowed|
|500|Internal Server Error|

#### Response Body:
|Member|Data Type|Comment|
|--|--|--|
|message|string||
|id|numeric|Registration Succesful|

### SAMPLES

#### Sample Request:
~~~~
POST [website base address]/api/passenger/register.php HTTP/1.1
Content-Type: application/json

{
    "firstname": "Karlo EMil",
    "lastname": "Flores",
    "email":"keflores@up.edu.ph",
    "password": "123",
    "address": "Don Pablo Bldg, 114 Amorsolo Street, Legazpi Village, Makati, Kalakhang Maynila, Philippines",
    "mobile": "09232341156",
    "panicmobile": "093434554212",
    "creditcardnumber": "124566",
    "playerid":"123"
}
~~~~

#### Sample Response:
~~~~
Access-Control-Allow-Methods: POST
Access-Control-Allow-Orgin: *
Connection: close
Content-Type: application/json; charset=UTF-8
Date: Fri, 30 Mar 2018 09:00:57 +0000
Location: /api/passenger/get.php?id=1
Status: 201

{
    "message": "Passenger Successfully Registered.",
    "id": 1
}
~~~~


</details>


<details><summary>Update Passenger</summary>

## Updating a Passenger:

### EXPECTED CLIENT
`Web Portal`
`Mobile App`

### ENDPOINT
`[website base address]/api/passenger/update.php`

### REQUEST DETAILS

#### Request Method:
`POST`

#### Request Body:
|Member|Data Type|Comment|
|--|--|--|
|firstname|string||
|lastname|string||
|email|string||
|password|string||
|address|string||
|mobile|string||
|panicmobile|string||

### RESPONSE DETAILS

#### Response Status Codes:
|Status|Description|
|--|--|
|201|Created|
|400|Bad Request|
|401|Unauthorized|
|405|Method Not Allowed|
|500|Internal Server Error|

#### Response Body:
|Member|Data Type|Comment|
|--|--|--|
|message|string||
|id|numeric|Registration Succesful|

### SAMPLES

#### Sample Request:
~~~~
POST [website base address]/api/passenger/update.php HTTP/1.1
Content-Type: application/json

{
    "firstname": "Karlo EMil",
    "lastname": "Flores",
    "email": "karloemilflores@gmail.com",
    "password": "123456",
    "address": "Don Pablo Bldg, 114 Amorsolo Street, Legazpi Village, Makati, Kalakhang Maynila, Philippines",
    "mobile": "0912345677",
    "creditcardnumber":"123456",
    "panicmobile": "0912345677"
}
~~~~

#### Sample Response:
~~~~
Access-Control-Allow-Methods: POST
Access-Control-Allow-Orgin: *
Connection: close
Content-Type: application/json; charset=UTF-8
Date: Fri, 30 Mar 2018 09:00:57 +0000
Location: /api/passenger/get.php?id=1
Status: 201

{
    "message": "Passenger Successfully Updated.",
    "id": 1
}
~~~~


</details>


<details><summary>Delete Passenger</summary>

## Deletes a Passenger:

### EXPECTED CLIENT
`Web Portal`

### ENDPOINT
`[website base address]/api/passenger/delete.php

### REQUEST DETAILS

#### Request Method:
`POST`

#### Request Body:
|Member|Data Type|Comment|
|--|--|--|
|id|int||

### RESPONSE DETAILS

#### Response Status Codes:
|Status|Description|
|--|--|
|201|Created|
|400|Bad Request|
|401|Unauthorized|
|405|Method Not Allowed|
|500|Internal Server Error|

#### Response Body:
|Member|Data Type|Comment|
|--|--|--|
|message|string||
|id|numeric|Passenger's Account Removed|

### SAMPLES

#### Sample Request:
~~~~
POST [website base address]/api/passenger/delete.php HTTP/1.1
Content-Type: application/json

{
    "id": 1
   
}
~~~~

#### Sample Response:
~~~~
Access-Control-Allow-Methods: POST
Access-Control-Allow-Orgin: *
Connection: close
Content-Type: application/json; charset=UTF-8
Date: Fri, 30 Mar 2018 09:00:57 +0000
Location: /api/passenger/get.php?id=1
Status: 201

{
    "message": "Passenger Account Deleted",
    "id": 1
}
~~~~


</details>

<details><summary>Authenticate Passenger</summary>

## Authenticate upon login:

### EXPECTED CLIENT
`Mobile App`

### ENDPOINT
`[website base address]/api/passenger/authenticate.php

### REQUEST DETAILS

#### Request Method:
`POST`

#### Request Body:
|Member|Data Type|Comment|
|--|--|--|
|email|string|optional field but return an empty string if no set email|
|mobile|string|optional field but return an empty string if no set mobile|
|password|string||
### RESPONSE DETAILS

#### Response Status Codes:
|Status|Description|
|--|--|
|201|Created|
|400|Bad Request|
|401|Unauthorized|
|405|Method Not Allowed|
|500|Internal Server Error|

#### Response Body:
|Member|Data Type|Comment|
|--|--|--|
|message|string||
|id|numeric|Login Successfull|

### SAMPLES

#### Sample Request:
~~~~
POST [website base address]/api/passenger/authenticate.php HTTP/1.1
Content-Type: application/json

{
    "email": "karloemilflores@gmail.com",
     "mobile": "",
      "password": "123456"
   
}
~~~~

#### Sample Response:
~~~~
Access-Control-Allow-Methods: POST
Access-Control-Allow-Orgin: *
Connection: close
Content-Type: application/json; charset=UTF-8
Date: Fri, 30 Mar 2018 09:00:57 +0000
Location: /api/passenger/get.php?id=1
Status: 200

{
    "message": "Account is valid and existing",
    "id": 1
}
~~~~


</details>


<details><summary>Forgot Password</summary>

## Forgot Password:

### EXPECTED CLIENT
`Mobile App`

### ENDPOINT
`[website base address]/api/passenger/forgotpass.php

### REQUEST DETAILS

#### Request Method:
`POST`

#### Request Body:
|Member|Data Type|Comment|
|--|--|--|
|email|string|Email of the account for the temporary email be sent|
### RESPONSE DETAILS

#### Response Status Codes:
|Status|Description|
|--|--|
|201|Created|
|400|Bad Request|
|401|Unauthorized|
|405|Method Not Allowed|
|500|Internal Server Error|

#### Response Body:
|Member|Data Type|Comment|
|--|--|--|
|message|string||
|id|numeric|Sent the temporary Password|

### SAMPLES

#### Sample Request:
~~~~
POST [website base address]/api/passenger/forgotpass.php HTTP/1.1
Content-Type: application/json

{
    "email": "karloemilflores@gmail.com"
   
}
~~~~

#### Sample Response:
~~~~
Access-Control-Allow-Methods: POST
Access-Control-Allow-Orgin: *
Connection: close
Content-Type: application/json; charset=UTF-8
Date: Fri, 30 Mar 2018 09:00:57 +0000
Location: /api/passenger/get.php?id=1
Status: 201

{
    "message": "Sent temporary Password",
    "id": 1
}
~~~~


</details>


<details><summary>Activate Account</summary>

## Activate Account:

### EXPECTED CLIENT
`Web Portal`
`Mobile App`

### ENDPOINT
`[website base address]/api/passenger/activateaccount.php` 

### REQUEST DETAILS

#### Request Method:
`POST`

#### Request Body:
|Member|Data Type|Comment|
|--|--|--|
|token|string|token should match the set token|
### RESPONSE DETAILS

#### Response Status Codes:
|Status|Description|
|--|--|
|201|Created|
|400|Bad Request|
|401|Unauthorized|
|405|Method Not Allowed|
|500|Internal Server Error|

#### Response Body:
|Member|Data Type|Comment|
|--|--|--|
|message|string||
|id|numeric|id of the activated account|

### SAMPLES

#### Sample Request:
~~~~
POST [website base address]/api/passenger/activateaccount.php HTTP/1.1
Content-Type: application/json

{
    "token": "wafuwafuqh0e"
   
}
~~~~

#### Sample Response:
~~~~
Access-Control-Allow-Methods: POST
Access-Control-Allow-Orgin: *
Connection: close
Content-Type: application/json; charset=UTF-8
Date: Fri, 30 Mar 2018 09:00:57 +0000
Location: /api/passenger/get.php?id=1
Status: 201

{
    "message": "Activated the account",
    "id": 1
}
~~~~

</details>

<details><summary>Get Profile</summary>

## Get Profile:

### EXPECTED CLIENT
`Web Portal`
`Mobile App`

### ENDPOINT
`[website base address]/api/passenger/get.php?id=1` or 
`[website base address]/api/passenger/get.php` -> this will fetch all the passenger data in the database


### REQUEST DETAILS

#### Request Method:
`GET`

### RESPONSE DETAILS

#### Response Status Codes:
|Status|Description|
|--|--|
|201|Created|
|400|Bad Request|
|401|Unauthorized|
|405|Method Not Allowed|
|500|Internal Server Error|

#### Response Body:
|Member|Data Type|Comment|
|--|--|--|
|message|string||
|id|numeric|Sent the temporary Password|

### SAMPLES

#### Sample Response:
~~~~
Access-Control-Allow-Methods: POST
Access-Control-Allow-Orgin: *
Connection: close
Content-Type: application/json; charset=UTF-8
Date: Fri, 30 Mar 2018 09:00:57 +0000
Location: /api/passenger/get.php?id=1
Status: 201

{
    "firstname": "Karlo Emil",
    "lastname": "Flores",
    "email": "karloemilflores@gmail.com",
    "address": "North",
     "mobile": "012323232",
        "panicmobile": "012323232",
           "password": "123456",
}
~~~~


</details>


<details><summary>Set passenger's player id</summary>

### EXPECTED CLIENT
`Mobile App`

## Set passenger's player id:

### ENDPOINT
`[website base address]/api/passenger/setplayerid.php`

### REQUEST DETAILS

#### Request Method:
`POST`

#### Request Body:
|Member|Data Type|Comment|
|--|--|--|
|id|numeric||
|playerid|string||

### RESPONSE DETAILS

#### Response Status Codes:
|Status|Description|
|--|--|
|200|Success|
|400|Bad Request|
|401|Unauthorized|
|404|Not Found|
|405|Method Not Allowed|
|500|Internal Server Error|

#### Response Body:
|Member|Data Type|Comment|
|--|--|--|
|message|string||
|id|numeric|Present only if operation is successful|

### SAMPLES

#### Sample Request:
~~~~
POST [website base address]/api/passenger/setplayerid.php HTTP/1.1
Content-Type: application/json

{
	"id": 1,
	"playerid": "c0bb7827-6f61-46e9-ad53-28068fda6415"
}
~~~~

#### Sample Response:
~~~~
Access-Control-Allow-Methods: POST
Access-Control-Allow-Orgin: *
Connection: close
Content-Type: application/json; charset=UTF-8
Date: Sat, 05 May 2018 08:19:02 +0000
Status: 200

{
    "message": "Passenger Player ID set.",
    "id": 1
}
~~~~


</details>
