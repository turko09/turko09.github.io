# Report API
Report API contains operations for returning statistics which could be used in reporting or in dashboards.


<details><summary>Getting administrator statistics</summary>

## Getting administrator statistics:

### EXPECTED CLIENT
`Web Portal`

### ENDPOINT
`[website base address]/api/report/adminstats.php`

### REQUEST DETAILS

#### Request Method:
`GET`

#### Request Parameter:
|Name|Description|
|--|--|
|datestart|Optional. Date coverage start|
|dateend|Optional. Date coverage end|

### RESPONSE DETAILS

#### Response Status Codes:
|Status|Description|
|--|--|
|200|Success|
|401|Unauthorized|
|405|Method Not Allowed|
|500|Internal Server Error|

#### Response Body:

|Member|Data Type|Comment|
|--|--|--|
|totaladmin|numeric|Total number of Administrators|
|totalactive|numeric|Total number of Administrators with Active status|


### SAMPLES

#### Sample Request:
~~~~
GET [website base address]/api/report/adminstats.php?datestart=2018-03-01&dateend=2018-03-31 HTTP/1.1 
~~~~

#### Sample Response:
~~~~
Access-Control-Allow-Methods: GET
Access-Control-Allow-Orgin: *
Connection: close
Content-Type: application/json; charset=UTF-8
Date: Sun, 01 Apr 2018 12:16:34 +0000
Status: 200

{
    "totaladmin": 4,
    "totalactive": 4
}
~~~~


</details>


<details><summary>Getting driver statistics</summary>

## Getting driver statistics:

### EXPECTED CLIENT
`Web Portal`

### ENDPOINT
`[website base address]/api/report/driverstats.php`

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

|Member|Data Type|Comment|
|--|--|--|
|totaldriver|numeric|Total number of Drivers|
|totalactive|numeric|Total number of Drivers with Active status|
|totalblocked|numeric|Total number of Drivers with Blocked status|


### SAMPLES

#### Sample Request:
~~~~
GET [website base address]/api/report/driverstats.php?datestart=2018-03-01&dateend=2018-03-31 HTTP/1.1 
~~~~

#### Sample Response:
~~~~
Access-Control-Allow-Methods: GET
Access-Control-Allow-Orgin: *
Connection: close
Content-Type: application/json; charset=UTF-8
Date: Sun, 01 Apr 2018 12:16:34 +0000
Status: 200

{
    "totaldriver": 36,
    "totalactive": 36,
    "totalblocked": 0
}
~~~~


</details>


<details><summary>Getting trips statistics</summary>

## Getting trips statistics:

### EXPECTED CLIENT
`Web Portal`

### ENDPOINT
`[website base address]/api/report/tripstats.php`

### REQUEST DETAILS

#### Request Method:
`GET`

#### Request Parameter:
|Name|Description|
|--|--|
|datestart|Optional. Date coverage start|
|dateend|Optional. Date coverage end|

### RESPONSE DETAILS

#### Response Status Codes:
|Status|Description|
|--|--|
|200|Success|
|401|Unauthorized|
|405|Method Not Allowed|
|500|Internal Server Error|

#### Response Body:

|Member|Data Type|Comment|
|--|--|--|
|total|numeric|Total trips|
|totalrequested|numeric|Total requested trips|
|totalassigned|numeric|Total trips assigned to a vehicle|
|totalrejected|numeric|Total rejected trips|
|totalongoing|numeric|Total trips which are currently ongoing|
|totalcompleted|numeric|Total completed trips|
|totalcancelled|numeric|Total cancelled trips|

### SAMPLES

#### Sample Request:
~~~~
GET [website base address]/api/report/tripstats.php?datestart=2018-03-01&dateend=2018-03-31 HTTP/1.1 
~~~~

#### Sample Response:
~~~~
Access-Control-Allow-Methods: GET
Access-Control-Allow-Orgin: *
Connection: close
Content-Type: application/json; charset=UTF-8
Date: Sun, 01 Apr 2018 12:16:34 +0000
Status: 200

