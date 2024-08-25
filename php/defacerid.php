#!/usr/bin/env php
<?php

function print_banner() {
    $banner = <<<EOT
  _____            __                                    _____   _____  
 |  __ \\          / _|                                  |_   _| |  __ \\ 
 | |  | |   ___  | |_    __ _    ___    ___   _ __        | |   | |  | |
 | |  | |  / _ \\ |  _|  / _` |  / __|  / _ \\ | '__|       | |   | |  | |
 | |__| | |  __/ | |   | (_| | | (__  |  __/ | |     _   _| |_  | |__| |
 |_____/   \\___| |_|    \\__,_|  \\___|  \\___| |_|    (_) |_____| |_____/  

    admin@defacer.id // twitter.com/defacerid // https://defacer.id

EOT;
    echo $banner;
}

function confirm_setting($prompt) {
    while (true) {
        echo $prompt;
        $response = trim(strtolower(fgets(STDIN)));
        if ($response === 'yes') {
            return true;
        } elseif ($response === 'no') {
            return false;
        }
        echo "Only (yes/no)\n";
    }
}

function defacerid_bulk_submissions($file_path) {
    $notifier = "Name";
    $team = "Team";
    $poc = "Choose one"; // Known vulnerability (i.e. unpatched system) ; Undisclosed (new) vulnerability ; Configuration / admin. mistake" ; Brute force attack ; Social engineering ; Web Server intrusion ; Web Server external module intrusion ; Mail Server intrusion ; FTP Server intrusion ; SSH Server intrusion ; Telnet Server intrusion ; RPC Server intrusion ; Shares misconfiguration ; Other Server intrusion ; SQL Injection ; URL Poisoning", "File Inclusion", "Other Web Application bug", "Remote administrative panel access through bruteforcing ; Remote administrative panel access through password guessing ; Remote administrative panel access through social engineering ; Attack against the administrator/user (password stealing/sniffing) ; Access credentials through Man In the Middle attack ; Remote service password guessing ; Remote service password bruteforce ; Rerouting after attacking the Firewall ; Rerouting after attacking the Router ; DNS attack through social engineering ; DNS attack through cache poisoning ; Cross-Site Scripting ; Not available
    $reason = "Choose one"; // Heh...just for fun! ; Revenge against that website ; Political reasons ; As a challenge ; I just want to be the best defacer ; Patriotism ; Not available
	
	echo "\n";

    if (!confirm_setting("Are you sure the notifier \"$notifier\" is correct? (yes/no) ")) {
        echo "Exiting...\n";
        exit(1);
    }

    if (!confirm_setting("Are you sure the team \"$team\" is correct? (yes/no) ")) {
        echo "Exiting...\n";
        exit(1);
    }

    if (!file_exists($file_path)) {
        echo "Error: The file '$file_path' does not exist.\n";
        exit(1);
    }

    $urls = file($file_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    echo "\n";

    foreach ($urls as $url) {
        $data = json_encode([
            "notifier" => $notifier,
            "team" => $team,
            "url" => $url,
            "poc" => $poc,
            "reason" => $reason
        ]);

        $ch = curl_init("https://api.defacer.id/notify");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $response_json = json_decode($response, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            $message = $response_json['message'] ?? 'No message found';
        } else {
            $message = 'Invalid JSON response';
        }

        echo "$url => $message\n";
    }
}

print_banner();

if ($argc !== 2) {
    echo "\nUsage: php defacerid.php <file.txt>\n";
    exit(1);
}

$file_path = $argv[1];

defacerid_bulk_submissions($file_path);
