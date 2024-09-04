# Reddit CLI Search Tool

## Overview

The **Reddit CLI Search Tool** is a command-line application designed to search for new posts on a specified subreddit. It allows users to filter posts based on a search term and displays the results in a formatted table. Built using PHP 8.1 and leveraging the Symfony Console component, this tool provides an interactive and user-friendly way to fetch and filter Reddit posts.

## Features

- Search for new posts on any specified subreddit.
- Filter posts by a search term.
- Display results in a well-formatted table.
- Handle up to 100 of the latest posts from the subreddit.
- Highlight search terms in the excerpts.

## Requirements

- PHP 8.1 or higher
- Composer for dependency management

## Installation

1. **Clone the Repository**

Clone the repository to your local machine using Git:

```bash
git clone https://github.com/shukriYusof/reddit-cli-search.git
cd reddit-cli-search
```

## Installation

### Install Dependencies

Use Composer to install the required dependencies:

```bash
composer install
```

## Usage

### Running the CLI Tool

The CLI tool is executed via PHP with the following command:

```bash
php bin/Reddit.php reddit:search
```

This will prompt you to enter the subreddit and search term.

### Interactive Prompts

- **Subreddit**: The tool will ask for a subreddit. If you do not provide one, it defaults to `webdev`.
- **Search Term**: You will also be prompted for a search term. If none is provided, it defaults to `php`.

### Output

The tool displays the results in a table with the following columns:

- **Date**: The date of the post in `Y-m-d H:i:s` format (UTC+8).
- **Title**: The title of the post, truncated to 30 characters.
- **URL**: The URL of the post.
- **Excerpt**: A snippet from the post's self-text, with the search term highlighted.

## Dependencies

This project uses the following dependencies:

- **Symfony Console**: Provides the command-line interface and helps with interactive command handling.  
  Version: `^5.3`
- **GuzzleHTTP Client**: For making HTTP requests to the Reddit API.  
  Version: `^7.0`

These dependencies are managed via Composer and are listed in the `composer.json` file.

## Configuration

The CLI tool fetches data from Reddit's API endpoint:

```bash
https://www.reddit.com/r/{subreddit}/new.json?limit=100
```

## Code Structure

- **src/**: Contains the source code for the application.
  - **Command/**: Contains the command classes.
  - **Service/**: Contains services like `RedditService`, `PostFilterService`, and `TableFormatter`.
  - **Model/**: Contains the `Post` model.
  - **Interface/**: Contains interfaces for services and formatting.
- **bin/**: Contains the entry point for the application (`Reddit.php`).
- **vendor/**: Contains installed dependencies (managed by Composer).

## Contributing

1. Fork the repository.
2. Create a new branch:
```bash
git checkout -b feature/YourFeature
```
3. Commit your changes:
```bash
git commit -am 'Add some feature'
```
4. Push to the branch:
```bash
git push origin feature/YourFeature
```
5. Create a new Pull Request

## License

This project is licensed under the MIT License. See the `LICENSE` file for details.

## Contact

For any inquiries, please contact:

> **"Great software starts with great communication."**  
> Let's connect and build something amazing together!

- **Email**: [shuk.yusof@gmail.com](mailto:shuk.yusof@gmail.com)
- **GitHub**: [shukriYusof](https://github.com/shukriYusof)
