<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">"Points" payment gateway</h1>
    <br>
</p>

### [look demo app](http://points-payment-gateway.kvushco.xyz/)

Test task for the implementation of a simple system of translations of conventional units between users
based on Yii 2 Basic Project Template is a skeleton [Yii 2](http://www.yiiframework.com/) 

The user for authorization / registration can use only a unique nickname without a password. If there is no such user, then create it automatically and authorize. A public page with a list of all users and their current balance, available without authorization, should be made.

For authorized users:

The user can transfer any positive amount to another user (identification by nickname). In this case, the user's balance is reduced by the specified amount. The balance can be negative. The balance can not become less than -1000. The balance for all new users is 0 by default. You can transfer any amount (with two decimal places for cents) to any nickname, even fictitious, if such a nickname does not exist in the database, then we create this user automatically and credit the transfer amount. The user can not make the transfer himself.

Users can see all translations related to their balance in their office in the form of a translation history.


REQUIREMENTS
------------

The minimum requirement by this project template that your Web server supports PHP 5.4.0.


INSTALLATION
------------

### clone or download

Download ZIP of this repository or 
You can run following command:

~~~
git clone https://github.com/kvush/points-payment-gateway.git PaymentGateway
~~~

Next you have to run following command from PaymentGateway folder

~~~
composer install
~~~

And finally update database schema

~~~
php yii migrate/up
~~~
