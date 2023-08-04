<p align="center">
  <img src="https://user-images.githubusercontent.com/7081446/223246488-77debf08-5f0b-47da-b15b-a51b6038352f.png" width="128" height="128"/>
</p>
<p align="center"></p>
<h1 align="center">Midjourney API client for PHP</h1>

![Midjourney Splash](/.github/images/splash.png)

<a href="https://www.buymeacoffee.com/shuch3n" target="_blank">
    <img width="100" alt="yellow-button" src="https://user-images.githubusercontent.com/7081446/223840887-a22159f2-4830-44d5-ad68-98eaea370e66.png">
</a>

![](https://img.shields.io/packagist/dt/ediasoft/midjourney-api-php)
![](https://img.shields.io/packagist/v/ediasoft/midjourney-api-php)
![](https://img.shields.io/packagist/l/ediasoft/midjourney-api-php)

<p>
The Midjourney PHP API Client Package is a comprehensive library that allows developers to interact with the Midjourney API through Discord. Midjourney is an AI platform that can generate image base your prompt.

This PHP API client package aims to simplify the integration of the Midjourney API into your PHP applications, enabling you to access the powerful features of the Midjourney platform seamlessly.
</p>

## Features
- **Imagine:** Create a image base your given prompt. This will return four different options to choose from.
- **Upscale:** Get the full size of the generated image.

### Upcoming release
- **Blend:** Able to blend two or more images together.
- **Describe** It will generate four possible prompt base up the given image.
- **Shorten** Analyze your prompt and highlights and it wil suggests unnecessary words you could remove. 


## Installation

You can install the Midjourney PHP API Client Package using Composer. Run the following command:

`composer require ediasoft/midjourney-api-php`

## Usage

### Basic usage

Create a MidjourneyApiClient object with valid credentials and you will be able to access all the available commands. See the Imagine command down below:

```php
use use eDiasoft\Midjourney\MidjourneyApiClient;;

$channel_id = 000;
$authorization = "AUTH_TOKEN";

$midjourney = new MidjourneyApiClient($channel_id, $authorization);

$result = $midjourney->imagine('Elephant riding on a snake')->send();

return $result;
```

### Constructor
- `$channel_id` - Go to your discord channels and right click on the channel where the Midjourney Bot is active on. Click on **Copy Channel ID** (If you don't see this menu option you have to enable developer mode.)
  ![Discord User Token](/.github/images/discord_developer_mode.png)
- `$authorization` - Automatic user accounts (self-bots) are not allowed by Discord and can result in an account termination if found, so use it at your own risk.

  To get your user token, visit [https://discord.com/channels/@me](https://discord.com/channels/@me) and open the **Network** tab inside the **Developers Tools**. Find between your XHR requests the `Authorization` header.

