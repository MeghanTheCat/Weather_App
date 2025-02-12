# Import Weather Project from GIT

- Clone the project in a new folder  
  ```sh
  git clone {URL_WEATHER_APP_GIT}
  ```

- Enter the Weather_App base project folder  
  ```sh
  cd Weather_App
  ```

- Remove NTFS protect to import properly the whole folder  
  ```sh
  git config core.protectNTFS false
  ```

- Checkout on the master branch  
  ```sh
  git checkout master
  ```

- Proceed with normal procedure to start docker containers and php artisan serve. Don't forget to create a new database with php artisan migrate.
