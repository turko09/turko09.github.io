# Vehicle API
Vehicle API contains operations for managing the vehicle assigned to a driver.


<details><summary>Adding a vehicle to a driver</summary>

## Adding a vehicle to a driver:

### EXPECTED CLIENT
`Web Portal`

### ENDPOINT
`[website base address]/api/vehicle/add.php`

### REQUEST DETAILS

#### Request Method:
`POST`

#### Request Body:
|Member|Data Type|Comment|
|--|--|--|
|driverid|string||
|plateno|string||
|type|string|Values could be "Sedan", "Compact", "Van", "SUV", or "Limousine"|
|make|string||
|model|string||
|color|string||
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
|id|numeric|The vehicle id. Present only if operation is successful|

### SAMPLES

#### Sample Request:
~~~~
POST [website base address]/api/vehicle/add.php HTTP/1.1
Content-Type: application/json

{
    "driverid": 1,
    "plateno": "ABC123",
    "type": "Sedan",
    "make": "Toyota",
    "model": "Vios",
    "color": "Space Grey",
    "photo": "/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAYEBQYFBAYGBQYHBwYIChAKCgkJChQODwwQFxQYGBcUFhYaHSUfGhsjHBYWICwgIyYnKSopGR8tMC0oMCUoKSj/2wBDAQcHBwoIChMKChMoGhYaKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCj/wgARCAC2AOwDASIAAhEBAxEB/8QAGwABAQADAQEBAAAAAAAAAAAAAAUBAwQCBgf/xAAUAQEAAAAAAAAAAAAAAAAAAAAA/9oADAMBAAIQAxAAAAH9UAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAPnz6BJFZJ9FR49hiYVEn0VEn0VErBWSK4AAAAAAk1hJUJB2zrW4+PtVxJq5AAAGJFgSK2ZBXSclVMpGQAAAcXjRXAAAAAAAAAPE2qJGLA07pgpgGg4as2kEqqADWbAAAAAAAAI9iUVQAQ99UfN1KEwppOD3LrUiUqiUqiUqiUqiVz3REt8fGWNc7UTPpNvOaeK76OLtAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD//xAAkEAACAgECBgMBAAAAAAAAAAACBAEDABEUBRITFSAwECRAcP/aAAgBAQABBQL+p7etp7aGGauhm7Mch9aZEhOMmYiJfo13NxZzuTn3sgXM0djOd0Y39Yl7rKbgY+7n3cSuO4GnZqYWsmG9HLchCmZiIiPKYiY2XSndzVkTrHsvLkpoUG2mmoKA0jX2yiITFrdeb0YwH1TmJ1j0MsV0Dw8DrS/EYCcSgvr0Wq83Z15VaFweKcQbP57kwIlLzMvBD9Lkcrfzec108OCATx5vbT4VmNgfhenlt8KxvTjeZYBPWI37hf44hdNdPD710qu4K53BXO4K53BXO4K53BXO4K53BXO4K4zxCnbpa0W/FhjWFXMDR31BkvqRjDKzFKXV2vleuXU3No5LNx4utIn62VxvCLWqc3ZzkUWsGYDYIqrjgjAx/Vf/xAAUEQEAAAAAAAAAAAAAAAAAAABw/9oACAEDAQE/ATT/xAAUEQEAAAAAAAAAAAAAAAAAAABw/9oACAECAQE/ATT/xABAEAACAQIBBwYLBQkBAAAAAAABAgMAEQQSEyEiMVGRIDNBYXGxECMwMkBSYoGhwdEUY3CCgyQ0QkRyc5Ki0uH/2gAIAQEABj8C/FPEmZA2QFRb9HT868RipV6n1x8dNebBKOolPrXjsLOnYMvuqxmVDufV76upBHV4LnQKtGxlP3Slu6vF4SX85C1ohgHbKfpX8t/tWmXDj9Mn5152Hb8pHzrWhhf+mS3eKycQr4c/eDRx2eXeTDMln85X37xWzD8WrZh+LU+dVQyuV1TTxOMOFABGdkycr4VnIMLqlMkiG9mN+sAb60tHh16tdvpV5sqdvvTlfDZVgLDl2OysrByGH2NqcPpVsYma9saU49Hvq42eVdhtCk0kk8k0jMLnxhA4CsiJQq7hV+nyxbCO0DHoXSp/LVpIFl9qJvka14cQnbGT3VYToDuY2Pxq48j4zSW2IBct7qhSQWZVtbd6HZwGHXV40zR3xHI7q8ViBIPVmX5iv2rDvH7Sa61lxOrrvU35WKlPnZebHYAPnf0jOREwzeunT276eLEKFnTbbYw3jk4n+83pOElG3LMZ7CPqByHcC5VSbVFpuWGWzbydp8ESquUzsB2C4ufjyQ8bBlOwj0LCOfNEveCOTm0TPwDzbGzKN2nbWth8SP0791Sajxx5oopcW1if/BQZhkyDVdfVbp8ORHz8upGOvf7ttNhnkCGNjZTtteudHA1zo4GudHA1zo4GudHA1zo4GudHA1zo4GudHA0/2eZGmIsig6b9lPhZGZv442Y6WHT8e8eFnc2VRck1BipWKfaGKlWNtFtX36PjWvKg7Wr94i/yp4rSyhtHi42NR/aOdtp5eewziObpuNV+2rS4SW/sWYVaHCvffKQorOzPnJzov0L1DyliSrDSrrtU1aaHPD14v+TWrhMQT2AfOg2MyQg0iFdI956ayXUMu4itWCIdiCrKAB+K3//EACoQAQABAgMHBQEAAwAAAAAAAAERACExQVFhcZGhscHwECAwQIFw0eHx/9oACAEBAAE/If6nCkpFeyUaYKeSO8jbTz/BwYc6Im0Ehzryrf1FfCFGXvNSejJQMVqSKcuYiKiZrMbqvKoS6KTOVd7goklDQ56NKrG1/wA9V63jLh3KLg7AwN2GeahEkufMmSJfxAgQ2WdxU+c6VPnOlISO7gxnepD7VQZwSmEqEyQCIiFbVmvjXBgPMYHBobtoo7H4UaEGR72QirI50yU36+39FDTT5p/DRQEgq4mfyrFoROwonB2ZBMkAo6NXoUCCGD8qCQklXGCPEStwikAZojo9WjyQmcqyAL0FCgBBG4nwlZsg3UjNTGjUmdz6aFoyElTiNU0ZGHgi6NGFo/7Rc/SiiDhEe4SpuLlaOJfYR7mj8MBvq+kcYxhsuj7cfgw+z1KQexxH57IDQOqCoWhsicdxH0aWTJYIzkOPtHR8rkfpBlFrpDc04+xJIam5y14MAyZKtsjp/sVb/Jy4DMY2oukDYjB5lHrKm5Axl0C7dQXZ9eoQz1ryjtXlHavKO1eUdq8o7V5R2ryjtXlHavKO1Su5ACdjVjSWoYiTq1OT1AJuYABnU0jHIL5TDuqlgTdAqZmcyCvCn4CkIG0YgTGsFcy7WM/e+0CLwDAPRLnKi3TW18x4lBQumHgq/hTONMGA0cjm/ISVcpGsPL1hGM8F3pb8WsBlERcWj7Q6dzXSaYb6eK2MoqZvOMDtQQAwAj+rf//aAAwDAQACAAMAAAAQ8888888888888888888888888888888888888888888888w08w484w88888880AMs888MQw88888k888888888cs088c0888888888848ssY0sMMMMM40488888888888888888888888888888888888888888888888888888888888888/8QAFBEBAAAAAAAAAAAAAAAAAAAAcP/aAAgBAwEBPxA0/8QAFBEBAAAAAAAAAAAAAAAAAAAAcP/aAAgBAgEBPxA0/8QAJxABAQABAwQBBAMBAQAAAAAAAREAITFBUXGBkWEQIDBAcKHw0fH/2gAIAQEAAT8Q/jW/vVFEgLbsRrWRrJsGBMi6IH40aOxxhUL/AJ8E9NvnQjW2z3b2D4YkIGSp14Vw5rM8DtzuafQSIVUA6ri98bIvRQNzdMRlxE1+eSTTu+MOKEQdzU/vAjW3+OcryrpA8rejHBwhq7Q9lykHF3ucSC8T3w0mAmtwtOyH4wkohRNk/NGoLJboEUAIjQmt+mzZSStF8IgS3Z6YtktVS1LMCGoympjh6igBVMAituS62iaL7CP/AFwggNlD1HPA4DAIDA8H3idVCoHcTnFTnqsp+U+/k4+tKBifEewDouHbUQoHZHn8oXoS2KiX40wtDcsJYC6Abc49SkBpVqvKruurikYIgUGUHwesn5GQkIiUTEOpGEeB73+coQrqWcVo8ZDKeAqMHVEk51/rDrEo1kMmot4mFjahROo/hJamw8NRa7i8F1TBfg0QCCTRQhTp+lM3MNHbw5SVksvIgduRxtRTQCvtHdwGSoLaIboy7J85oW9AV6U5+PtdsSaBTFtD0GBzRf2HOWKIp2PWheiZMDiytJfrcRHUEbov1dnP8vp+zArKMQWJaahG0+wwkwOaIeZMmjtQF1nNSdCBoH0EZvwYK8xMOUfP2yIkCfqJo/pBKQO2Tv1+4w2+oIAjojgygeVSMRoACQBGVC0b6lnWof3cvVFWIs9l1YXa64xqtz9H2bqPKXP1K6+cYmx8hOD5GIITtKNIoa0Xf8USJEiRIkSJEpnwppp+BCicaw1w+aLRsQrdTen1CtMOg1U9AMSlVClQGAFdmLWTA4ZQbTy5JPSN+6AVX4MvxMANwNgAaIg4lpQloCCgCQRFBQVBQ+2HQ+ihwBcFkjTWopNTB24Bp45GDwY3a9KHjq9DaeQyj51q6i6/XBVVAqwCZO/vJ395O/vJ395O/vJ395O/vJ395O/vIWzXJaFwhS/ZRGgURHDNK9NZMpCpvL8G2OsmHU1OQAYm0ElSiKC0CAAlaBNqvCN3HTPKjA7zGwVQgdgyfhlyT88On8ef/9k="
}
~~~~

