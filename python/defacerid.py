#!/usr/bin/env python3

import requests
import json
import sys
import os

def print_banner():
    banner = """
  _____            __                                    _____   _____  
 |  __ \\          / _|                                  |_   _| |  __ \\ 
 | |  | |   ___  | |_    __ _    ___    ___   _ __        | |   | |  | |
 | |  | |  / _ \\ |  _|  / _` |  / __|  / _ \\ | '__|       | |   | |  | |
 | |__| | |  __/ | |   | (_| | | (__  |  __/ | |     _   _| |_  | |__| |
 |_____/   \\___| |_|    \\__,_|  \\___|  \\___| |_|    (_) |_____| |_____/  

    admin@defacer.id // twitter.com/defacerid // https://defacer.id

"""
    print(banner)

def confirm_setting(prompt):
    while True:
        response = input(prompt).strip().lower()
        if response in {'yes', 'no'}:
            return response == 'yes'
        print("Only (yes/no)")

def defacerid_bulk_submissions(file_path):
    notifier = "Name"
    team = "Team"
    poc = "Choose one" # Known vulnerability (i.e. unpatched system) ; Undisclosed (new) vulnerability ; Configuration / admin. mistake" ; Brute force attack ; Social engineering ; Web Server intrusion ; Web Server external module intrusion ; Mail Server intrusion ; FTP Server intrusion ; SSH Server intrusion ; Telnet Server intrusion ; RPC Server intrusion ; Shares misconfiguration ; Other Server intrusion ; SQL Injection ; URL Poisoning", "File Inclusion", "Other Web Application bug", "Remote administrative panel access through bruteforcing ; Remote administrative panel access through password guessing ; Remote administrative panel access through social engineering ; Attack against the administrator/user (password stealing/sniffing) ; Access credentials through Man In the Middle attack ; Remote service password guessing ; Remote service password bruteforce ; Rerouting after attacking the Firewall ; Rerouting after attacking the Router ; DNS attack through social engineering ; DNS attack through cache poisoning ; Cross-Site Scripting ; Not available
    reason = "Choose one" # Heh...just for fun! ; Revenge against that website ; Political reasons ; As a challenge ; I just want to be the best defacer ; Patriotism ; Not available

    if not confirm_setting(f'Are you sure the notifier "{notifier}" is correct? (yes/no) '):
        print("Exiting...")
        sys.exit(1)

    if not confirm_setting(f'Are you sure the team "{team}" is correct? (yes/no) '):
        print("Exiting...")
        sys.exit(1)

    with open(file_path, 'r') as file:
        urls = file.readlines()

    print()

    for url in urls:
        url = url.strip()
        data = {
            "notifier": notifier,
            "team": team,
            "url": url,
            "poc": poc,
            "reason": reason
        }
        response = requests.post("https://api.defacer.id/notify", json=data)
        
        try:
            response_json = response.json()
            message = response_json.get('message', 'No message found')
        except json.JSONDecodeError:
            message = 'Invalid JSON response'

        print(f"{url} => {message}")

if __name__ == "__main__":
    print_banner()
    
    if len(sys.argv) != 2:
        print("Usage: python3 code.py <file.txt>")
        sys.exit(1)

    file_path = sys.argv[1]

    if not os.path.isfile(file_path):
        print(f"Error: The file '{file_path}' does not exist.")
        sys.exit(1)

    defacerid_bulk_submissions(file_path)
