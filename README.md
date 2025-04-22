# Online Market
## Description
This projects create a digital environment for where customer can sell their products and purchase products from other sellers. 

# Project Overview
### Technologies
- XAMPP (APACHE + PHP)
- MySQL (Database)
- [endroid/qr-code](https://github.com/endroid/qr-code) (Generate QR Code)
# Installation
### Dependencies
To install endroid/qr-code
```
composer require endroid/qr-code
```
### XAMP Configuration
Enables following extensionsL
- gd
- fileinfo
```
/XAMPP/php/php.ini
```
# Running Project
## Test Accounts
| Type | Username | Password |
| --- | --- | --- |
| Buyer | alice | 123 |
| Seller | bob | 234 |
 
## QR Code Scanning
To enable scanning feature with external phones, the project should be hosted publicly using **Ngrok**. 
### Hosting with Ngrok
1. Download [Ngrok](https://ngrok.com/downloads/) and install it
2. Start your Apache server in **XAMPP Control Panel**
3. Using the server's port in **Ngrok** conmmand line interface

```
ngrok http your-port
```
4. **Ngrok** returns a public URL that can be accessed by external devices.

## Scanning Flow
1. Open the website in your phone via provided URL from **Ngrok**.
2. Enter **Scanner** page in the navigation bar.
3. Using the scanner to scan the QR code in the checkout interface.
4. Upong scanning, the system simulate a banking transaction, create an order with selected products, and remove all the items in the cart.