#### Sample Response:
~~~~
Access-Control-Allow-Methods: POST
Access-Control-Allow-Orgin: *
Connection: close
Content-Type: application/json; charset=UTF-8
Date: Wed, 28 Mar 2018 11:51:56 +0000
Location: /api/vehicle/get.php?id=1
Status: 201

{
    "message": "Vehicle added.",
    "id": 1
}
~~~~


</details>


<details><summary>Getting a vehicle (Detailed Response)</summary>

## Getting a vehicle (Detailed Response):

### EXPECTED CLIENT
`Web Portal`
`Mobile App`

### ENDPOINT
`[website base address]/api/vehicle/get.php`

### REQUEST DETAILS

#### Request Method:
`GET`

#### Request Parameter:
|Name|Description|
|--|--|
|id|Id of the vehicle|

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
|driverid|numeric||
|plateno|string||
|type|string||
|make|string||
|model|string||
|color|string||
|photo|string|base64 encoded string of the file|
|active|numeric|1 or 0. Indicates if the vehicle is currently driven by a driver on duty|
|available|numeric|1 or 0. Indicates if the vehicle is available for a trip request|
|locationlat|decimal|Current location - latitude|
|locationlong|decimal|Current location - longitude|
|datecreated|datetime||
|datemodified|datetime||

