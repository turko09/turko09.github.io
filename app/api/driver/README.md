# Driver API
Driver API contains operations for manipulating driver information including registering a new one, uploading files related to them, getting drivers, updating them, and deleting them.


<details><summary>Registering a new driver</summary>

## Registering a new driver:

### EXPECTED CLIENT
`Web Portal`

### ENDPOINT
`[website base address]/api/driver/register.php`

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
|photo|string|base64 encoded string of the photo|

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
|id|numeric|The driver id. Present only if operation is successful|

### SAMPLES

#### Sample Request:
~~~~
POST [website base address]/api/driver/register.php HTTP/1.1
Content-Type: application/json

{
    "firstname": "Juan",
    "lastname": "Dela Cruz",
    "email": "juan@delacruz.com",
    "password": "meh",
    "address": "Manila, Philippines",
    "mobile": "09200000000",
    "photo": "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"
} 
~~~~

#### Sample Response:
~~~~
Access-Control-Allow-Methods: POST
Access-Control-Allow-Orgin: *
Connection: close
Content-Type: application/json; charset=UTF-8
Date: Sun, 25 Mar 2018 11:14:22 +0000
Location: /api/driver/get.php?id=1
Status: 201

{
    "message": "Driver registered.",
    "id": 1
}
~~~~


</details>


<details><summary>Getting a driver (Detailed Response)</summary>

## Getting a driver (Detailed Response):

### EXPECTED CLIENT
`Web Portal`
`Mobile App`

### ENDPOINT
`[website base address]/api/driver/get.php`

### REQUEST DETAILS

#### Request Method:
`GET`

#### Request Parameter:
|Name|Description|
|--|--|
|id|Id of the driver|

### RESPONSE DETAILS

#### Response Status Codes:
|Status|Description|
|--|--|
|200|Success|
|401|Unauthorized|
|404|Not Found|
|405|Method Not Allowed|
|500|Internal Server Error|

#### Response Body:
|Member|Data Type|Comment|
|--|--|--|
|id |numeric||
|firstname|string||
|lastname|string||
|email|string||
|address|string||
|mobile|string||
|active|numeric|1 or 0|
|verified|numeric|1 or 0|
|blocked|numeric|1 or 0|
|photo|string|base64 encoded string of the photo|
|rating|numeric||
|datecreated|datetime||
|datemodified|datetime||

### SAMPLES

#### Sample Request:
~~~~
GET [website base address]/api/driver/get.php?id=1 HTTP/1.1 
~~~~

#### Sample Response:
~~~~
Access-Control-Allow-Methods: GET
Access-Control-Allow-Orgin: *
Connection: close
Content-Type: application/json; charset=UTF-8
Date: Sun, 25 Mar 2018 12:59:31 +0000
Status: 200

{
    "id": 1,
    "firstname": "Juan",
    "lastname": "Dela Cruz",
    "email": "juan@delacruz.com",
    "address": "Manila, Philippines",
    "mobile": "09200000000",
    "active": 0,
    "verified": 0,
    "blocked": 0,
    "photo": "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",,
    "rating": 3.3333
    "datecreated": "2018-03-25 11:14:22",
    "datemodified": "2018-03-25 11:14:22"
}
~~~~


</details>


<details><summary>Getting drivers list</summary>

## Getting drivers list:

### EXPECTED CLIENT
`Web Portal`

### ENDPOINT
`[website base address]/api/driver/get.php`

### REQUEST DETAILS

#### Request Method:
`GET`

### RESPONSE DETAILS

#### Response Status Codes:
|Status|Description|
|--|--|
|200|Success|
|401|Unauthorized|
|405|Method Not Allowed|
|500|Internal Server Error|

#### Response Body:
**Array of:**

|Member|Data Type|Comment|
|--|--|--|
|id |numeric||
|firstname|string||
|lastname|string||
|email|string||
|mobile|string||
|active|numeric|1 or 0|
|verified|numeric|1 or 0|
|blocked|numeric|1 or 0|
|rating|numeric||

### SAMPLES

