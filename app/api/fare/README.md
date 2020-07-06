# Fare API
The Fare API contains operations for managing the fare matrix. Using this API, fare could be set based on vehicle type, distance travel per minute and per kilometer. The API also have an operation for calculating fare based on given parameter.

<details><summary>Registering new fare matrix</summary>

## Registering new fare matrix:

### EXPECTED CLIENT
`Web Portal`

### ENDPOINT
`[website base address]/api/fare/add.php`

### REQUEST DETAILS

#### Request Method:
`POST`

#### Request Body:
|Member|Data Type|Comment|
|--|--|--|
|vehicle_type|string||
|base_fare|decimal||
|per_km|decimal||
|per_minute|decimal||
|surge_rush_threshold|numeric||
|surge_rush_multiplier|decimal||
|surge_time_multiplier|decimal||

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
|id|numeric|The fare matrix id. Present only if operation is successful|

### SAMPLES

#### Sample Request:
~~~~
POST [website base address]/api/fare/add.php HTTP/1.1
Content-Type: application/json

{
    "vehicle_type": "Sedan",
	"base_fare": 150.00,
	"per_km": 10.00,
	"per_minute": 5.00,
	"surge_rush_threshold": 3,
	"surge_rush_multiplier": 1.3,
	"surge_time_multiplier": 1.2
}
~~~~

#### Sample Response:
~~~~
Access-Control-Allow-Methods: POST
Access-Control-Allow-Orgin: *
Connection: close
Content-Type: application/json; charset=UTF-8
Date: Sun, 08 Apr 2018 11:57:08 +0000
Location: /api/fare/get.php?id=1
Status: 201

{
    "message": "Fare Matrix Added.",
    "id": 1
}
~~~~


</details>


<details><summary>Getting the fare matrix (Detailed Response)</summary>

## Getting the fare matrix (Detailed Response):

### EXPECTED CLIENT
`Web Portal`

### ENDPOINT
`[website base address]/api/fare/get.php`

### REQUEST DETAILS

#### Request Method:
`GET`

#### Request Parameter:
|Name|Description|
|--|--|
|id|Id of the fare matrix|

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
|vehicle_type|string||
|base_fare|decimal||
|per_km|decimal||
|per_minute|decimal||
|surge_rush_threshold|numeric||
|surge_rush_multiplier|decimal||
|surge_time_multiplier|decimal||

### SAMPLES

#### Sample Request:
~~~~
GET [website base address]/api/fare/get.php?id=1 HTTP/1.1 
~~~~

#### Sample Response:
~~~~
Access-Control-Allow-Methods: GET
Access-Control-Allow-Orgin: *
Connection: close
Content-Type: application/json; charset=UTF-8
Date: Sun, 08 Apr 2018 12:10:51 +0000
Status: 200

{
    "id": 1,
    "vehicle_type": "Sedan",
    "base_fare": 150,
    "per_km": 10,
    "per_minute": 5,
    "surge_rush_threshold": 3,
    "surge_rush_multiplier": 1.3,
    "surge_time_multiplier": 1.2
}
~~~~

</details>

<details><summary>Getting fare matrix list</summary>

## Getting fare matrix list:

### EXPECTED CLIENT
`Web Portal`

### ENDPOINT
`[website base address]/api/fare/get.php`

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
|vehicle_type|string||
|base_fare|decimal||
|per_km|decimal||
|per_minute|decimal||
|surge_rush_threshold|numeric||
|surge_rush_multiplier|decimal||
|surge_time_multiplier|decimal||

### SAMPLES

#### Sample Request:
~~~~
GET [website base address]/api/fare/get.php HTTP/1.1 
~~~~

#### Sample Response:
~~~~
Access-Control-Allow-Methods: GET
Access-Control-Allow-Orgin: *
Connection: close
Content-Type: application/json; charset=UTF-8
Date: Sun, 08 Apr 2018 12:13:12 +0000
Status: 200

