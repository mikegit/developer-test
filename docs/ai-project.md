

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

- Setup a PropertyController with all basic CRUD endpoints and typical Laravel validation
- Create the typical views for this

- create a link to this from the homepage after successful login.

#4 

Now we want to get a basic search going for the index view.
This will be later refactored to use vuejs  but for the moment lets get a basic first version working.

Within the CRUD index view, use Eloquent query to enable these search parameters

    Name: Should also match partial names
    Bedrooms: Exact match
    Bathrooms: Exact match
    Storeys: Exact match
    Garages: Exact match
    Price: Range (between $X and $Y) 

Keep it as simple as possible for now.


#5 Adding vuejs - upgrading basic app to use simepl vuejs v3


Lets create a new index view which will be an upgraded version fo our initial index list screen.

Call it list-enhanced


For the index view:
- Inlcude vue v3 via CDN and axios
- Within the index view setup the app as follows:

Include resources

```bladehtml

@push('scripts')
    <script src="{{ asset('js/vue-3.3.13/vue.global.js') }}"></script>
    <script src="{{ asset('js/vendor/axios.min.js') }}"></script>
    
    etc
```

Create app wrapper

- Add in some basic vue css for transistions and v-clock if not already exist, eg:


```bladehtml
 <div id="propertyApp" v-cloak></div>
```

Initial data can be passed to vue app like this

So serversite lets pass all view data vie appData.

Include all properties.  We'll assume the list is not going to be very large.


```bladehtml

<script>
    window.appData = @json($appData);
</script>


```

Setup vuejs according to ai-guidlines.md


#6

- Add in column sorting, use fa icon to show sort direction.  sorting should be clientside
- Show property price on both index views
- Right align price value, use a monotype font for currency
- Use fa-spin to add loading indicator to vue app
- Ensure 'Loading property list...; removed after loading is completed
- add basic vue transistions to improve UI.


#7

Now we are going to use the UI library:
https://element-plus.org/

We are going to:

- Use Vue (lightweight setup)
- eg
```javascript
    const app = Vue.createApp({});
  app.use(ElementPlus);
  app.mount('#app');

```

- refactor the index vue view to use these UI components.

#8

- revert the el-table widget in `index-vue` - appears to add unneeded complexity to teh codebase for the moment.












