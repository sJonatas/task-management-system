#!/bin/bash

cp ./.env.example ./.env
cp ./api/.env.example ./api/.env
cp ./app/.env.example ./app/.env

docker compose up