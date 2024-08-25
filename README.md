# DefacerID
Automate bulk submissions to the Defacer API

## Project Structure

- `python/`: Contains the Python script for bulk submission.
- `php/`: Contains the PHP script for bulk submission.

### Python Version

- **Python:** Ensure Python 3.x is installed on your system.
- **Requests Library:** Install the `requests` library if it's not already available.

```bash
pip install requests
```

### PHP Version

- **PHP:** Ensure PHP is installed on your system. This script is compatible with PHP 7.x and PHP 8.x.
- **cURL Extension:** The cURL PHP extension must be enabled for HTTP requests.

## Installation

```bash
git clone https://github.com/DefacerID/DefacerID.git
cd DefacerID
```

## Python Usage

```bash
cd python
chmod +x defacerid.py
./defacerid.py urls.txt
```

## PHP Usage

```bash
cd ../php
chmod +x defacerid.php
./defacerid.php urls.txt

```

## Configuration

Before running the scripts, you need to configure the following settings. Edit the relevant files based on your chosen language:

- **notifier:** Your name or identifier.
- **team:** The name of your team or organization (Optional).
- **poc:** The Proof of concept for the submission (e.g., "SQL Injection").
- **reason:** The reason for the submission (e.g., "Not available").

## URL Lists

Assuming you have a text file named `urls.txt` with the following content:
```
https://example1.com
https://example2.com
https://example3.com
```

## Troubleshooting

- **File Not Found Error:** Ensure the file path provided exists and is correct.
- **Invalid JSON Response:** If you encounter issues with JSON responses, verify that the API endpoint is correct and the response format matches expectations.

## Contact

- Email: admin@defacer.id
- Twitter: @defacerid
- Website: defacer.id