### SAMPLES

#### Sample Request:
~~~~
GET [website base address]/api/vehicle/get.php?id=1 HTTP/1.1 
~~~~

#### Sample Response:
~~~~
Access-Control-Allow-Methods: GET
Access-Control-Allow-Orgin: *
Connection: close
Content-Type: application/json; charset=UTF-8
Date: Wed, 28 Mar 2018 12:13:53 +0000
Status: 200

{
    "id": 1,
    "driverid": 1,
    "plateno": "ABC123",
    "type": "Sedan",
    "make": "Toyota",
    "model": "Vios",
    "color": "Space Grey",
    "photo": "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5p/DRQEgq4mfyrFoROwonB2ZBMkAo6NXoUCCGD8qCQklXGCPEStwikAZojo9WjyQmcqyAL0FCgBBG4nwlZsg3UjNTGjUmdz6aFoyElTiNU0ZGHgi6NGFo/7Rc/SiiDhEe4SpuLlaOJfYR7mj8MBvq+kcYxhsuj7cfgw+z1KQexxH57IDQOqCoWhsicdxH0aWTJYIzkOPtHR8rkfpBlFrpDc04+xJIam5y14MAyZKtsjp/sVb/Jy4DMY2oukDYjB5lHrKm5Axl0C7dQXZ9eoQz1ryjtXlHavKO1eUdq8o7V5R2ryjtXlHavKO1Su5ACdjVjSWoYiTq1OT1AJuYABnU0jHIL5TDuqlgTdAqZmcyCvCn4CkIG0YgTGsFcy7WM/e+0CLwDAPRLnKi3TW18x4lBQumHgq/hTONMGA0cjm/ISVcpGsPL1hGM8F3pb8WsBlERcWj7Q6dzXSaYb6eK2MoqZvOMDtQQAwAj+rf//aAAwDAQACAAMAAAAQ8888888888888888888888888888888888888888888888w08w484w88888880AMs888MQw88888k888888888cs088c0888888888848ssY0sMMMMM40488888888888888888888888888888888888888888888888888888888888888/8QAFBEBAAAAAAAAAAAAAAAAAAAAcP/aAAgBAwEBPxA0/8QAFBEBAAAAAAAAAAAAAAAAAAAAcP/aAAgBAgEBPxA0/8QAJxABAQABAwQBBAMBAQAAAAAAAREAITFBUXGBkWEQIDBAcKHw0fH/2gAIAQEAAT8Q/jW/vVFEgLbsRrWRrJsGBMi6IH40aOxxhUL/AJ8E9NvnQjW2z3b2D4YkIGSp14Vw5rM8DtzuafQSIVUA6ri98bIvRQNzdMRlxE1+eSTTu+MOKEQdzU/vAjW3+OcryrpA8rejHBwhq7Q9lykHF3ucSC8T3w0mAmtwtOyH4wkohRNk/NGoLJboEUAIjQmt+mzZSStF8IgS3Z6YtktVS1LMCGoympjh6igBVMAituS62iaL7CP/AFwggNlD1HPA4DAIDA8H3idVCoHcTnFTnqsp+U+/k4+tKBifEewDouHbUQoHZHn8oXoS2KiX40wtDcsJYC6Abc49SkBpVqvKruurikYIgUGUHwesn5GQkIiUTEOpGEeB73+coQrqWcVo8ZDKeAqMHVEk51/rDrEo1kMmot4mFjahROo/hJamw8NRa7i8F1TBfg0QCCTRQhTp+lM3MNHbw5SVksvIgduRxtRTQCvtHdwGSoLaIboy7J85oW9AV6U5+PtdsSaBTFtD0GBzRf2HOWKIp2PWheiZMDiytJfrcRHUEbov1dnP8vp+zArKMQWJaahG0+wwkwOaIeZMmjtQF1nNSdCBoH0EZvwYK8xMOUfP2yIkCfqJo/pBKQO2Tv1+4w2+oIAjojgygeVSMRoACQBGVC0b6lnWof3cvVFWIs9l1YXa64xqtz9H2bqPKXP1K6+cYmx8hOD5GIITtKNIoa0Xf8USJEiRIkSJEpnwppp+BCicaw1w+aLRsQrdTen1CtMOg1U9AMSlVClQGAFdmLWTA4ZQbTy5JPSN+6AVX4MvxMANwNgAaIg4lpQloCCgCQRFBQVBQ+2HQ+ihwBcFkjTWopNTB24Bp45GDwY3a9KHjq9DaeQyj51q6i6/XBVVAqwCZO/vJ395O/vJ395O/vJ395O/vJ395O/vIWzXJaFwhS/ZRGgURHDNK9NZMpCpvL8G2OsmHU1OQAYm0ElSiKC0CAAlaBNqvCN3HTPKjA7zGwVQgdgyfhlyT88On8ef/9k=",
    "active": 1,
    "available": 0,
    "locationlat": 0,
    "locationlong": 0,
    "datecreated": "2018-03-28 11:51:56",
    "datemodified": "2018-03-28 12:13:49"
}
~~~~


