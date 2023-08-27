# Buzzvel
## Tasks App
### What was not implemented
- Authentication (User identification);

### What was implemented
- List, Create, Update and Delete tasks;
- Optional single image upload on Create and Update methods;
- Completed datetime column;
- Soft delete;
- Docker;
- Unit Tests;
- Error handling;

### Application Config
The file docker-compose.yml works with two services.
mariadb for mysql database, and myapp with laravel instance.
When application run, it uses port 8000.

### Executing
In the project folder (the folder tha contains the docker-compose.yml file) start the containers.

```sh
docker compose up
```

Once application is running, you can access Laravel environment and execute migrations:

```sh
docker compose exec container_name php artisan migrate
```
With database configured, you can access application api and manage tasks.

#### Managing Tasks
The task object needs for following parameters:

`title - string`: Title of task;
`description - string`: Task description;
`user - string`: Name of current user (auth not implemented);
`image - File`: Image file for attach; `(Optional)`

On task update action, attribute `completed` can be setted as optional:

`completed - boolean`: If task was completed;

#### Endpoints
`POST - api/tasks`
`PUT - api/tasks/{id}`
`DELETE - api/tasks/{id}`
`GET - api/tasks`
`GET - api/task/{id}`

#### Headers
All methods must set header `Accept: application/json`;
`POST` and `PUT` methods must set header: `Content-Type: multipart/form-data` when image files was included in the body. If not, includes header `application/x-www-form-urlencoded`.

#### Unit tests
The unit tests can be executed with following command:
`docker compose exec container_name php artisan test`;

#### Example code
```sh
curl --request POST \
  --url http://localhost:8000/api/tasks \
  --header 'Accept: application/json' \
  --header 'Content-Type: application/x-www-form-urlencoded' \
  --form 'title=Send test to buzzvel' \
  --form 'description=With docker' \
  --form user=tester
```

## License
MIT
