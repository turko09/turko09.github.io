# Payment
Payment API contains operations for accepting payments for trips made.


<details><summary>Accepting Payment</summary>

## Accepting Payment:

### EXPECTED CLIENT
`Mobile App`

### ENDPOINT
`[website base address]/api/payment/payment.php`

### REQUEST DETAILS

#### Request Method:
`POST`

#### Request Body:
|Member|Data Type|Comment|
|--|--|--|
|tripid|int||
|amount|decimal||
|mode|string||


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
|id|string|Payment Recorded|

### SAMPLES

#### Sample Request:
~~~~
POST [website base address]/api/passenger/register.php HTTP/1.1
Content-Type: application/json

{
    "tripid": 1,
    "mode": "CASH",
    "amount": 522
   
}
~~~~

#### Sample Response:
~~~~
Access-Control-Allow-Methods: POST
Access-Control-Allow-Orgin: *
Connection: close
Content-Type: application/json; charset=UTF-8
Date: Fri, 30 Mar 2018 09:00:57 +0000
Location: /api/payment/get.php?id=1
Status: 201

{
    "message": "Successfully recorded the payment",
    "id": 1
}
~~~~


</details>

<details><summary>Retrieve Payments</summary>

## Retrieve Payments:

### EXPECTED CLIENT
`Web Portal`

### ENDPOINT
`[website base address]/api/payment/filterpayment.php`

### REQUEST DETAILS

#### Request Method:
`POST`

#### Request Body:
|Member|Data Type|Comment|
|--|--|--|
|from|date|Format: "yyyy-mm-dd"|
|to|date|Format: "yyyy-mm-dd"|

Note* Not setting any from and to date will retrieve all the recorded payments


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
|id|numeric||
|tripid|numeric||
|amount|decimal||
|date|datetime||
|mode|string||

### SAMPLES

#### Sample Request:
~~~~
POST [website base address]/api/payment/filterpayment.php HTTP/1.1
Content-Type: application/json

{
    "from": "2018-02-03",
    "to": "2018-02-10"

   
}
~~~~

#### Sample Response:
~~~~
Access-Control-Allow-Methods: POST
Access-Control-Allow-Orgin: *
Connection: close
Content-Type: application/json; charset=UTF-8
Date: Fri, 30 Mar 2018 09:00:57 +0000
Status: 201

[
    {
        "id": 1,
        "tripid": 1,
        "amount": 1400,
        "date": "2018-02-06",
        "mode": "CASH"
    }
]
~~~~


</details>


<details><summary>Retrieve Payments by Passenger ID</summary>

## Retrieve Payments:

### EXPECTED CLIENT
`Web Portal`

### ENDPOINT
`[website base address]/api/payment/filterpayment.php`

### REQUEST DETAILS

#### Request Method:
`POST`

#### Request Body:
|Member|Data Type|Comment|
|--|--|--|
|from|date|Format: "yyyy-mm-dd"|
|to|date|Format: "yyyy-mm-dd"|
|passengerid|numeric||


Note* Not setting any from and to date will retrieve all the recorded payments


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
|id|string|List of Payments|

### SAMPLES

#### Sample Request:
~~~~
POST [website base address]/api/payment/filterpayment.php HTTP/1.1
Content-Type: application/json

{
    "from": "2018-02-03",
    "to": "2018-02-10",
    "passengerid": 1

   
}
~~~~

#### Sample Response:
~~~~
Access-Control-Allow-Methods: POST
Access-Control-Allow-Orgin: *
Connection: close
Content-Type: application/json; charset=UTF-8
Date: Fri, 30 Mar 2018 09:00:57 +0000
Status: 201

[
    {
        "tripid": 1,
        "amount": 1400,
        "date": "2018-02-06",
        "mode": "CASH"
    }
]
~~~~


</details>


<details><summary>Retrieve Payments by Driver ID</summary>

## Retrieve Payments:

### EXPECTED CLIENT
`Web Portal`

### ENDPOINT
`[website base address]/api/payment/filterpayment.php`

### REQUEST DETAILS

#### Request Method:
`POST`

#### Request Body:
|Member|Data Type|Comment|
|--|--|--|
|from|date|Format: "yyyy-mm-dd"|
|to|date|Format: "yyyy-mm-dd"|
|driverid|numeric||


Note* Not setting any from and to date will retrieve all the recorded payments


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
|id|string|List of Payments|

### SAMPLES

#### Sample Request:
~~~~
POST [website base address]/api/payment/filterpayment.php HTTP/1.1
Content-Type: application/json

{
    "from": "2018-02-03",
    "to": "2018-02-10",
    "driverid": 1   
}
~~~~

#### Sample Response:
~~~~
Access-Control-Allow-Methods: POST
Access-Control-Allow-Orgin: *
Connection: close
Content-Type: application/json; charset=UTF-8
Date: Fri, 30 Mar 2018 09:00:57 +0000
Status: 201

[
    {
        "tripid": 1,
        "amount": 1400,
        "date": "2018-02-06",
        "mode": "CASH"
    }
]
~~~~


</details>




