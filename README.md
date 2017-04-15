## Simple loadbalancer with nginx and docker and docker-compose
just a poc how to scale nginx instances on a loadbalanced szenario.
- there are 2 nginx. One as loadbalancer with a dynamic proxypass And one as a webserver behind this reverse proxy


# prerequisites
- docker installed
- docke-compose installed (> 1.6)

# usage
docker-compose up -d
- ## scale a webserver: This adds a new frontnode on the fly without to restart or interrupt.
  docker-compose scale front1=3
  
- ## test getting a response:
  docker inspect loadbalancing_proxy_1
  take this ip and wget this ip
 
