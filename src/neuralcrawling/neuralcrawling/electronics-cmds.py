import subprocess

def start_electronicscmds():
    try:
        # working directory of delete
        dirdel = r"C:\Users\weeze\Documents\neuralcrawling\neuralcrawling\del"
        # working directory of spider
        dirspider = r"C:\Users\weeze\Documents\neuralcrawling\neuralcrawling\spiders"
        # working directory of neuralcrawling
        dirneural = r"C:\Users\weeze\Documents\neuralcrawling\neuralcrawling"
        
        # Run the commands
        # delete if there is those files
        subprocess.run(['python', 'del-files-electronics.py'], cwd=dirdel)
        
        # change the host and referer in settings.py
        subprocess.run(['python', 'modify_settings.py', 'www.amazon.com.au', 'https://www.amazon.com.au/gp/browse.html?node=4885075051&ref_=nav_em_cam_all_0_2_11_3'], cwd=dirneural)
        
        # scrape camera sub menu links 
        subprocess.run(['scrapy', 'crawl', 'amazon_categ_crawl', '-a', 'domain=https://www.amazon.com.au/gp/browse.html?node=4885075051&ref_=nav_em_cam_all_0_2_11_3', '-s', 'CLOSESPIDER_ITEMCOUNT=100', '-o', 'electronicsCate/electronics-camera.csv'], cwd=dirspider)
        
        # change the host and referer in settings.py
        subprocess.run(['python', 'modify_settings.py', 'www.amazon.com.au', 'https://www.amazon.com.au/gp/browse.html?node=4885078051&ref_=nav_em_elec_cinema_0_2_11_4'], cwd=dirneural)
        
        # scrape cinema sub menu links
        subprocess.run(['scrapy', 'crawl', 'amazon_categ_crawl', '-a', 'domain=https://www.amazon.com.au/gp/browse.html?node=4885078051&ref_=nav_em_elec_cinema_0_2_11_4', '-s', 'CLOSESPIDER_ITEMCOUNT=100', '-o', 'electronicsCate/electronics-cinema.csv'], cwd=dirspider)
        
        # change the host and referer in settings.py
        subprocess.run(['python', 'modify_settings.py', 'www.amazon.com.au', 'https://www.amazon.com.au/gp/browse.html?node=4885118051&ref_=nav_em_elec_speakers_0_2_11_5'], cwd=dirneural)
        
        # scrape speakers sub menu links
        subprocess.run(['scrapy', 'crawl', 'amazon_categ_crawl', '-a', 'domain=https://www.amazon.com.au/gp/browse.html?node=4885118051&ref_=nav_em_elec_speakers_0_2_11_5', '-s', 'CLOSESPIDER_ITEMCOUNT=100', '-o', 'electronicsCate/electronics-speakers.csv'], cwd=dirspider)
        
        # change the host and referer in settings.py
        subprocess.run(['python', 'modify_settings.py', 'www.amazon.com.au', 'https://www.amazon.com.au/s?rh=n%3A4885206051&fs=true&ref=lp_4885206051_sar'], cwd=dirneural)
        
        # scrape headphones-earphones sub menu links
        subprocess.run(['scrapy', 'crawl', 'amazon_categ_crawl', '-a', 'domain=https://www.amazon.com.au/s?rh=n%3A4885206051&fs=true&ref=lp_4885206051_sar', '-s', 'CLOSESPIDER_ITEMCOUNT=100', '-o', 'electronicsCate/electronics-headphones-earphones.csv'], cwd=dirspider)
        
        # change the host and referer in settings.py
        subprocess.run(['python', 'modify_settings.py', 'www.amazon.com.au', 'https://www.amazon.com.au/gp/browse.html?node=4885131051&ref_=nav_em_elec_tvs_0_2_11_7'], cwd=dirneural)
        
        # scrape tvs sub menu links
        subprocess.run(['scrapy', 'crawl', 'amazon_categ_crawl', '-a', 'domain=https://www.amazon.com.au/gp/browse.html?node=4885131051&ref_=nav_em_elec_tvs_0_2_11_7', '-s', 'CLOSESPIDER_ITEMCOUNT=100', '-o', 'electronicsCate/electronics-tvs.csv'], cwd=dirspider)
        
        # change the host and referer in settings.py
        subprocess.run(['python', 'modify_settings.py', 'www.amazon.com.au', 'https://www.amazon.com.au/gp/browse.html?node=4885080051&ref_=nav_em_elec_mob_0_2_11_8'], cwd=dirneural)
        
        # scrape mobile-phones sub menu links
        subprocess.run(['scrapy', 'crawl', 'amazon_categ_crawl', '-a', 'domain=https://www.amazon.com.au/gp/browse.html?node=4885080051&ref_=nav_em_elec_mob_0_2_11_8', '-s', 'CLOSESPIDER_ITEMCOUNT=100', '-o', 'electronicsCate/electronics-mobile-phones.csv'], cwd=dirspider)
        
        # change the host and referer in settings.py
        subprocess.run(['python', 'modify_settings.py', 'www.amazon.com.au', 'https://www.amazon.com.au/s?i=specialty-aps&srs=5373356051&rh=n%3A5373356051&fs=true&ref=lp_5373356051_sar'], cwd=dirneural)
        
        # scrape smart-home sub menu links
        subprocess.run(['scrapy', 'crawl', 'amazon_categ_crawl', '-a', 'domain=https://www.amazon.com.au/s?i=specialty-aps&srs=5373356051&rh=n%3A5373356051&fs=true&ref=lp_5373356051_sar', '-s', 'CLOSESPIDER_ITEMCOUNT=100', '-o', 'electronicsCate/electronics-smart-home.csv'], cwd=dirspider)
        
        # change the host and referer in settings.py
        subprocess.run(['python', 'modify_settings.py', 'www.amazon.com.au', 'https://www.amazon.com.au/gp/browse.html?node=4885086051&ref_=nav_em_wl_wear_tech_0_2_11_12'], cwd=dirneural)
        
        # scrape wearable-tech sub menu links
        subprocess.run(['scrapy', 'crawl', 'amazon_categ_crawl', '-a', 'domain=https://www.amazon.com.au/gp/browse.html?node=4885086051&ref_=nav_em_wl_wear_tech_0_2_11_12', '-s', 'CLOSESPIDER_ITEMCOUNT=100', '-o', 'electronicsCate/electronics-wearable-tech.csv'], cwd=dirspider)
        
        # change the host and referer in settings.py
        subprocess.run(['python', 'modify_settings.py', 'www.amazon.com.au', 'https://www.amazon.com.au/gp/browse.html?node=4885083051&ref_=nav_em_wl_gps_0_2_11_13'], cwd=dirneural)
        
        # scrape gps sub menu links
        subprocess.run(['scrapy', 'crawl', 'amazon_categ_crawl', '-a', 'domain=https://www.amazon.com.au/gp/browse.html?node=4885083051&ref_=nav_em_wl_gps_0_2_11_13', '-s', 'CLOSESPIDER_ITEMCOUNT=100', '-o', 'electronicsCate/electronics-gps.csv'], cwd=dirspider)
        
        print ("\n============ done with csv link scraping, merge next ==========")
        
        # working directory of electronicsCate
        dirspi_electronics = r"C:\Users\weeze\Documents\neuralcrawling\neuralcrawling\spiders\electronicsCate"
        
        # run python csvmerge
        subprocess.run(['python', 'electronicsCatecsvmerge.py'], cwd=dirspi_electronics)
        
        # run scrapy to scrape pet links
        subprocess.run(['scrapy', 'crawl', 'amazon_scraping', '-a' 'csv=electronics.csv', '-o', 'electronics/electronics_out.csv'], cwd=dirspider)
        
    except Exception as e:
        print ("Exception: ", e)
        
start_electronicscmds()