## Simple loadbalancer with nginx and docker and docker-compose
just a poc how to scale nginx instances on a loadbalanced szenario.
- there are 2 nginx. One as loadbalancer with a dynamic proxypass And one as a webserver behind this reverse proxy


# prerequisites
- docker installed
- docke-compose installed (> 1.6)

# usage
docker-compose up -d
- ## scale a webserver:
  docker-compose scale front1=3