</details>


<details><summary>Getting vehicle list</summary>

## Getting vehicle list:

### EXPECTED CLIENT
`Web Portal`

### ENDPOINT
`[website base address]/api/vehicle/get.php`

### REQUEST DETAILS

#### Request Method:
`GET`

#### Request Parameter:
|Name|Description|
|--|--|


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
|driverid|numeric||
|plateno|string||
|type|string||
|make|string||
|model|string||
|color|string||
|active|numeric|1 or 0. Indicates if the vehicle is currently driven by a driver on duty|
|available|numeric|1 or 0. Indicates if the vehicle is available for a trip request|
|locationlat|decimal|Current location - latitude|
|locationlong|decimal|Current location - longitude|

### SAMPLES

#### Sample Request:
~~~~
GET [website base address]/api/vehicle/get.php HTTP/1.1 
~~~~

#### Sample Response:
~~~~
Access-Control-Allow-Methods: GET
Access-Control-Allow-Orgin: *
Connection: close
Content-Type: application/json; charset=UTF-8
Date: Wed, 28 Mar 2018 12:29:23 +0000
Status: 200

[
    {
        "id": 1,
        "driverid": 1,
        "plateno": "ABC123",
        "type": "Sedan",
        "make": "Toyota",
        "model": "Vios",
        "color": "Space Grey",
        "active": 1,
        "available": 1,
        "locationlat": 14.58899,
        "locationlong": 120.975238
    }
]
~~~~


</details>


<details><summary>Getting vehicle with driver details list</summary>

## Getting vehicle with driver details list:

### EXPECTED CLIENT
`Web Portal`

### ENDPOINT
`[website base address]/api/vehicle/getwithdriver.php`

### REQUEST DETAILS

#### Request Method:
`GET`

