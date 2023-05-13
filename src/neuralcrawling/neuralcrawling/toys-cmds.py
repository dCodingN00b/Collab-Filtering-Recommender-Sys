import subprocess

def start_toyscmds():
    try:
        # working directory of delete
        dirdel = r"C:\Users\weeze\Documents\neuralcrawling\neuralcrawling\del"
        # working directory of spider
        dirspider = r"C:\Users\weeze\Documents\neuralcrawling\neuralcrawling\spiders"
        # working directory of neuralcrawling
        dirneural = r"C:\Users\weeze\Documents\neuralcrawling\neuralcrawling"
        
        # Run the commands
        # delete if there is those files
        subprocess.run(['python', 'del-files-toys.py'], cwd=dirdel)
        
        # change the host and referer in settings.py
        subprocess.run(['python', 'modify_settings.py', 'www.amazon.com.au', 'https://www.amazon.com.au/gp/browse.html?node=5030677051&ref_=nav_em_toys_arts_0_2_26_3'], cwd=dirneural)
        
        # Run the commands in the Anaconda prompt
        # scrape arts & craft sub menu links
        subprocess.run(['scrapy', 'crawl', 'amazon_categ_crawl', '-a', 'domain=https://www.amazon.com.au/gp/browse.html?node=5030677051&ref_=nav_em_toys_arts_0_2_26_3', '-s', 'CLOSESPIDER_ITEMCOUNT=100', '-o', 'toysCate/toys-arts.csv'], cwd=dirspider)
        
        # change the host and referer in settings.py
        subprocess.run(['python', 'modify_settings.py', 'www.amazon.com.au', 'https://www.amazon.com.au/gp/browse.html?node=5030679051&ref_=nav_em_toys_building_0_2_26_4'], cwd=dirneural)
        
        # scrape building sub menu links
        subprocess.run(['scrapy', 'crawl', 'amazon_categ_crawl', '-a', 'domain=https://www.amazon.com.au/gp/browse.html?node=5030679051&ref_=nav_em_toys_building_0_2_26_4', '-s', 'CLOSESPIDER_ITEMCOUNT=100', '-o', 'toysCate/toys-building.csv'], cwd=dirspider)
        
        # change the host and referer in settings.py
        subprocess.run(['python', 'modify_settings.py', 'www.amazon.com.au', 'https://www.amazon.com.au/gp/browse.html?node=5030698051&ref_=nav_em_toys_outdoor_0_2_26_5'], cwd=dirneural)
        
        # scrape outdoor play sub menu links
        subprocess.run(['scrapy', 'crawl', 'amazon_categ_crawl', '-a', 'domain=https://www.amazon.com.au/gp/browse.html?node=5030698051&ref_=nav_em_toys_outdoor_0_2_26_5', '-s', 'CLOSESPIDER_ITEMCOUNT=100', '-o', 'toysCate/toys-outdoors.csv'], cwd=dirspider)
        
        # change the host and referer in settings.py
        subprocess.run(['python', 'modify_settings.py', 'www.amazon.com.au', 'https://www.amazon.com.au/gp/browse.html?node=5030688051&ref_=nav_em_toys_learning_0_2_26_6'], cwd=dirneural)
        
        # scrape learning games sub menu links
        subprocess.run(['scrapy', 'crawl', 'amazon_categ_crawl', '-a', 'domain=https://www.amazon.com.au/gp/browse.html?node=5030688051&ref_=nav_em_toys_learning_0_2_26_6', '-s', 'CLOSESPIDER_ITEMCOUNT=100', '-o', 'toysCate/toys-learning.csv'], cwd=dirspider)
        
        # change the host and referer in settings.py
        subprocess.run(['python', 'modify_settings.py', 'www.amazon.com.au', 'https://www.amazon.com.au/gp/browse.html?node=5030765051&ref_=nav_em_toys_board_0_2_26_7'], cwd=dirneural)
        
        # scrape board games sub menu links
        subprocess.run(['scrapy', 'crawl', 'amazon_categ_crawl', '-a', 'domain=https://www.amazon.com.au/gp/browse.html?node=5030765051&ref_=nav_em_toys_board_0_2_26_7', '-s', 'CLOSESPIDER_ITEMCOUNT=100', '-o', 'toysCate/toys-board.csv'], cwd=dirspider)
        
        # working directory of toysCate
        dirspiCate = r"C:\Users\weeze\Documents\neuralcrawling\neuralcrawling\spiders\toysCate"
        
        # run python csvmerge
        subprocess.run(['python', 'toysCatecsvmerge.py'], cwd=dirspiCate)
        
        # run scrapy to scrape toys links
        subprocess.run(['scrapy', 'crawl', 'amazon_scraping', '-a' 'csv=toys.csv', '-o', 'toys-processing/toys_out.csv'], cwd=dirspider)
        
        # run python specialcharfilter to remove unwanted special characters
        subprocess.run(['python', 'specialcharfilter.py', r"C:\Users\weeze\Documents\neuralcrawling\neuralcrawling\spiders\toys-processing"], cwd=dirneural)
        
        # working directory of toys-processing
        dirspiProcess = r"C:\Users\weeze\Documents\neuralcrawling\neuralcrawling\spiders\toys-processing"
        
        # copy processing output to toys folder
        subprocess.run(['python', 'copytoToys.py'], cwd=dirspiProcess)
        
    except Exception as e:
        print ("Exception: ", e)
        
start_toyscmds()