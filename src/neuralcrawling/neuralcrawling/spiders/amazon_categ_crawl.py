import scrapy
import re
from urllib.parse import urljoin

# make sure to change to your directory
# run command below in cmd:
#                                       paste link here        date or category in folder
# scrapy crawl amazon_categ_crawl -a domain="paste link here" -o date or category/links.csv
# scrapy crawl amazon_categ_crawl -a domain="https://www.amazon.com.au/gp/browse.html?node=4885118051&ref_=nav_em_elec_speakers_0_2_11_5" -s CLOSESPIDER_ITEMCOUNT=100 -o .csv
# change "-o (xx.json)" based on what user likes

# based on big category, then we scrape 100 of each sub category
# Electronics
# Computers
# Pets Supplies
# Toys & Games
# Video Games

class AmazonCategPage(scrapy.Spider):
    name = 'amazon_categ_crawl'
    
    # __init__ to define start url
    def __init__(self, domain='', *args, **kwargs):
        super(AmazonCategPage, self).__init__(*args, **kwargs)
        self.start_urls = [domain]
    
    def parse(self, response):
        original_url = response.request.url
        print("original URL: ",original_url)
        
        # pattern to match the domain name
        domain_pattern = r"(https?://)?(www\.amazon\.[a-z]+\.[a-z]{2,}|www\.amazon\.[a-z]{2,}|www\.amazon\.[a-z]{3,})"
                
        # extract the domain name and product code using regex
        domain = re.search(domain_pattern, original_url).group(2)
        
        rows_data = response.css("div.s-latency-cf-section")
        
        # have to find limit of 500 lines of output
        
        # 16 or 24 links per page
        for row_data in rows_data:
            # extract data from h2 href link
            link_wo_domain = row_data.css('h2 a::attr(href)').extract()[0]
            # create the url with the domain
            link =  'https://' + domain + "" + link_wo_domain
            # yield prodID link
            yield {                    
                "prodID-link": link
                }
                
        # get next page url
        next_page_short_url = response.css('a.s-pagination-item.s-pagination-next.s-pagination-button.s-pagination-separator::attr(href)').get() #
        
        # have to crawl around 32 pages for 500 links
        print ("next_page: ", next_page_short_url)
        # check if next page has a url, request the page and scrape the info
        if next_page_short_url is not None: 
            # add domain with next_page_short_url
            full_Url = "//" + domain + "" + next_page_short_url
            next_page = urljoin('https://', full_Url)
            print ("next_page: ", next_page)
            yield scrapy.Request(url=next_page, callback=self.parse)