#### Request Parameter:
|Name|Description|
|--|--|


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
|driverid|numeric||
|plateno|string||
|type|string||
|make|string||
|model|string||
|color|string||
|active|numeric|1 or 0. Indicates if the vehicle is currently driven by a driver on duty|
|available|numeric|1 or 0. Indicates if the vehicle is available for a trip request|
|locationlat|decimal|Current location - latitude|
|locationlong|decimal|Current location - longitude|
|driverfirstname|string||
|driverlastname|string||
|driveremail|string||
|drivermobile|string||

### SAMPLES

#### Sample Request:
~~~~
GET [website base address]/api/vehicle/getwithdriver.php HTTP/1.1 
~~~~

#### Sample Response:
~~~~
Access-Control-Allow-Methods: GET
Access-Control-Allow-Orgin: *
Connection: close
Content-Type: application/json; charset=UTF-8
Date: Wed, 28 Mar 2018 12:29:23 +0000
Status: 200

[
    {
        "id": 1,
        "driverid": 1,
        "plateno": "ABC123",
        "type": "Sedan",
        "make": "Toyota",
        "model": "Vios",
        "color": "Space Grey",
        "active": 1,
        "available": 1,
        "locationlat": 14.58899,
        "locationlong": 120.975238,
        "driverfirstname": "John",
        "driverlastname": "Doe",
        "driveremail": "john@delacruz.com",
        "drivermobile": "09211111111"
    },
    {
        "id": 2,
        "driverid": 9,
        "plateno": "BLAH123",
        "type": "Van",
        "make": "Mercedes-Benz",
        "model": "Sprinter",
        "color": "Green",
        "active": 1,
        "available": 0,
        "locationlat": 14.526913,
        "locationlong": 121.033044,
        "driverfirstname": "Jojo",
        "driverlastname": "Sardez",
        "driveremail": "jojosardez@yahoo.com-old",
        "drivermobile": "0923212121"
    },
    {
        "id": 3,
        "driverid": 11,
        "plateno": "THE123",
        "type": "Sedan",
        "make": "Mazda",
        "model": "3",
        "color": "White",
        "active": 0,
        "available": 0,
        "locationlat": 14.545108,
        "locationlong": 121.016993,
        "driverfirstname": "Jojo",
        "driverlastname": "Sardez",
        "driveremail": "jojosardez@yahoo.com",
        "drivermobile": "+61449034769"
    },
    {
        "id": 4,
        "driverid": 1,
        "plateno": "ARF434",
        "type": "Compact",
        "make": "Nissan",
        "model": "Sentra",
        "color": "Blue",
        "active": 1,
        "available": 1,
        "locationlat": 14.571765,
        "locationlong": 121.059175,
        "driverfirstname": "John",
        "driverlastname": "Doe",
        "driveremail": "john@delacruz.com",
        "drivermobile": "09211111111"
    }
]
~~~~


</details>


<details><summary>Getting a driver's vehicles</summary>

## Getting a driver's vehicles:

### EXPECTED CLIENT
`Web Portal`
`Mobile App`

### ENDPOINT
`[website base address]/api/vehicle/get.php`

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
|401|Unauthorized|
|405|Method Not Allowed|
|500|Internal Server Error|

#### Response Body:
**Array of:**

|Member|Data Type|Comment|
|--|--|--|
|id |numeric||
|driverid|numeric||
|plateno|string||
|type|string||
|make|string||
|model|string||
|color|string||
|active|numeric|1 or 0. Indicates if the vehicle is currently driven by a driver on duty|
|available|numeric|1 or 0. Indicates if the vehicle is available for a trip request|
|locationlat|decimal|Current location - latitude|
|locationlong|decimal|Current location - longitude|

### SAMPLES

#### Sample Request:
~~~~
GET [website base address]/api/vehicle/get.php?driverid=1 HTTP/1.1 
~~~~

#### Sample Response:
~~~~
Access-Control-Allow-Methods: GET
Access-Control-Allow-Orgin: *
Connection: close
Content-Type: application/json; charset=UTF-8
Date: Wed, 28 Mar 2018 12:29:23 +0000
Status: 200

[
    {
        "id": 1,
        "driverid": 1,
        "plateno": "ABC123",
        "type": "Sedan",
        "make": "Toyota",
        "model": "Vios",
        "color": "Space Grey",
        "active": 1,
        "available": 1,
        "locationlat": 14.58899,
        "locationlong": 120.975238
    }
]
~~~~


</details>


<details><summary>Getting a driver's vehicles with driver details</summary>

## Getting a driver's vehicles with driver details:

### EXPECTED CLIENT
`Web Portal`
`Mobile App`

