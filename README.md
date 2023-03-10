# Avatar Module

A Magento 2 module for displaying customer avatars.

## Installation

1. Install the module via Composer by running the following command in Magento 2 root directory:

    ```bash
    composer require kamephis/magento2-avatar
    ```

2. Enable the module by running the following command in Magento 2 root directory:

    ```bash
    php bin/magento module:enable Kamephis_Avatar
    ```

3. Run the following command in Magento 2 root directory:

    ```bash
    php bin/magento setup:upgrade
    ```

4. Clear the cache by running the following command in Magento 2 root directory:

    ```bash
    php bin/magento cache:clean
    ```

## Usage

The Avatar block can be added to any template file by using the following code:

```xml
<block class="Kamephis\Avatar\Block\Avatar" name="customer.avatar" template="Kamephis_Avatar::avatar.phtml"/>
```

Then, you can call the getAvatarHtml() method to get the HTML code for the customer's avatar:

```php
echo $block->getAvatarHtml();
```

## Configuration

To configure the Avatar module, go to Stores > Configuration > Kamephis > Avatar in the Magento 2 Admin Panel. Here, you can choose the type of avatar to display (Gravatar or Robohash) and the default size of the avatar in pixels.

## License

This module is licensed under the MIT License.