#### Sample Request:
~~~~
GET [website base address]/api/driver/get.php HTTP/1.1 
~~~~

#### Sample Response:
~~~~
Access-Control-Allow-Methods: GET
Access-Control-Allow-Orgin: *
Connection: close
Content-Type: application/json; charset=UTF-8
Date: Sun, 25 Mar 2018 13:04:16 +0000
Status: 200

[
    {
        "id": 1,
        "firstname": "Juan",
        "lastname": "Dela Cruz",
        "email": "juan@delacruz.com",
        "mobile": "09200000000",
        "active": 0,
        "verified": 0,
        "blocked": 0,
        "rating": 3.3333
    },
    {
        "id": 8,
        "firstname": "John",
        "lastname": "Doe",
        "email": "john@delacruz.com",
        "mobile": "09211111111",
        "active": 0,
        "verified": 0,
        "blocked": 0,
        "rating": null
    }
]
~~~~


</details>


<details><summary>Updating a driver</summary>

## Updating a driver:

### EXPECTED CLIENT
`Web Portal`
`Mobile App`

### ENDPOINT
`[website base address]/api/driver/update.php`

### REQUEST DETAILS

#### Request Method:
`POST`

#### Request Body:
|Member|Data Type|Comment|
|--|--|--|
|id|numeric||
|firstname|string||
|lastname|string||
|email|string||
|password|string||
|address|string||
|mobile|string||
|photo|string|base64 encoded string of the photo|

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
POST [website base address]/api/driver/update.php HTTP/1.1
Content-Type: application/json

{
    "id": 1,
    "firstname": "John",
    "lastname": "Doe",
    "email": "john@delacruz.com",
    "password": "meh",
    "address": "Taguig, Philippines",
    "mobile": "09211111111",
    "photo": "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"
}
~~~~

#### Sample Response:
~~~~
Access-Control-Allow-Methods: POST
Access-Control-Allow-Orgin: *
Connection: close
Content-Type: application/json; charset=UTF-8
Date: Sun, 25 Mar 2018 23:47:16 +0000
Status: 200

{
    "message": "Driver updated.",
    "id": 1
}
~~~~


</details>


<details><summary>Updating driver's status</summary>

### EXPECTED CLIENT
`Web Portal`

## Updating driver's status:

### ENDPOINT
`[website base address]/api/driver/updatestatus.php`

### REQUEST DETAILS

#### Request Method:
`POST`

#### Request Body:
|Member|Data Type|Comment|
|--|--|--|
|id|numeric||
|active|numeric|1 or 0|
|verified|numeric|1 or 0|
|blocked|numeric|1 or 0|

Note: One or all three of those status could be present in the requests.

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
POST [website base address]/api/driver/updatestatus.php HTTP/1.1
Content-Type: application/json

{
	"id": 1,
	"active": 1
}
~~~~

#### Sample Response:
~~~~
Access-Control-Allow-Methods: POST
Access-Control-Allow-Orgin: *
Connection: close
Content-Type: application/json; charset=UTF-8
Date: Mon, 26 Mar 2018 00:40:12 +0000
Status: 200

{
    "message": "Driver status updated.",
    "id": 1
}
~~~~


</details>


<details><summary>Deleting a driver</summary>

### EXPECTED CLIENT
`Web Portal`

## Deleting a driver:

### ENDPOINT
`[website base address]/api/driver/delete.php`

### REQUEST DETAILS

#### Request Method:
`POST`

#### Request Body:
|Member|Data Type|Comment|
|--|--|--|
|id|numeric||

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
POST [website base address]/api/driver/delete.php HTTP/1.1
Content-Type: application/json

{
    "id": 1
}
~~~~

#### Sample Response:
~~~~
Access-Control-Allow-Methods: POST
Access-Control-Allow-Orgin: *
Connection: keep-alive
Content-Length: 51
Content-Type: application/json; charset=UTF-8
Date: Sat, 24 Mar 2018 11:35:09 GMT
Status: 200

{
    "message": "Driver deleted.",
    "id": 1
}
~~~~


</details>


<details><summary>Adding a new document</summary>

## Adding a new document:

