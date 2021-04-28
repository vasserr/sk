###INSTALLATION

1) Clone the repo
2) Copy override file for docker-compose:<br>
   `cp docker-compose.override.example.yml docker-compose.override.yml`
3) Fill the build args for the app service.
4) Override the env file 
`cp .env .env.local` and do changes if needed
5) Up the docker-compose: <br>
`docker-compose up -d --build`
6) Go to `http://127.0.0.1:8080`
