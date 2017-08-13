rm -rf *.sql
rm -rf *.tar.gz
DATE="full-source-"`date +%Y-%m-%d`".sql"
TAR="full-source-"`date +%Y-%m-%d`".tar.gz"
mysqldump -uroot -proot em0144_everything > $DATE
tar -cvzf $TAR $DATE
rm -rf *.sql