### EXPECTED CLIENT
`Web Portal`

### ENDPOINT
`[website base address]/api/driver/adddocument.php`

### REQUEST DETAILS

#### Request Method:
`POST`

#### Request Body:
|Member|Data Type|Comment|
|--|--|--|
|driverid|numeric||
|description|string||
|type|string||
|document|string|base64 encoded string of the file|

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
|id|numeric|The document id. Present only if operation is successful|

### SAMPLES

#### Sample Request:
~~~~
POST [website base address]/api/driver/adddocument.php HTTP/1.1
Content-Type: application/json

{
    "driverid": 1,
    "description": "Driver's License",
    "type": "Image",
    "document": "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"
}
~~~~

#### Sample Response:
~~~~
Access-Control-Allow-Methods: POST
Access-Control-Allow-Orgin: *
Connection: close
Content-Type: application/json; charset=UTF-8
Date: Mon, 26 Mar 2018 03:11:22 +0000
Location: /api/driver/getdocument.php?id=1
Status: 201

{
    "message": "Driver document added.",
    "id": 1
}
~~~~


</details>


<details><summary>Getting a document (Detailed Response)</summary>

## Getting a document (Detailed Response):

### EXPECTED CLIENT
`Web Portal`

### ENDPOINT
`[website base address]/api/driver/getdocument.php`

### REQUEST DETAILS

#### Request Method:
`GET`

#### Request Parameter:
|Name|Description|
|--|--|
|id|Id of the document|

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
|id |numeric||
|driverid|numeric||
|description|string||
|type|string||
|document|string|base64 encoded string of the file|
|datecreated|datetime||
|datemodified|datetime||

### SAMPLES

#### Sample Request:
~~~~
GET [website base address]/api/driver/getdocument.php?id=1 HTTP/1.1 
~~~~

#### Sample Response:
~~~~
Access-Control-Allow-Methods: GET
Access-Control-Allow-Orgin: *
Connection: close
Content-Type: application/json; charset=UTF-8
Date: Sun, 25 Mar 2018 12:59:31 +0000
Status: 200

{
    "id": 2,
    "driverid": 3,
    "description": "Driver's License",
    "type": "Image",
    "document": "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",
    "datecreated": "2018-03-26 03:11:22",
    "datemodified": "2018-03-26 03:11:22"
}
~~~~


</details>


<details><summary>Getting documents list</summary>

## Getting documents list:

### EXPECTED CLIENT
`Web Portal`

### ENDPOINT
`[website base address]/api/driver/getdocument.php`

### REQUEST DETAILS

#### Request Method:
`GET`

#### Request Parameter:
|Name|Description|
|--|--|
|driverid|Id of the driver|


### RESPONSE DETAILS

#### Response Status Codes:
|Status|Description|
|--|--|
|200|Success|
|400|Bad Request|
|401|Unauthorized|
|405|Method Not Allowed|
|500|Internal Server Error|

#### Response Body:
**Array of:**

|Member|Data Type|Comment|
|--|--|--|
|id |numeric||
|driverid|numeric||
|description|string||
|type|string||

### SAMPLES

#### Sample Request:
~~~~
GET [website base address]/api/driver/getdocument.php?driverid=1 HTTP/1.1 
~~~~

#### Sample Response:
~~~~
Access-Control-Allow-Methods: GET
Access-Control-Allow-Orgin: *
Connection: close
Content-Type: application/json; charset=UTF-8
Date: Mon, 26 Mar 2018 03:46:19 +0000
Status: 200

[
    {
        "id": 1,
        "driverid": 1,
        "description": "Driver's License",
        "type": "Image"
    },
    {
        "id": 2,
        "driverid": 1,
        "description": "Vehicle Registration",
        "type": "Image"
    }
]
~~~~


</details>


<details><summary>Updating a document</summary>

## Updating a document:

### EXPECTED CLIENT
`Web Portal`

### ENDPOINT
`[website base address]/api/driver/updatedocument.php`

### REQUEST DETAILS

#### Request Method:
`POST`

