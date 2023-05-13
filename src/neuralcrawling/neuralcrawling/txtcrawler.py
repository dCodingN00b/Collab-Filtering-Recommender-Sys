import sys
import re
import subprocess

# python txtcrawler.py "C:\Users\weeze\Documents\neuralcrawling\neuralcrawling\spiders\links2.txt" dataset/link2.csv

def start_txt():
    try:
        # check whether there are 2 different arguments
        if len(sys.argv) != 3:
            print("Usage: python txtcrawler.py <links.txt> <output/name.csv>")
            sys.exit(1)
        
        # specify filepath from argument
        arg_file = sys.argv[1]
        arg_output = sys.argv[2]
        
        with open(arg_file, 'r') as f:
            txtFile = [line.rstrip('\n') for line in f]
            
        # working directory of neuralcrawling
        dirneural = r"C:\Users\weeze\Documents\neuralcrawling\neuralcrawling"
                
        # split the links into different position
        # create two seperate lists
        domain_ls = []
        prodID_ls = []
        counter = 0
        for url in txtFile:
            # pattern to match the domain name
            domain_pattern = r"(https?://)?(www\.amazon\.[a-z]+\.[a-z]{2,}|www\.amazon\.[a-z]{2,}|www\.amazon\.[a-z]{3,})"
            
            # pattern to match the product code
            prodID_pattern = r"/dp/([A-Z0-9]+)"
            
            # extract the domain name and product code using regex
            domain = re.search(domain_pattern, url).group(2)
            prodID = re.search(prodID_pattern, url).group(1)
            
            #append to lists.
            domain_ls.append(domain)
            prodID_ls.append(prodID)
            
            if counter==0:
                # this does not work here. must create another script to control the modify settings
                # changing settings for host and referer links for jp.
                if "co.jp" in domain:
                    subprocess.run(['python', 'modify_settings.py', f'{domain}', f'https://{domain}/-/en/dp/{prodID}'], cwd=dirneural)
                # changing settings for host and referer links for others.
                else:
                    subprocess.run(['python', 'modify_settings.py', f'{domain}', f'https://{domain}/dp/{prodID}'], cwd=dirneural)
                
                counter+=1
        
        # working directory of spider
        dirspider = r"C:\Users\weeze\Documents\neuralcrawling\neuralcrawling\spiders"
        
        # run scrapy to scrape txt links
        subprocess.run(['scrapy', 'crawl', 'amazon_scraping_txt', '-a' f'txt={arg_file}', '-o', f'{arg_output}'], cwd=dirspider)
        
    except Exception as e:
        #print ("Invalid url, please try another url.")
        print ("Exception: ", e)
        
        # exit the program
        exit()

start_txt()