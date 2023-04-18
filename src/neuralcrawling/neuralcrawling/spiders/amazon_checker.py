import threading
import queue

import requests

# create queue 
q = queue.Queue()

#change the directory to whichever amazon_links.text is in your directory
with open(r"C:\Users\weeze\Documents\CSIT321\week14\amazon_links.txt", "r") as f: #
    urls = f.read().split("\n")
    for p in urls:
        q.put(p)

def check_url(url):
    try:
        response = requests.head(url)
        return response.status_code
    except requests.exceptions.RequestException:
        return None

def check_urls():
    global q
    while not q.empty():
        link = q.get()
        status_code = check_url(link)
        if status_code == 404:
            print(f"{link} returned a 404 error code.")

for _ in range(10):
    threading.Thread(target=check_urls).start()