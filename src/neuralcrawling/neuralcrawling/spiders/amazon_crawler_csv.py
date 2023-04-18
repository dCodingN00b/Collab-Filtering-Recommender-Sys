import scrapy
import re
import pandas as pd
from urllib.parse import urljoin

# make sure to change directory
# run command below in cmd:
# cd C:\Users\weeze\Documents\neuralcrawling\neuralcrawling\spiders\
#scrapy crawl amazon_scraping -a csv="electronic-camera.csv" -o electronics/test.csv

class AmazonReview(scrapy.Spider):
    name = 'amazon_scraping'
    csv_global = ''
    
    def __init__(self, csv='', *args, **kwargs):
        super(AmazonReview, self).__init__(*args, **kwargs)
        AmazonReview.csv_global = csv
        
    # we need to find more asin on amazon to put in this list (electronic items if possible)
    def start_requests(self):
        # to extract useful information from url list
        try:
            # read csv file in pandas
            csvFile = pd.read_csv(AmazonReview.csv_global)
            
            # create two seperate lists
            domain_ls = []
            prodID_ls = []
            for url in csvFile.index:
                # pattern to match the domain name
                domain_pattern = r"(https?://)?(www\.amazon\.[a-z]+\.[a-z]{2,}|www\.amazon\.[a-z]{2,}|www\.amazon\.[a-z]{3,})"
                
                # pattern to match the product code
                prodID_pattern = r"/dp/([A-Z0-9]+)"
                
                # extract the domain name and product code using regex
                domain = re.search(domain_pattern, csvFile.iloc[url, 0]).group(2)
                prodID = re.search(prodID_pattern, csvFile.iloc[url, 0]).group(1)
                
                #append to lists.
                domain_ls.append(domain)
                prodID_ls.append(prodID)
           
            #print ("domain_ls: ",domain_ls)
            #print ("prodID_ls: ",prodID_ls)
        except FileNotFoundError:
            print("File not found, please select another file type.\nExiting program")
            exit()
        except Exception as e:
            print ("Invalid url, please try another url.")
            print ("Exception: ", e)
            
            # exit the program
            exit()

        count = 0
        for asin in prodID_ls:
            # get the domain link from the list
            amazon_site = domain_ls[count]
            print ("amazon_site: ", amazon_site)
            print ("count: ", count)
            amazon_reviews_url = f'https://{amazon_site}/product-reviews/{asin}/'
            # add one to count for next 
            count+=1
            # scrapy request from website url
            yield scrapy.Request(url=amazon_reviews_url, callback=self.parse_review, meta={'asin':asin,'url':amazon_site})
            
        
    # find out: run one at a time, to avoid being banned, already happen on amazon.com/ap/signin
    # have to change header
    def parse_review(self, response):
        asin = response.meta['asin']
        url_amazon = response.meta['url']
        
        # remember to remove all the printouts
        print ("URL: ", url_amazon)
        # check product variation strip and extract the data.
                                    #product-variation-strip
        typeSelection = response.css("div.product-variation-strip")
        for typeSelect in typeSelection:
            str_check = typeSelect.css("span::text").extract()
        
        #print ("strcheck: ", str_check)
        review_elements = response.css("#cm_cr-review_list div.review")
        for review_element in review_elements:
            # get user_link from reviews website
            user_link = review_element.css('a.a-profile::attr(href)').get()
            # check against product variation strip and if it is the same, scrape the info and user_link being available, and if product variation strip is None and user_link being available, we will scrape the data.
            if (review_element.css("*[data-hook*=format-strip] ::text").extract()==str_check and user_link) or ((review_element.css("*[data-hook*=format-strip] ::text").extract()) is None and user_link):
                yield {
                    # unable to scrape multiple (max 10 for certain items)
                    "userID": user_link,
                    "prodID": asin,
                    "rating": review_element.css("*[data-hook*=review-star-rating] ::text").re(r'(\d\.*\d) out')[0]
                    }
                
        # get next page url
        next_page_short_url = response.css('.a-pagination .a-last>a::attr(href)').get() #
        
        print ("next_page_short_url:", next_page_short_url)
        
        # if loop is not None, check for /ap/signin, make next_page_short_url = None
        if next_page_short_url is not None:
            if "/ap/signin" in next_page_short_url:
                next_page_short_url = None
        
        # check if next page has a url and user_link is not None, request the page and scrape the next page
        if next_page_short_url and user_link is not None:
            full_Url = "//" + url_amazon + "" + next_page_short_url
            
            next_page = urljoin('https://', full_Url)
            print ("next_page: ", next_page)
            yield scrapy.Request(url=next_page, callback=self.parse_review, meta={'asin':asin,'url':url_amazon})