### ENDPOINT
`[website base address]/api/vehicle/getwithdriver.php`

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
|401|Unauthorized|
|405|Method Not Allowed|
|500|Internal Server Error|

#### Response Body:
**Array of:**

|Member|Data Type|Comment|
|--|--|--|
|id |numeric||
|driverid|numeric||
|plateno|string||
|type|string||
|make|string||
|model|string||
|color|string||
|active|numeric|1 or 0. Indicates if the vehicle is currently driven by a driver on duty|
|available|numeric|1 or 0. Indicates if the vehicle is available for a trip request|
|locationlat|decimal|Current location - latitude|
|locationlong|decimal|Current location - longitude|
|driverfirstname|string||
|driverlastname|string||
|driveremail|string||
|drivermobile|string||

### SAMPLES

#### Sample Request:
~~~~
GET [website base address]/api/vehicle/getwithdriver.php?driverid=1 HTTP/1.1 
~~~~

#### Sample Response:
~~~~
Access-Control-Allow-Methods: GET
Access-Control-Allow-Orgin: *
Connection: close
Content-Type: application/json; charset=UTF-8
Date: Wed, 28 Mar 2018 12:29:23 +0000
Status: 200

[
    {
        "id": 1,
        "driverid": 1,
        "plateno": "ABC123",
        "type": "Sedan",
        "make": "Toyota",
        "model": "Vios",
        "color": "Space Grey",
        "active": 1,
        "available": 1,
        "locationlat": 14.58899,
        "locationlong": 120.975238,
        "driverfirstname": "John",
        "driverlastname": "Doe",
        "driveremail": "john@delacruz.com",
        "drivermobile": "09211111111"
    }
]
~~~~


</details>


<details><summary>Getting vehicles within a point \ location and radius</summary>

## Getting vehicles within a point \ location and radius:

### EXPECTED CLIENT
`Web Portal`

### ENDPOINT
`[website base address]/api/vehicle/get.php`

### REQUEST DETAILS

#### Request Method:
`GET`

#### Request Parameter:
|Name|Description|
|--|--|
|sourcelat|Location point latitude|
|sourcelong|Location point longitude|
|radius|Location range in km|


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
|driverid|numeric||
|plateno|string||
|type|string||
|make|string||
|model|string||
|color|string||
|active|numeric|1 or 0. Indicates if the vehicle is currently driven by a driver on duty|
|available|numeric|1 or 0. Indicates if the vehicle is available for a trip request|
|locationlat|decimal|Current location - latitude|
|locationlong|decimal|Current location - longitude|

### SAMPLES

#### Sample Request:
~~~~
GET [website base address]/api/vehicle/get.php?sourcelat=14.598155&sourcelong=120.978736&radius=10 HTTP/1.1 
~~~~

#### Sample Response:
~~~~
Access-Control-Allow-Methods: GET
Access-Control-Allow-Orgin: *
Connection: close
Content-Type: application/json; charset=UTF-8
Date: Wed, 04 Apr 2018 14:21:13 +0000
Status: 200

[
    {
        "id": 1,
        "driverid": 1,
        "plateno": "ABC123",
        "type": "Sedan",
        "make": "Toyota",
        "model": "Vios",
        "color": "Space Grey",
        "active": 1,
        "available": 1,
        "locationlat": 14.58899,
        "locationlong": 120.975238
    }
]
~~~~


</details>


<details><summary>Getting vehicles with driver details within a point \ location and radius</summary>

## Getting vehicles with driver details within a point \ location and radius:

### EXPECTED CLIENT
`Web Portal`

### ENDPOINT
`[website base address]/api/vehicle/getwithdriver.php`

### REQUEST DETAILS

#### Request Method:
`GET`

#### Request Parameter:
|Name|Description|
|--|--|
|sourcelat|Location point latitude|
|sourcelong|Location point longitude|
|radius|Location range in km|


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
|driverid|numeric||
|plateno|string||
|type|string||
|make|string||
|model|string||
|color|string||
|active|numeric|1 or 0. Indicates if the vehicle is currently driven by a driver on duty|
|available|numeric|1 or 0. Indicates if the vehicle is available for a trip request|
|locationlat|decimal|Current location - latitude|
|locationlong|decimal|Current location - longitude|
|driverfirstname|string||
|driverlastname|string||
|driveremail|string||
|drivermobile|string||

### SAMPLES

#### Sample Request:
~~~~
GET [website base address]/api/vehicle/getwithdriver.php?sourcelat=14.598155&sourcelong=120.978736&radius=10 HTTP/1.1 
~~~~

#### Sample Response:
~~~~
Access-Control-Allow-Methods: GET
Access-Control-Allow-Orgin: *
Connection: close
Content-Type: application/json; charset=UTF-8
Date: Wed, 04 Apr 2018 14:21:13 +0000
Status: 200