{
    "total": 3,
    "totalrequested": 2,
    "totalassigned": 0,
    "totalrejected": 0,
    "totalongoing": 0,
    "totalcompleted": 1,
    "totalcancelled": 0
}
~~~~


</details>


<details><summary>Getting vehicle statistics</summary>

## Getting vehicle statistics:

### EXPECTED CLIENT
`Web Portal`

### ENDPOINT
`[website base address]/api/report/vehiclestats.php`

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

|Member|Data Type|Comment|
|--|--|--|
|total|numeric|Total vehicles|
|totalonduty|numeric|Total vehicles which are on duty at the moment|
|totalavailable|numeric|Total available vehicles at the moment|
|totalontrip|numeric|Total vehicles which are on trip at the moment|

### SAMPLES

#### Sample Request:
~~~~
GET [website base address]/api/report/vehiclestats.php HTTP/1.1 
~~~~

#### Sample Response:
~~~~
Access-Control-Allow-Methods: GET
Access-Control-Allow-Orgin: *
Connection: close
Content-Type: application/json; charset=UTF-8
Date: Wed, 04 Apr 2018 12:12:19 +0000
Status: 200

{
    "total": 15,
    "totalonduty": 10,
    "totalavailable": 4,
    "totalontrip": 6
}
~~~~


</details>


<details><summary>Getting fare statistics</summary>

## Getting fare statistics:

### EXPECTED CLIENT
`Web Portal`

### ENDPOINT
`[website base address]/api/report/farestats.php`

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

|Member|Data Type|Comment|
|--|--|--|
|total|numeric|Total fare matrices configured|
|avgbasefare|numeric|Average base fare|
|lowestbasefare|numeric|Lowest configured base fare|
|hightestbasefare|numeric|Highest configured base fare|
|avgfareperkm|numeric|Average fare per km confiured|
|lowestfareperkm|numeric|Lowest fare per km confiured|
|hightestfareperkm|numeric|Highest fare per km confiured|
|avgfareperminute|numeric|Average fare per minute confiured|
|lowestfareperminute|numeric|Lowest fare per minute confiured|
|hightestfareperminute|numeric|Highest fare per minute confiured|

### SAMPLES

#### Sample Request:
~~~~
GET [website base address]/api/report/farestats.php HTTP/1.1 
~~~~

#### Sample Response:
~~~~
Access-Control-Allow-Methods: GET
Access-Control-Allow-Orgin: *
Connection: close
Content-Type: application/json; charset=UTF-8
Date: Wed, 04 Apr 2018 12:15:51 +0000
Status: 200

{
    "totalmatrices": 5,
    "avgbasefare": 242,
    "lowestbasefare": 130,
    "hightestbasefare": 350,
    "avgfareperkm": 13,
    "lowestfareperkm": 9,
    "hightestfareperkm": 20,
    "avgfareperminute": 6,
    "lowestfareperminute": 5,
    "hightestfareperminute": 10
}
~~~~


</details>


<details><summary>Getting passenger statistics</summary>

## Getting passenger statistics:

### EXPECTED CLIENT
`Web Portal`

### ENDPOINT
`[website base address]/api/report/passengerstats.php`

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

|Member|Data Type|Comment|
|--|--|--|
|total|numeric|Total passenger|
|totalactive|numeric|Total active passengers|
|totalblocked|numeric|Total blocked passengers|

### SAMPLES

#### Sample Request:
~~~~
GET [website base address]/api/report/passengerstats.php HTTP/1.1 
~~~~

#### Sample Response:
~~~~
Access-Control-Allow-Methods: GET
Access-Control-Allow-Orgin: *
Connection: close
Content-Type: application/json; charset=UTF-8
Date: Wed, 04 Apr 2018 12:42:17 +0000
Status: 200

{
    "total": 25,
    "totalactive": 24,
    "totalblocked": 0
}
~~~~


</details>

