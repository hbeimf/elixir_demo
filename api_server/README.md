mix new api_server --umbrella


mix release.init

dev:

mix release

prod:

MIX_ENV=prod mix release --env=prod --verbose

mkdir run 
cd run

 cp ../_build/prod/rel/api_server/releases/0.1.0/api_server.tar.gz ./