[
    {
        "id": 1,
        "driverid": 1,
        "plateno": "ABC123",
        "type": "Sedan",
        "make": "Toyota",
        "model": "Vios",
        "color": "Space Grey",
        "active": 1,
        "available": 1,
        "locationlat": 14.58899,
        "locationlong": 120.975238,
        "driverfirstname": "John",
        "driverlastname": "Doe",
        "driveremail": "john@delacruz.com",
        "drivermobile": "09211111111"
    },
    {
        "id": 2,
        "driverid": 9,
        "plateno": "BLAH123",
        "type": "Van",
        "make": "Mercedes-Benz",
        "model": "Sprinter",
        "color": "Green",
        "active": 1,
        "available": 0,
        "locationlat": 14.526913,
        "locationlong": 121.033044,
        "driverfirstname": "Jojo",
        "driverlastname": "Sardez",
        "driveremail": "jojosardez@yahoo.com-old",
        "drivermobile": "0923212121"
    }
]
~~~~


</details>


<details><summary>Updating a vehicle</summary>

## Updating a vehicle:

### EXPECTED CLIENT
`Web Portal`

### ENDPOINT
`[website base address]/api/vehicle/update.php`

### REQUEST DETAILS

#### Request Method:
`POST`

#### Request Body:
|Member|Data Type|Comment|
|--|--|--|
|id|string|Vehicle's id|
|driverid|string||
|plateno|string||
|type|string|Values could be "Sedan", "Compact", "Van", "SUV", or "Limousine"|
|make|string||
|model|string||
|color|string||
|photo|string|base64 encoded string of the photo|

### RESPONSE DETAILS

#### Response Status Codes:
|Status|Description|
|--|--|
|200|OK|
|400|Bad Request|
|401|Unauthorized|
|404|Not Found|
|405|Method Not Allowed|
|500|Internal Server Error|

#### Response Body:
|Member|Data Type|Comment|
|--|--|--|
|message|string||
|id|numeric|The vehicle id. Present only if operation is successful|

### SAMPLES

#### Sample Request:
~~~~
POST [website base address]/api/vehicle/update.php HTTP/1.1
Content-Type: application/json

{
	"id": 1,
    "driverid": 1,
    "plateno": "ABC123",
    "type": "Sedan",
    "make": "Toyota",
    "model": "Vios",
    "color": "Space Grey",
    "photo": "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5p/DRQEgq4mfyrFoROwonB2ZBMkAo6NXoUCCGD8qCQklXGCPEStwikAZojo9WjyQmcqyAL0FCgBBG4nwlZsg3UjNTGjUmdz6aFoyElTiNU0ZGHgi6NGFo/7Rc/SiiDhEe4SpuLlaOJfYR7mj8MBvq+kcYxhsuj7cfgw+z1KQexxH57IDQOqCoWhsicdxH0aWTJYIzkOPtHR8rkfpBlFrpDc04+xJIam5y14MAyZKtsjp/sVb/Jy4DMY2oukDYjB5lHrKm5Axl0C7dQXZ9eoQz1ryjtXlHavKO1eUdq8o7V5R2ryjtXlHavKO1Su5ACdjVjSWoYiTq1OT1AJuYABnU0jHIL5TDuqlgTdAqZmcyCvCn4CkIG0YgTGsFcy7WM/e+0CLwDAPRLnKi3TW18x4lBQumHgq/hTONMGA0cjm/ISVcpGsPL1hGM8F3pb8WsBlERcWj7Q6dzXSaYb6eK2MoqZvOMDtQQAwAj+rf//aAAwDAQACAAMAAAAQ8888888888888888888888888888888888888888888888w08w484w88888880AMs888MQw88888k888888888cs088c0888888888848ssY0sMMMMM40488888888888888888888888888888888888888888888888888888888888888/8QAFBEBAAAAAAAAAAAAAAAAAAAAcP/aAAgBAwEBPxA0/8QAFBEBAAAAAAAAAAAAAAAAAAAAcP/aAAgBAgEBPxA0/8QAJxABAQABAwQBBAMBAQAAAAAAAREAITFBUXGBkWEQIDBAcKHw0fH/2gAIAQEAAT8Q/jW/vVFEgLbsRrWRrJsGBMi6IH40aOxxhUL/AJ8E9NvnQjW2z3b2D4YkIGSp14Vw5rM8DtzuafQSIVUA6ri98bIvRQNzdMRlxE1+eSTTu+MOKEQdzU/vAjW3+OcryrpA8rejHBwhq7Q9lykHF3ucSC8T3w0mAmtwtOyH4wkohRNk/NGoLJboEUAIjQmt+mzZSStF8IgS3Z6YtktVS1LMCGoympjh6igBVMAituS62iaL7CP/AFwggNlD1HPA4DAIDA8H3idVCoHcTnFTnqsp+U+/k4+tKBifEewDouHbUQoHZHn8oXoS2KiX40wtDcsJYC6Abc49SkBpVqvKruurikYIgUGUHwesn5GQkIiUTEOpGEeB73+coQrqWcVo8ZDKeAqMHVEk51/rDrEo1kMmot4mFjahROo/hJamw8NRa7i8F1TBfg0QCCTRQhTp+lM3MNHbw5SVksvIgduRxtRTQCvtHdwGSoLaIboy7J85oW9AV6U5+PtdsSaBTFtD0GBzRf2HOWKIp2PWheiZMDiytJfrcRHUEbov1dnP8vp+zArKMQWJaahG0+wwkwOaIeZMmjtQF1nNSdCBoH0EZvwYK8xMOUfP2yIkCfqJo/pBKQO2Tv1+4w2+oIAjojgygeVSMRoACQBGVC0b6lnWof3cvVFWIs9l1YXa64xqtz9H2bqPKXP1K6+cYmx8hOD5GIITtKNIoa0Xf8USJEiRIkSJEpnwppp+BCicaw1w+aLRsQrdTen1CtMOg1U9AMSlVClQGAFdmLWTA4ZQbTy5JPSN+6AVX4MvxMANwNgAaIg4lpQloCCgCQRFBQVBQ+2HQ+ihwBcFkjTWopNTB24Bp45GDwY3a9KHjq9DaeQyj51q6i6/XBVVAqwCZO/vJ395O/vJ395O/vJ395O/vJ395O/vIWzXJaFwhS/ZRGgURHDNK9NZMpCpvL8G2OsmHU1OQAYm0ElSiKC0CAAlaBNqvCN3HTPKjA7zGwVQgdgyfhlyT88On8ef/9k="
}
~~~~

