# Quick Demonstration
Please check this screen recording for a quick demo on how this application works in terms of search functionality and single-page application when clicking.

[![Watch the video](https://www.loom.com/share/07838f9133dd477fbac00a4671c60151)

# Video Code Explanation
1. https://www.loom.com/share/0c67848f6015428bb516641129d363c3
2. https://www.loom.com/share/bae3183a7a7f4d9fa38247998a637a8c

# Requirements
1. Create a Blog architecture.

    - Model requirements:

        - User

            - One-to-Many relationship with Post

        - Post

            - Many-to-Many relationship with Tags

        - Tags

            - Many-to-Many relationship with Post

    - Strict Model implementation with Eloquent

    <div style="color: green">
          <h4>The code for the migrations are in the `database/migrations`</h4>

        *_create_users_table.php, *_create_posts_table.php, *_create_tags_table.php, *_create_post_tag_table.php

    </div>

    <div style="color: green">
        <h4>The code for the migrations are in the `app/Models`</h4>

         Post.php, Tag.php, User.php

    </div>

2. Create Index search engine using Sphinx

   <div style="color: green">
        <h4>The code for the Search Engine logic</h4>

         app/ScoutEngines/SphinxEngine.php, app/Providers/SphinxSearchProvider.php, app/Http/Controllers/SearchController.php, sphinx.conf

    </div>

3. Use MySQL 8.0 with Sphinx engine

    <div style="color: green">
        <h4>The code for the MySQL 8.0 with Sphinx engine</h4>

         .env, config/database.php, config/scout.php, config/sphinx.php, config/database.php

    </div>

4. Build Service Provider and integrate Sphinx search on Post

   <div style="color: green">
        <h4>The code for the Service Provider and Sphinx search on Post</h4>

        app/Providers/SphinxSearchProvider.php, app/Models/Post.php, app/ScoutEngines/SphinxEngine.php, app/Http/Controller/SearchController.php, app/Repositories/PostRepository.php, app/Repositories/PostRepositoryInterface.php, config/scout.php, sphinx.conf
    </div>

5. Manage all CUD (Create, Update, Delete) via Service Container Repository

    <div style="color: green">
        <h4>The code for the Service Container Repository</h4>

        app/Repositories/PostRepository.php, app/Repositories/PostRepositoryInterface.php

    </div>
6. Apply database sharding on Post considering that data will grow fast

    <div style="color: green">
        <h4>The code for the database sharding on Post</h4>

        app/config/sharding.php, app/Providers/ShardingServiceProvider.php, app/Models/Post.php

    </div>
7. Apply RESTful API versioning in semver pattern
        
    <div style="color: green">
        <h4>The code for the RESTful API versioning in semver pattern</h4>

        app/Http/Controllers/Api/V1/PostController.php, app/Http/Controllers/Api/V2/PostController.php

    </div>
8. Apply Redis-Cache for search

    <div style="color: green">
        <h4>The code for the Redis-Cache for search result</h4>

        app/Providers/CacheServiceProvider.php, app/Http/Controllers/SearchController.php, .env

    </div>

9. Use Vuejs on Front-end work creating Single Page Application

    <div style="color: green">
        <h4>The code for the Vuejs on Front-end work creating Single Page Application</h4>

        resources/js/app.js, resources/js/components/AllPostsComponent.vue,    resources/js/router.js, resources/js/components/SearchComponent.vue, vite.config.js, resources/views/home.blade.php
     </div>

# Installation
To install the project, follow these steps:

1. Clone the repository:
    ```bash
    git clone https://github.com/davesuy/health-advance-institute.git
    cd health-advance-institute
    ```

2. Install dependencies:
    ```bash
    composer install
    npm install
    ```

3. Set up the environment variables:
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. Run the migrations:
    ```bash
    php artisan migrate
    ```

# Usage
To start the application, use the following command:
```bash
npm run dev
php artisan serve
