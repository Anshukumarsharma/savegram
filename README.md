# **SaveGram**
Have you ever saved an Instagram post and after a couple of days the owner of the post deleted the post? 

This bot will save all your saved post on a server so you wont lose it whenever the owner delete it. Just paste the Instagram URL in Telegram and its saved forever!

### **Composer**
``` bash
# Install composer
composer install

#Make storage folder accessible for public
php artisan storage:link

```

### **Telegram**
Please follow these steps if haven't created a bot on Telegram yet:
1. Open telegram and start [https://t.me/botfather]
2. Create a new bot `/newbot`
3. Enter all the following info.
4. After you finished you will receive a token.
5. Enter in you browser: `https://api.telegram.org/bot<token>/setWebhook?url=<your domain>]`. This will set up a webhook for your Telegram bot.



### **Configuration**
Rename the ``.env.example`` file to ``.env`` in the root of the api folder

Generate app key
``` bash 
php artisan key:generate

```

#### **Environment**
Insert the following credentials in your .env file. 
``` bash
APP_URL=
TELEGRAM_BOT_TOKEN=
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```