#### Sample Response:
~~~~
Access-Control-Allow-Methods: POST
Access-Control-Allow-Orgin: *
Connection: close
Content-Type: application/json; charset=UTF-8
Date: Wed, 28 Mar 2018 11:51:56 +0000
Status: 200

{
    "message": "Vehicle updated.",
    "id": 1
}
~~~~


</details>


<details><summary>Updating vehicle's status</summary>

## Updating vehicle's status:

### EXPECTED CLIENT
`Mobile App`

### ENDPOINT
`[website base address]/api/vehicle/updatestatus.php`

### REQUEST DETAILS

#### Request Method:
`POST`

#### Request Body:
|Member|Data Type|Comment|
|--|--|--|
|id|numeric||
|active|numeric|1 or 0. Indicates if the vehicle is currently driven by a driver on duty|
|available|numeric|1 or 0. Indicates if the vehicle is available for a trip request|

Note: One or both of these status could be present in the requests.

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
Date: Wed, 28 Mar 2018 12:13:57 +0000
Status: 200

{
    "message": "Vehicle status updated.",
    "id": 1
}
~~~~


</details>


<details><summary>Setting vehicle's location</summary>

## Setting vehicle's location:

### EXPECTED CLIENT
`Mobile App`

### ENDPOINT
`[website base address]/api/vehicle/setlocation.php`

### REQUEST DETAILS

#### Request Method:
`POST`

#### Request Body:
|Member|Data Type|Comment|
|--|--|--|
|id|numeric||
|locationlat|decimal|Current location - latitude|
|locationlong|decimal|Current location - longitude|

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
POST [website base address]/api/driver/setlocation.php HTTP/1.1
Content-Type: application/json

{
	"id": 1,
	"locationlat": 14.588990,
	"locationlong": 120.975238
}
~~~~

#### Sample Response:
~~~~
Access-Control-Allow-Methods: POST
Access-Control-Allow-Orgin: *
Connection: close
Content-Type: application/json; charset=UTF-8
Date: Wed, 28 Mar 2018 12:29:15 +0000
Status: 200

{
    "message": "Vehicle location updated.",
    "id": 1
}
~~~~


</details>


<details><summary>Deleting a vehicle</summary>

## Deleting a vehicle:

### EXPECTED CLIENT
`Web Portal`

### ENDPOINT
`[website base address]/api/vehicle/delete.php`

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
POST [website base address]/api/vehicle/delete.php HTTP/1.1
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
Date: Wed, 28 Mar 2018 12:31:14 +0000
Status: 200

{
    "message": "Vehicle deleted.",
    "id": 1
}
~~~~


</details>
