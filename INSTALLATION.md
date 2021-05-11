###INSTALLATION

1) Clone the repo
2) Copy override file for docker-compose:<br>
   `cp docker-compose.override.example.yml docker-compose.override.yml`
3) Fill the build args for the app service.
4) Override the env file 
`cp .env .env.local` and do changes if needed
5) Up the docker-compose: <br>
`docker-compose up -d --build`
6) install dependencies (inside container) `./bin/dcomposer install`
7) Run migrations (inside container) `./bin/dconsole d:m:m`
) Load fixtures (inside container) `./bin/dconsole d:f:l`
9) Go to `http://127.0.0.1:8080`

#### CS FIXER INSTALLATION
1) ` ./bin/dcomposer install -d ./tools/php-cs-fixer`
2) Use it inside a docker container: `./bin/csfixer ...`

#### TESTS RUNNING
1. Create a test database: `./bin/dconsole d:d:c --env=test`
2. Run migrations for the test db: `./bin/dconsole d:m:m --env=test`
3. Load fixtures: `./bin/dconsole d:f:l --env=test`