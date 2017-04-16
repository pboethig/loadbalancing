## Simple loadbalancer with nginx and docker and docker-compose
just a poc how to scale nginx instances on a loadbalanced szenario.
- there are 2 nginx. One as loadbalancer with a dynamic proxypass And one as a webserver behind this reverse proxy


# prerequisites
- docker installed
- docker-compose installed (> 1.6)

# usage
```sh
 docker-compose up -d
 ```
- ## scale a webserver: This adds a new frontnode on the fly without to restart or interrupt.
```sh  
 docker-compose scale php70=3
 docker-compose scale nginx_frontend=3
```    
  
- ## test getting a response:
```sh
docker inspect loadbalancing_proxy_1
```
take this ip and 
```sh
php test.php 10000 <proxyIP> 10
  ```
  
this creates 10 runs with 100000 requests
 
