

#1 - Basic

Create simple migration for admin user login
- Create a password value which is taken from the .env called SETUP_PASS, add this to laravel config

Add basic auth for this to middleware to protect all app routes except login
- Place all new routes in `Route::middleware(['auth','verified'` etc


#2 - Basic app

Create a new laravel migration for this csv data;

- Call the model `Property`
- Also add in a decinmal type attributes called `price`
- Also add in a `is_test` boolean attribute, to indicate this is test generated data

```csv

Name,Price,Bedrooms,Bathrooms,Storeys,Garages
The Victoria,374662,4,2,2,2
The Xavier,513268,4,2,1,2
The Como,454990,4,3,2,3
The Aspen,384356,4,2,2,2
The Lucretia,572002,4,3,2,2
The Toorak,521951,5,2,1,2
The Skyscape,263604,3,2,2,2
The Clifton,386103,3,2,1,1
The Geneva,390600,4,3,2,2

```

- Use Faker to generate some seeders
  - Ensure the test data is marked as `is_test` = true


#3 - Basic serverside

- Setup a PropertyController with all basic CRUD endpoints
- Create the typical views for this


