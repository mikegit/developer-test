# AI Guidelines

- Please follow these guidelines in general:

## Basic app setup

- Include VueJs v3 via CDN
  - Will be using Compostion API style sintax, use Options API style, no node.js no file components.
  - Split components into separate .js files if needed
- Include fontawesome free ver via CDN, we'll use this for basic CRUD icons and fa-spin etc

## Javascript

- any non vuejs javascript or utilities classes should go in a sep. utilities class
    - such classes should use the "Object Literal pattern"

- use axios
    - setup like const http = axios.create();
    - http.defaults.headers.common['X-CSRF-TOKEN'] = token.content;


- use this as a standard for ajax
  - https://github.com/omniti-labs/jsend
  for example:
- success:
```json

{
"success": true,
"message": "User logged in successfully",
"data": { }
}
```

error:
    
```json

{
    "success": false,
    "message": "Invalid email or password",
    "error_code": 1308,
    "data": {}
}

```

- create a laravel helper to manage these server side responses.


## General

- dont try to create components if they are not really required.
- favour some duplication for the sake of clarity, favour readability
- dont comment code where obvious
- favour "Convention over Configuration"


## Database Follow Laravel guidelines where possible 

Also follow this;

    https://www.sqlstyle.guide/

    Uniform suffixes
    
        _id—a unique identifier such as a column that is a primary key.
        _status—flag value or some other status of any type such as publication_status.
        _total—the total or sum of a collection of values.
        _num—denotes the field contains any kind of number.
        _name—signifies a name such as first_name.
        _seq—contains a contiguous sequence of values.
        _date—denotes a column that contains the date of something.
        _tally—a count.
        _size—the size of something such as a file size or clothing.
        _addr—an address for the record could be physical or intangible such as ip_addr.


     https://rietta.com/blog/2012/03/03/best-data-types-for-currencymoney-in/
    DECIMAL(13,2)









