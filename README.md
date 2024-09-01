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
use eDiasoft\Midjourney\MidjourneyApiClient;

$channel_id = 00000000;
$authorization = "AUTH_TOKEN";

$midjourney = new MidjourneyApiClient($channel_id, $authorization);

$result = $midjourney->imagine('Elephant and a snake romantically having a diner')->send();

return $result;
```

### Constructor
- `$channel_id` - Go to your discord channels and right click on the channel where the Midjourney Bot is active on. Click on **Copy Channel ID**
  ![Copy Channel ID](/.github/images/copy_channel_id.png)

  If you don't see this menu option you have to enable developer mode. Go to User Settings > Advanced (Under APP Settings) > Developer Mode (Enabled)

  ![Discord User Token](/.github/images/discord_developer_mode.png)

- `$authorization` - **Caution:** Discord strictly prohibits the use of automatic user accounts, also known as self-bots. Engaging in such activities can lead to the termination of your Discord account if detected. Therefore, we strongly advise against using self-bots to avoid any potential risks and consequences. Please be mindful of Discord's terms of service and use the platform responsibly and within its allowed guidelines.

  To get your user token, go to [https://discord.com/channels/@me](https://discord.com/channels/@me) and open the **Network** tab inside the **Developers Tools** by pressing op F12. Locate the calls that is directing to the Discord API such as `friend-suggestions` and open the Request Headers tab and locate the `Authorization` and copy this value.

  ![Discord User Token](/.github/images/authorization_header.jpg)

### Commands

#### Imagine

```php
$imagine_builder = $midjourney->imagine('Elephant and a snake romantically having a diner'); //Returns a Builder object
```
##### Parameters

```php
$imagine_builder->aspectRatio('16:9') //Changing the aspect ratio.
                ->chaos(30) //The higher the chaos the more unusual and unexpected results.
                ->fast() //Enable fast mode for this single job.
                ->imageWeight(1.75) //Sets image prompt weight relative to text weight. The default value is 1.
                ->no('moon roses') //Exclude specific object in the image.
                ->quality(0.5)
                ->relax() //This will turn on relax mode for this single job, the interval of retrieving the image will be also delayed. 
                ->repeat(40) //Create multiple Jobs from a single prompt.
                ->seed(1000) //The Midjourney bot uses a seed number to create a field of visual noise, like television static, as a starting point to generate the initial image grids.
                ->stop(35) //Stopping a Job at an earlier percentage can create blurrier, less detailed results.
                ->style('cute')
                ->stylize(5) //Influences how strongly Midjourney's default aesthetic style is applied
                ->tile() //Generates images that can be used as repeating tiles to create seamless patterns.
                ->turbo() //Override your current setting and run a single job using Turbo Mode.
                ->weird(1000); //Explore unusual aesthetics with the experimental weird parameter

$result = $imagine_builder->send()
```

[Check the documentation for the complete explanation.](https://docs.midjourney.com/docs/parameter-list)

#### Upcale

```php
$message_id = "1234";
$upscale_image_id = "MJ::JOB::upsample::1::xxxxx";
$interaction_id = $result->interactionId() //You can retrieve this ID after the imagine interaction is performed, this is a identifier for the specific job request.

$upscale_builder = $midjourney->upscale($message_id, $upscale_image_id, $interaction_id); //Returns a Builder object

$upscaled_image_result = $upscale_builder->send();
```

## Documentation
For detailed information about the available endpoints and their parameters, please refer to the official [Midjourney documentation](https://docs.midjourney.com/).

## Contributing
We welcome contributions from the community! If you find any issues or have suggestions for improvements, please feel free to open an issue or submit a pull request on our [GitHub repository](https://github.com/eDiasoft/midjourney-api-php).

## License
This package is open-source and released under the MIT License. Feel free to use and modify it according to your project needs.

## Support
For any questions or support regarding the Midjourney PHP API Client Package, you can contact us at [support@ediasoft.com](mailto:support@ediasoft.com).