#### Request Body:
|Member|Data Type|Comment|
|--|--|--|
|id|numeric||
|driverid|numeric||
|description|string||
|type|string||
|document|string|base64 encoded string of the file|

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
POST [website base address]/api/driver/updatedocument.php HTTP/1.1
Content-Type: application/json

{
    "id": 1,
    "driverid": 1,
    "description": "Updated Driver's License",
    "type": "Image",
    "document": "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"
}
~~~~

#### Sample Response:
~~~~
Access-Control-Allow-Methods: POST
Access-Control-Allow-Orgin: *
Connection: close
Content-Type: application/json; charset=UTF-8
Date: Sun, 25 Mar 2018 23:47:16 +0000
Status: 200

{
    "message": "Driver document updated.",
    "id": 1
}
~~~~


</details>


<details><summary>Deleting a document</summary>

## Deleting a document:

### EXPECTED CLIENT
`Web Portal`

### ENDPOINT
`[website base address]/api/driver/deletedocument.php`

### REQUEST DETAILS

#### Request Method:
`POST`

#### Request Body:
|Member|Data Type|Comment|
|--|--|--|
|id|numeric||

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
POST [website base address]/api/driver/deletedocument.php HTTP/1.1
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
Date: Mon, 26 Mar 2018 04:05:25 +0000
Status: 200

{
    "message": "Driver document deleted.",
    "id": 1
}
~~~~


</details>


<details><summary>Authenticating a driver's credentials</summary>

## Authenticating a driver's credentials:

### EXPECTED CLIENT
`Mobile App`

### ENDPOINT
`[website base address]/api/driver/authenticate.php`

### REQUEST DETAILS

#### Request Method:
`POST`

#### Request Body:
|Member|Data Type|Comment|
|--|--|--|
|email|string|Mutually exclusive with mobile|
|mobile|string|Mutually exclusive with email|
|password|string||

Note: Either email or mobile should be present in the request, along with the password.

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
|id|numeric|Driver's id. Present only if operation is successful|

### SAMPLES

#### Sample Request:
~~~~
POST [website base address]/api/driver/authenticate.php HTTP/1.1
Content-Type: application/json

{
	"mobile": "09211111111",
	"password": "meh"
}
~~~~

#### Sample Response:
~~~~
Access-Control-Allow-Methods: POST
Access-Control-Allow-Orgin: *
Connection: close
Content-Type: application/json; charset=UTF-8
Date: Mon, 26 Mar 2018 04:35:21 +0000
Status: 200

{
    "message": "Authentication success.",
    "id": "1"
}
~~~~


</details>


<details><summary>Forgot password</summary>

## Forgot password:

### EXPECTED CLIENT
`Mobile App`

### ENDPOINT
`[website base address]/api/driver/forgotpass.php`

### REQUEST DETAILS

#### Request Method:
`POST`

#### Request Body:
|Member|Data Type|Comment|
|--|--|--|
|email|string|Mutually exclusive with mobile|
|mobile|string|Mutually exclusive with email|

Note: Either email or mobile should be present in the request.

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
|id|numeric|Driver's id. Present only if operation is successful|

### SAMPLES

#### Sample Request:
~~~~
POST [website base address]/api/driver/forgotpass.php HTTP/1.1
Content-Type: application/json

{
	"email": "john@delacruz.com"
}
~~~~

#### Sample Response:
~~~~
Access-Control-Allow-Methods: POST
Access-Control-Allow-Orgin: *
Connection: close
Content-Type: application/json; charset=UTF-8
Date: Sat, 31 Mar 2018 10:52:04 +0000
Status: 200

{
    "message": "Driver password updated. New password was sent via email.",
    "id": 1
}
~~~~


</details>


<details><summary>Set driver's player id</summary>

### EXPECTED CLIENT
`Mobile App`

## Set driver's player id:

### ENDPOINT
`[website base address]/api/driver/setplayerid.php`

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
POST [website base address]/api/driver/setplayerid.php HTTP/1.1
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
Date: Sat, 05 May 2018 08:16:48 +0000
Status: 200

{
    "message": "Driver Player ID set.",
    "id": 1
}
~~~~


</details>