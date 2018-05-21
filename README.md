
``<VirtualHost *:80>
    ServerAdmin emailaddress@domain.com
    DocumentRoot "C:\wamp64\www\sondage"
    ServerName sondage.local
    ErrorLog "logs/sondage.log"
    CustomLog "logs/sondage-access.log" common
</VirtualHost>``