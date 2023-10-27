# Burrow

Burrow is an open source online platform for real estate, hotel, vacation rental, room sharing and accommodation booking,etc that is capable to run sites similar to airbnb, finder, airbnb clones, etc. It can also be used for similar business models such as car pooling, bike sharing, or any sharing marketplace website.

For historical reasons, Burrow is from [Agriya Labs](http://labs.agriya.com/burrow) and Airbnb adopted many features originally introduced in Burrow, including its latest design theme.

> This is project is part of Agriya Open Source efforts. Burrow was originally a paid script and was selling around 12000 Euros. It is now released under dual license (OSL 3.0 & Commercial) for open source community benefits.

![burrow_banner](https://user-images.githubusercontent.com/4700341/48258940-719bb280-e43c-11e8-998d-4d7aedda4933.png)

## Support

Burrow is an open source online platform for vacation rental and accommodation booking project. Full commercial support (commercial license, customization, training, etc) are available through [ReserveLogic platform support](https://www.iscripts.com/reservelogic/)

Theming partner [CSSilize for design and HTML conversions](http://cssilize.com/)

## Features

### Site

Ability to search properties in popular cities. Cities will display depending upon the properties count.

### Multi-Language Support

Translation of front end with multilingual support. Site visitors can translate any webpage by click the drop-down box beside language.

### Negotiation

Burrow has negotiation workflow when negotiation is enabled by host. Traveler will contact host for negotiation in property view page. Host can able to give discount for booking in activities page.

### Ticket

Ticket will be available for traveler after host confirmed his booking. Payment release is not based on ticket, but it can be used to check authenticity of the traveler, host's address, policies, instructions, etc.

### Payment

Multiple payment gateway can be enabled using SudoPay account and Wallet.

### Property video

Here we can post video for property. Ability to post photos and videos by visited guests for other guests. This will help new traveler to get better understanding about the property.

### Affiliate

User can associate/refer our site to a different network thereby referred user can earn commission.

## Getting Started

### Prerequisites

#### For deployment

* MySQL
* PHP >= 5.5.9 with OpenSSL, PDO, Mbstring and cURL extensions
* Nginx (preferred) or Apache

### Setup

* Needs writable permission for `/tmp/` , `/media/` and `/webroot/` folders found within project path
* Database schema 'app/Config/Schema/sql/burrow_with_empty_data.sql'
* Cron with below:
```bash
# Common
*/2 * * * * /{$absolute_project_path}/app/Console/Command/cron.sh 1 >> /{$absolute_project_path}/app/tmp/error.log 2 >> /{$absolute_project_path}/app/tmp/error.log
```

### Contributing

Our approach is similar to Magento. If anything is not clear, please [contact us](https://www.agriya.com/contact).

All Submissions you make to Burrow through GitHub are subject to the following terms and conditions:

* You grant Agriya a perpetual, worldwide, non-exclusive, no charge, royalty free, irrevocable license under your applicable copyrights and patents to reproduce, prepare derivative works of, display, publicly perform, sublicense and distribute any feedback, ideas, code, or other information ("Submission") you submit through GitHub.
* Your Submission is an original work of authorship and you are the owner or are legally entitled to grant the license stated above.


### License

Copyright (c) 2014-2019 [Agriya](https://www.agriya.com/).

Dual License (OSL 3.0 & [Commercial License](https://www.agriya.com/contact))
