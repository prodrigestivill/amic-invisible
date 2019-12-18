#!/bin/sh -e
BUILD_TAG="php:cli-smtp"

cd $(dirname "$0")
docker build -t "$BUILD_TAG" -f php-cli-smtp.Dockerfile .
exec docker run --tty --interactive --rm=true --volume="$PWD":/src --network=host --workdir /src --entrypoint php "$BUILD_TAG" $@
