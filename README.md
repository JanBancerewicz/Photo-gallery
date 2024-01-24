# Photo Gallery Website

A simple and customizable photo gallery website built using PHP.
Explore and share photos in a smart way.

## Features

- **User-friendly Interface:** Intuitive and easy-to-use interface for users to browse and view photos.
- **Responsive Design:** Ensures a seamless experience across various devices and screen sizes.
- **Upload Photos:** Users can upload their own photos to share with others.
- **Authentication:** Secure user authentication to protect user accounts and uploaded content.
- **Customization:** Easily customize the website's appearance and settings.

## Requirements

- [PHP](https://www.php.net/) (version 7.0.3 or higher)
- [MongoDB Server](https://www.mongodb.com/try/download/community)
- [Apache2](https://httpd.apache.org/download.cgi)
- [Composer](https://getcomposer.org/)

## Installation

1. Clone the repository:

   ```bash
   git clone https://github.com/JanBancerewicz/Photo-gallery.git
   ```

2. Update the database connection settings in config/config.php:

    ```
    define('MONGODB_URI', 'mongodb://localhost:27017');    
    ```

3. Install PHP dependencies using Composer:

    ```
    composer install
    ```

4. Start the Apache server and MongoDB.

5. Visit the website in your browser.

## License

This project is licensed under the MIT License.