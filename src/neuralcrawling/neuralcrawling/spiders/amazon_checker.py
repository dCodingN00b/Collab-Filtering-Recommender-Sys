import sys
import requests

def check_url(url):
    try:
        response = requests.head(url)
        return response.status_code
    except requests.exceptions.RequestException:
        return None

def check_urls():
    try:
        if len(sys.argv) != 2:
            print("Usage: python amazon_checker.py <link(s)>")
            sys.exit(1)
        
        # specify links from argument
        arg_list = sys.argv[1]
        
        link_list = arg_list.split(" ")
        count = 0
        #while not q.empty():
        for link in link_list:
            #link = q.get()
            status_code = check_url(link)
            if status_code == 404:
                print(f"{link} returned a 404 error code.")
                count=+1
        #if count==0:
            # do nothing unless need to save file
        
    except Exception as e:
        print ("Exception: ", e)

check_urls()
