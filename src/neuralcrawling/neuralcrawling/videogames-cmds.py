import subprocess

def start_videogamescmds():
    try:
        # working directory of delete
        dirdel = r"C:\Users\weeze\Documents\neuralcrawling\neuralcrawling\del"
        # working directory of spider
        dirspider = r"C:\Users\weeze\Documents\neuralcrawling\neuralcrawling\spiders"
        # working directory of neuralcrawling
        dirneural = r"C:\Users\weeze\Documents\neuralcrawling\neuralcrawling"
        
        # Run the commands
        # delete if there is those files
        subprocess.run(['python', 'del-files-videogames.py'], cwd=dirdel)
        
        # change the host and referer in settings.py
        subprocess.run(['python', 'modify_settings.py', 'www.amazon.com.au', 'https://www.amazon.com.au/gp/browse.html?node=5250869051&ref_=nav_em_vg_nintendo_0_2_27_5'], cwd=dirneural)
        
        # scrape nintendo sub menu links
        subprocess.run(['scrapy', 'crawl', 'amazon_categ_crawl', '-a', 'domain=https://www.amazon.com.au/gp/browse.html?node=5250869051&ref_=nav_em_vg_nintendo_0_2_27_5', '-s', 'CLOSESPIDER_ITEMCOUNT=100', '-o', 'videogamesCate/videogames-nintendo.csv'], cwd=dirspider)
                
        # change the host and referer in settings.py
        subprocess.run(['python', 'modify_settings.py', 'www.amazon.com.au', 'https://www.amazon.com.au/s/?bbn=4852675051&rh=n%3A4852675051%2Cp_89%3APlayStation&ref_=nav_em_0_2_27_6'], cwd=dirneural)
        
        # scrape PlayStation sub menu links
        subprocess.run(['scrapy', 'crawl', 'amazon_categ_crawl', '-a', 'domain=https://www.amazon.com.au/s/?bbn=4852675051&rh=n%3A4852675051%2Cp_89%3APlayStation&ref_=nav_em_0_2_27_6', '-s', 'CLOSESPIDER_ITEMCOUNT=100', '-o', 'videogamesCate/videogames-PlayStation.csv'], cwd=dirspider)
                
        # change the host and referer in settings.py
        subprocess.run(['python', 'modify_settings.py', 'www.amazon.com.au', 'https://www.amazon.com.au/gp/browse.html?node=5250879051&ref_=nav_em_vg_xbox_0_2_27_7'], cwd=dirneural)
        
        # scrape Xbox sub menu links
        subprocess.run(['scrapy', 'crawl', 'amazon_categ_crawl', '-a', 'domain=https://www.amazon.com.au/gp/browse.html?node=5250879051&ref_=nav_em_vg_xbox_0_2_27_7', '-s', 'CLOSESPIDER_ITEMCOUNT=100', '-o', 'videogamesCate/videogames-Xbox.csv'], cwd=dirspider)
                
        # change the host and referer in settings.py
        subprocess.run(['python', 'modify_settings.py', 'www.amazon.com.au', 'https://www.amazon.com.au/s?rh=n%3A5393347051&fs=true&ref=lp_5393347051_sar'], cwd=dirneural)
        
        # scrape console sub menu links
        subprocess.run(['scrapy', 'crawl', 'amazon_categ_crawl', '-a', 'domain=https://www.amazon.com.au/s?rh=n%3A5393347051&fs=true&ref=lp_5393347051_sar', '-s', 'CLOSESPIDER_ITEMCOUNT=100', '-o', 'videogamesCate/videogames-console.csv'], cwd=dirspider)
                
        # change the host and referer in settings.py
        subprocess.run(['python', 'modify_settings.py', 'www.amazon.com.au', 'https://www.amazon.com.au/gp/browse.html?node=5250870051&ref_=nav_em_vg_pc_0_2_27_9'], cwd=dirneural)
        
        # scrape pc sub menu links
        subprocess.run(['scrapy', 'crawl', 'amazon_categ_crawl', '-a', 'domain=https://www.amazon.com.au/gp/browse.html?node=5250870051&ref_=nav_em_vg_pc_0_2_27_9', '-s', 'CLOSESPIDER_ITEMCOUNT=100', '-o', 'videogamesCate/videogames-pc.csv'], cwd=dirspider)
                
        # change the host and referer in settings.py
        subprocess.run(['python', 'modify_settings.py', 'www.amazon.com.au', 'https://www.amazon.com.au/s?rh=n%3A5307353051&fs=true&ref=lp_5307353051_sar'], cwd=dirneural)
        
        # scrape accessories sub menu links
        subprocess.run(['scrapy', 'crawl', 'amazon_categ_crawl', '-a', 'domain=https://www.amazon.com.au/s?rh=n%3A5307353051&fs=true&ref=lp_5307353051_sar', '-s', 'CLOSESPIDER_ITEMCOUNT=100', '-o', 'videogamesCate/videogames-accessories.csv'], cwd=dirspider)
        
        # working directory of videogamesCate
        dirspiCate = r"C:\Users\weeze\Documents\neuralcrawling\neuralcrawling\spiders\videogamesCate"
        
        # run python csvmerge
        subprocess.run(['python', 'videogamesCatecsvmerge.py'], cwd=dirspiCate)
        
        # run scrapy to scrape videogames links
        subprocess.run(['scrapy', 'crawl', 'amazon_scraping', '-a' 'csv=videogames.csv', '-o', 'videogames-processing/videogames_out.csv'], cwd=dirspider)
        
        # run python specialcharfilter to remove unwanted special characters
        subprocess.run(['python', 'specialcharfilter.py', r"C:\Users\weeze\Documents\neuralcrawling\neuralcrawling\spiders\videogames-processing"], cwd=dirneural)
        
        # working directory of videogames-processing
        dirspiProcess = r"C:\Users\weeze\Documents\neuralcrawling\neuralcrawling\spiders\videogames-processing"
        
        # copy processing output to videogames folder
        subprocess.run(['python', 'copytoVideogames.py'], cwd=dirspiProcess)
        
    except Exception as e:
        print ("Exception: ", e)
        
start_videogamescmds()