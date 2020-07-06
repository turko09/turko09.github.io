# Admin API
Admin API contains operations for manipulating administrator information including registering a new one, getting an administrator, and updating them.


<details><summary>Registering a new administrator</summary>

## Registering a new administrator:

### EXPECTED CLIENT
`Web Portal`

### ENDPOINT
`[website base address]/api/admin/register.php`

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
|id|numeric|Present only if operation is successful|

### SAMPLES

#### Sample Request:
~~~~
POST [website base address]/api/admin/register.php HTTP/1.1
Content-Type: application/json

{
    "firstname": "Juan",
    "lastname": "Dela Cruz",
    "email": "juan@delacruz.com",
    "password": "meh",
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
Location: /api/admin/get.php?id=1
Status: 201

{
    "message": "Administrator registered.",
    "id": 1
}
~~~~

</details>


<details><summary>Getting an Administrator (Detailed Response)</summary>

## Getting an Administrator (Detailed Response):

### EXPECTED CLIENT
`Web Portal`

### ENDPOINT
`[website base address]/api/admin/get.php`

### REQUEST DETAILS

#### Request Method:
`GET`

#### Request Parameter:
|Name|Description|
|--|--|
|id|Id of the administrator|

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
|mobile|string||
|active|numeric|1 or 0|
|photo|string|base64 encoded string of the photo|
|datecreated|datetime||
|datemodified|datetime||

### SAMPLES

#### Sample Request:
~~~~
GET [website base address]/api/admin/get.php?id=1 HTTP/1.1 
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
    "mobile": "09200000000",
    "active": 0,
    "photo": "/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBw8QDw0PDxAPDRANDw4QDw4PEA8NDw8SFRIWFhUXFRYYHSkgGBolGxYVIjIhJjUrLi4uFx8zODMsNygtLi0BCgoKDg0OGhAQGy0mHSUvLSsrMi8rLS0tLi4tLS0tLS0tLS0tLy0tLSstLS0rKy0tLS0tLS0vLS0tLisrLTctLf/AABEIAOEA4QMBIgACEQEDEQH/xAAcAAEAAQUBAQAAAAAAAAAAAAAABQIDBAYHAQj/xAA8EAACAgEBBAcECAQHAQAAAAAAAQIDBBEFEiExBhNBUWFxgQciobEUMkJSU5HB0SMzgpJDVGJjcpPCJP/EABoBAQACAwEAAAAAAAAAAAAAAAACAwEEBQb/xAAjEQEAAgICAgICAwAAAAAAAAAAAQIDEQQSITFBUQVhEyIy/9oADAMBAAIRAxEAPwDuIAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAC1k5EK4SnZKMIQWspSajFLxZzvpD7WMepuGJW8mS4dZNuupeS5y+HmQvkrT3KVaTb06RqebxwLO9p+1LG92cKV3V1xjp6vV/Ej3072r/mrfzKZ5VfqVn8M/b6N3j3U+esb2jbVg/5+/wCE4wn80bTsT2ty1Ucyhafi06xa84NvX0a8jMcmk+/DE4bOugi9k7Zoya1bRZGyD7U+Kfc12MkoyL4nfpUqABkAAAAAAAAAAAAAAAAAAAAAAAADG2jnV49Vl10lCuqLlKT7vDvfgZJyX2sbbdt0cGD9yhRndp9qxrWMX5Lj6oqzZYx0myeOne2mrdMOluRtGx6t1Y8X/DoT5Lvn3y+RrXUmf1Jn4WBBrektdeS7DkTkm07lvdYiED1Q6o22NUVyjFeSSKml3L8jO/2NR6kdSbTPGrfOEfy0ZiX7Njzhw8HxMTMmmN0f2zfhWq2mT04b9b+pZHuf79h3TYG2q8qmu6t+7NcnzjJc4vxTOD9SbT7PtqvHyeok/wCHk/VXZGxL9V8i/i8jVus+pV5se438u1QlqVmDiW6majqtJ6AAAAAAAAAAAAAAAAAAAAAAACi2ainJ8FFNt+C4s+e7rZX2XZEvrZFtlr17N6TaXklwO49K8jq8HNny0x7dPNxa/U4xjUaQrXdGPyOV+Tya6w3eJXe5W9m7KvybHVj19ZKKTnJvchBPlvMlbuim06I7zpjbFcXGmxWSXo0vgbj7NsVQwVbp72VZZY33rXdj8EbVqc3trwnbJO/DiVV6k2uMZRekoSTjKL7mnyLp0vpH0Xx8xbzXU3x+rkVpKflL7y8zScrortGp6KmOUuydU4Qb84za0+JnvPwnW1Z9okx7s2uHCUkvU2nZPQrJvknl/wDy1LnVCUZXT8G1wivLU3rZmx8bGio0U11d8lFb8vOXNjt9sWvWPTicLq5t7sott8kyq2MoJWQ4SqanF+MXqdo2zsXHy65QurjLVe7Zousg+xxlzRyeWJKE78ezjZjzlVJ/eX2ZeqaZGba/tCdLRfw6tsTMVldVi5WQhNeUlqvmT9bNE6BXN4WL4QlH0jOUV8jeMd8D01J3WJcu0amYXwASYAAAAAAAAAAAAAAAAAAAAAGt+0KWmy8/T8H/ANROX5s1Cqcu6LUfFtaI650txXdg5lUeLnRZou9papfA5T0YrWXdVJ/y8VV2Si/t2ae6tO5P5HF/K1/tWfhvcS2qy6HsCp0YuNS+DrqhGXhLTWXx1JJWkX1pVG84sZJ+U5qk+tPVaRyvKlcT7o9Uh1h71hHq4964z3Y6pDfRzzpxQqs+Fy4RyqNJf86u3+1xX9Juf0g1D2jxc6Mdx42deowXbLfi4tfEzW3aev2nSOs7Z/QOLWFjJ9sZv0lOTXzN7xuRq+wsZV11VrlXCEF/THQ2nGXA9bSNViHPtO5mWQACTAAAAAAAAAAAAAAAAAAAAAAosRz3a+PHG2lHcjGuGTi6JRSjHerm2+C7Wp/A6IzT/aHhy+jwyq1rPBsV2i5yr5WL+1mrzMX8mG1VuG2rwxVae9aR1WSpJSi9YySafenyK1aeS06Omf1p6rTA60960Gmf1p71pgK09VoNM/rSFz59dnY1S4rGhO+fhKXuQ/8ARlyvSTbeiSbb7kjD6K1ux3Zclo8qzWCfNVQ92H56anQ/G4e+aJ+I8qc09aNu2bXyJ2qPAj8CvkScUenc9UAAAAAAAAAAAAAAAAAAAAAAAAY+TWpRcWlJSTTT4pp8GmXrJqKbk1FRTbbeiSXazkfS/p9blOePs6Tpx03GzNXCd3eqe6PZvdvYQveKRuUbXisblYhKGLk3YHWRmqnrS1JSahLioS/1IzlaaLDEjFaR1i097f11nvd7fNslcXbUo6RuTen+JBap+a7DzXJwbtNqR4b3F5lMkdbeJbN1pV1pEU7Rql9WcX6pMyFd3PU0piY9t/SQ60960jLMyEVrKUY+bREZ/SDg40cX+I1wXku1kqY7WnxCF71pG7TpJbX2jXOyvDdsauta62cpKOkee6v9TN62XRFKMYpKMUlFLlolw0OJ21qWu/7+9xblx1ZK7A6S5eA0oN5NCfvY9knvRX+3Ps8nqju8G1MNes+5+XFy82uS/wCvh3zFjwMpGs9FulGNnV79E+Mf5lU/dtrfdKP68jY4T1OtE7SidrgAAAAAAAAAAAAAAAAAAAAAUzkkm20klq2+CS8SpnMPaJ0gnk3S2ViyahDd+nWxejevFUxa7fvPs5eUbWisblG1orG0X0x6T2bTsljY0pRwK5NTnHWLy5J8dH+Evj5EQsNQSSS4LRaLRLyJjHwI1QjCKS0SXDglp2LwLN1Rz8kzady1LzNp3KFsrLMokjfUYsoFEwqmEbm0txbilvx0lHVcJNPXR+D5ep1zYPRfY+di4+VDGSV0IyahdkVqMuUo6Rn2PVaHMJRNx9kG1+rvydnTfu2J5WNr2cUroL1alp4yL+N1metohs8fLaJ67Y3tV2NhYdWBVjUwptyMmUpSTlObqrre+tZNvTenX+RpDRtXtPz/AKRtVwT1hgUKvw62x70/XRRXoavJEOTrvqPhXyLza/laaKWXGihms11NFttNkb8eyVF0Pq2R7fCS5SXgzr/QbppHOg4WJU5VS/i1J8JL78NecX8DkDKYWWVzhdRN1XUvermvk++L5NGxgzzSdT6W4ss1nz6fS9VmpeNR6HdI4ZuPC5e7L6ttfbXYuaNqrnqdWJ35dCJ2uAAyAAAAAAAAAAAAAAAAIDpvtx4OFbdDjbLdqoj962b3Y/lz9Dn/AEa2T1de9Juc5OUp2PjKyyXGcn6k57VtVLZU56qiGTPfl9mNkq3Gty7lxkte9ovYcIuuCj2JJ+D7TWy+baUZPNtI+2owrqibtqMK6opmFcwgb6jAtgTt9RG5FZTaFcwjZxMf6fPEux82tayxLN7Tlvwkt2cX4NP4GdOJj2RIRPWdoxOp2woznY7LrONmRZO6zXi9ZPXT0Wi9DySMiSLMkQtO52jPmdrMkUNF2SLbIorbKWVspZhhN9AtqvFz4Qb0qzv4cl2K1L+G/X6vqjuGHbqj5uum4uqUfrwuplDTm5Kaa0PoTZ8zqcS0zTU/De49t10nEz0orfArNpsAAAAAAAAAAAAAAAAI/bOz6smmyi6Csrti4yi+1fo/E5pkYuZsqT1Vmbhr6t0E7MiiPdbH7cV95ep1mSMS/H1I2pFkbViWkbP2vj5MFOqyE12uL10fc1zi/Bl26vu4le2eheNbN2xjLGuf+Njy6mb89OEvUhLtj7Vo16q6nMivs3J0W/3R91v0RTbHZXNJZGRURmTWU27UzIfz9n5UO+VSryo+fuPgYNnSPGfCTnW+6ym6Gnq46Gvas/Sq0KbYGNNHtm18V8r6V52Ri/iWLM+j8ar/ALIfuUTCqYUzRYkj2zOp/Fq/vj+5jz2hR2Wwf/F73yIalHSqSLcimOSpPSuF1r7oVWS/QzKNkZ9v8vDtivvXyhQl6N6/kZjFefUEUtPqGEyzbdGOi4uT4RhFb05PuSXFm14XQPIno8jIjWu2GOtX/fL9jbtidFcbG41VLffOyXv2P+p8S+nDtP8Arwtrx5n21Toh0TsdteVlx3OralTjvi4y7Jz8V2LsOp7Pr5FvGwiVx6NDfpSKRqG3WsVjUMitcC4eJHpNIAAAAAAAAAAAAAAAAPGj0AWZ1JmNZipmeeaARE8HwMa7ZylwaUl3NJon3EpdaA1WzYFD50Uvzrh+xjS6MYv+Wp/64m5dUil0IDTY9GsZPVY9PD/bh+xk1bDqXKmpeVcF+hs/0dFSpQEDDA04JaLuRdhgeBN9Uj1VoCKrwfAyq8VIzVE90AtQqSLqR6AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA//2Q==",
    "datecreated": "2018-03-25 11:14:22",
    "datemodified": "2018-03-25 11:14:22"
}
~~~~

