#!/bin/sh

export $(cat .env | grep -v ^# | xargs)

DATE=$(date +"%Y%m%d-%H%M")
FILE=utils/backups/${REMOTE_DATABASE}-${DATE}.sql

echo 'Dumping SQL from remote...'
docker exec -i scoutbasketball-db mysqldump -u${REMOTE_USER} -p"${REMOTE_PASS}" -h${REMOTE_SERVER} -P3306 ${REMOTE_DATABASE} --column-statistics=0 > "${FILE}"
echo 'Dumped SQL'

echo 'Loading SQL to docker container...'
docker exec -i scoutbasketball-db mysql -u${DB_USERNAME} -p"${DB_PASSWORD}" ${DB_DATABASE} < "${FILE}"
echo 'Loaded SQL'

echo 'Compressing SQL...'
bzip2 -v -1 "${FILE}"
echo 'Compressed SQL'

echo 'Finish!'
