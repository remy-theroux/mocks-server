#!/bin/bash
docker build . -t remy-theroux/requests-stubs:behat
docker stop $(docker ps -aqf "name=behat_requests_stubs")
docker run -d --rm --name behat_mocks_server -p 9000:9000 remy-theroux/requests-stubs:behat
vendor/bin/behat
docker stop behat_requests_stubs