[
    {
        "id": 1,
        "vehicle_type": "Sedan",
        "base_fare": 150,
        "per_km": 10,
        "per_minute": 5,
        "surge_rush_threshold": 3,
        "surge_rush_multiplier": 1.3,
        "surge_time_multiplier": 1.2
    },
    {
        "id": 2,
        "vehicle_type": "Compact",
        "base_fare": 130,
        "per_km": 9,
        "per_minute": 5,
        "surge_rush_threshold": 3,
        "surge_rush_multiplier": 1.3,
        "surge_time_multiplier": 1.2
    },
    {
        "id": 3,
        "vehicle_type": "Van",
        "base_fare": 300,
        "per_km": 15,
        "per_minute": 7,
        "surge_rush_threshold": 3,
        "surge_rush_multiplier": 1.3,
        "surge_time_multiplier": 1.2
    },
    {
        "id": 4,
        "vehicle_type": "SUV",
        "base_fare": 280,
        "per_km": 14,
        "per_minute": 7,
        "surge_rush_threshold": 3,
        "surge_rush_multiplier": 1.3,
        "surge_time_multiplier": 1.2
    },
    {
        "id": 5,
        "vehicle_type": "Limousine",
        "base_fare": 350,
        "per_km": 20,
        "per_minute": 10,
        "surge_rush_threshold": 3,
        "surge_rush_multiplier": 1.3,
        "surge_time_multiplier": 1.2
    }
]
~~~~


</details>

<details><summary>Updating the fare matrix</summary>

## Updating the fare matrix:

### EXPECTED CLIENT
`Web Portal`

### ENDPOINT
`[website base address]/api/fare/update.php`

### REQUEST DETAILS

#### Request Method:
`POST`

#### Request Body:
|Member|Data Type|Comment|
|--|--|--|
|id|numeric||
|vehicle_type|string||
|base_fare|decimal||
|per_km|decimal||
|per_minute|decimal||
|surge_rush_threshold|numeric||
|surge_rush_multiplier|decimal||
|surge_time_multiplier|decimal||

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
POST [website base address]/api/fare/update.php HTTP/1.1
Content-Type: application/json

{
    "id": 1,
    "vehicle_type": "Sedan",
	"base_fare": 150.00,
	"per_km": 10.00,
	"per_minute": 5.00,
	"surge_rush_threshold": 3,
	"surge_rush_multiplier": 1.3,
	"surge_time_multiplier": 1.2
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
    "message": "Fare matrix updated.",
    "id": 1
}
~~~~


</details>

<details><summary>Deleting the fare matrix</summary>

## Deleting the fare matrix:

### EXPECTED CLIENT
`Web Portal`

### ENDPOINT
`[website base address]/api/fare/delete.php`

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
POST [website base address]/api/fare/delete.php HTTP/1.1
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
    "message": "Fare matrix successfully deleted.",
    "id": 1
}
~~~~


</details>

<details><summary>Calculating fare</summary>

## Calculating fare:

### EXPECTED CLIENT
`Mobile App`

### ENDPOINT
`[website base address]/api/fare/compute.php`

### REQUEST DETAILS

#### Request Method:
`POST`

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
**Array of:**

|Member|Data Type|Comment|
|--|--|--|
|vehicle_type|string||
|distance_km|decimal|Travel distance in kilometer|
|distance_minute|decimal|Travel time in minute|
|source_lat|decimal|Travel time in minute|

### SAMPLES

#### Sample Request:
~~~~
POST [website base address]/api/fare/compute.php HTTP/1.1
Content-Type: application/json

{
    "vehicle_type": "Sedan",
    "distance_km": 12.56,
    "distance_minute": 96.8,
    "source_lat": 14.556764,
    "source_long": 121.014685,
    "radius": 5
}
~~~~

#### Sample Response:
~~~~
Access-Control-Allow-Methods: POST
Access-Control-Allow-Orgin: *
Connection: close
Content-Type: application/json; charset=UTF-8
Date: Sun, 08 Apr 2018 20:38:10 +0800
Status: 200

{
    "Vehicle Type": "Sedan",
    "Base Fare": 150,
    "Per KM": 10,
    "Per Minute": 5,
    "Distance": 12.56,
    "Base Amount": 759.6,
    "Rush Hour Surge Amount": 227.88,
    "Time Surge Amount": 151.92,
    "Total Surge Amount": 379.8,
    "Total Amount": 1139.4
}
~~~~


</details>
