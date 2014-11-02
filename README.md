# SimpleFeedback - a super simple feedback backend written in PHP


## Still in development! 


## Description

TODO: Write description

## Installation

* Install dependencies with composer (Commandline: `php composer.phar install`) -- TODO: integrate in build.xml?
* Run build with phing (Commandline: `phing`)
* Deploy `/build`

## Usage

### Example

I've written two super simple examples on how to interact with the software in `/example`. Here's a short description 
of the API.

| Method  | Endpoint                | Return               | Send                                | 
|:--------|:------------------------|:---------------------|:------------------------------------|
| GET     | /index.php?action=show  | All messages in JSON |                                     | 
| POST    | /index.php              | The message in JSON  | `{"commentMessage":"your message"}` | 


And here's an example of the JSON format:

    {
        "commentMessage": "Hello, here's my comment",
        "ipAddress": "127.0.0.1"
    }



## Requests / Questions / PRs

If you have any requests or actions feel free to open an issue. If you want to contribute, just fork and open a
pull request!

