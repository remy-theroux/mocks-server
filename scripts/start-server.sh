#!/bin/bash
docker build . -t remy-theroux/mocks-server:behat
docker stop $(docker ps -aqf "name=behat_mocks_server")
docker run -d --rm --name behat_mocks_server -p 9000:9000 remy-theroux/mocks-server:behat