</details>


<details><summary>Getting Administrator list</summary>

## Getting Administrator list:

### EXPECTED CLIENT
`Web Portal`

### ENDPOINT
`[website base address]/api/admin/get.php`

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


### SAMPLES

#### Sample Request:
~~~~
GET [website base address]/api/admin/get.php HTTP/1.1 
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
    },
    {
        "id": 8,
        "firstname": "John",
        "lastname": "Doe",
        "email": "john@delacruz.com",
        "mobile": "09211111111",
        "active": 0,
    }
]
~~~~

</details>


<details><summary>Updating an Administrator</summary>

## Updating an Administrator:

### EXPECTED CLIENT
`Web Portal`

### ENDPOINT
`[website base address]/api/admin/update.php`

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
POST [website base address]/api/admin/update.php HTTP/1.1
Content-Type: application/json

{
    "id": 1,
    "firstname": "John",
    "lastname": "Doe",
    "email": "john@delacruz.com",
    "password": "meh",
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
    "message": "Administrator updated.",
    "id": 1
}
~~~~

</details>


<details><summary>Authenticating an Administrator's credentials</summary>

## Authenticating an Administrator's credentials:

### EXPECTED CLIENT
`Web Portal`

### ENDPOINT
`[website base address]/api/admin/authenticate.php`

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
|id|numeric|Administrator's id. Present only if operation is successful|

### SAMPLES

#### Sample Request:
~~~~
POST [website base address]/api/admin/authenticate.php HTTP/1.1
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
