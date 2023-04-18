import subprocess

def start_computerscmds():
    try:
        # working directory of delete
        dirdel = r"C:\Users\weeze\Documents\neuralcrawling\neuralcrawling\del"
        # working directory of spider
        dirspider = r"C:\Users\weeze\Documents\neuralcrawling\neuralcrawling\spiders"
        # working directory of neuralcrawling
        dirneural = r"C:\Users\weeze\Documents\neuralcrawling\neuralcrawling"
        
        # Run the commands
        # delete if there is those files
        subprocess.run(['python', 'del-files-computers.py'], cwd=dirdel)
        
        # change the host and referer in settings.py
        subprocess.run(['python', 'modify_settings.py', 'www.amazon.com.au', 'https://www.amazon.com.au/gp/browse.html?node=4913311051&ref_=nav_em_pc_laptops_0_2_10_3'], cwd=dirneural)
        
        # scrape laptops sub menu links 
        subprocess.run(['scrapy', 'crawl', 'amazon_categ_crawl', '-a', 'domain=https://www.amazon.com.au/gp/browse.html?node=4913311051&ref_=nav_em_pc_laptops_0_2_10_3', '-s', 'CLOSESPIDER_ITEMCOUNT=100', '-o', 'computersCate/computers-laptops.csv'], cwd=dirspider)
        
        # change the host and referer in settings.py
        subprocess.run(['python', 'modify_settings.py', 'www.amazon.com.au', 'https://www.amazon.com.au/gp/browse.html?node=4913308051&ref_=nav_em_pc_desktops_0_2_10_4'], cwd=dirneural)
        
        # scrape desktops sub menu links
        subprocess.run(['scrapy', 'crawl', 'amazon_categ_crawl', '-a', 'domain=https://www.amazon.com.au/gp/browse.html?node=4913308051&ref_=nav_em_pc_desktops_0_2_10_4', '-s', 'CLOSESPIDER_ITEMCOUNT=100', '-o', 'computersCate/computers-desktops.csv'], cwd=dirspider)
        
        # change the host and referer in settings.py
        subprocess.run(['python', 'modify_settings.py', 'www.amazon.com.au', 'https://www.amazon.com.au/s?rh=n%3A4913312051&fs=true&ref=lp_4913312051_sar'], cwd=dirneural)
        
        # scrape monitors sub menu links
        subprocess.run(['scrapy', 'crawl', 'amazon_categ_crawl', '-a', 'domain=https://www.amazon.com.au/s?rh=n%3A4913312051&fs=true&ref=lp_4913312051_sar', '-s', 'CLOSESPIDER_ITEMCOUNT=100', '-o', 'computersCate/computers-monitors.csv'], cwd=dirspider)
                
        # change the host and referer in settings.py
        subprocess.run(['python', 'modify_settings.py', 'www.amazon.com.au', 'https://www.amazon.com.au/gp/browse.html?node=4913305051&ref_=nav_em_pc_acc_0_2_10_6'], cwd=dirneural)
        
        # scrape accessories sub menu links
        subprocess.run(['scrapy', 'crawl', 'amazon_categ_crawl', '-a', 'domain=https://www.amazon.com.au/gp/browse.html?node=4913305051&ref_=nav_em_pc_acc_0_2_10_6', '-s', 'CLOSESPIDER_ITEMCOUNT=100', '-o', 'computersCate/computers-accessories.csv'], cwd=dirspider)
                
        # change the host and referer in settings.py
        subprocess.run(['python', 'modify_settings.py', 'www.amazon.com.au', 'https://www.amazon.com.au/gp/browse.html?node=4913313051&ref_=nav_em_pc_networking_0_2_10_7'], cwd=dirneural)
        
        # scrape networking sub menu links
        subprocess.run(['scrapy', 'crawl', 'amazon_categ_crawl', '-a', 'domain=https://www.amazon.com.au/gp/browse.html?node=4913313051&ref_=nav_em_pc_networking_0_2_10_7', '-s', 'CLOSESPIDER_ITEMCOUNT=100', '-o', 'computersCate/computers-networking.csv'], cwd=dirspider)
                
        # change the host and referer in settings.py
        subprocess.run(['python', 'modify_settings.py', 'www.amazon.com.au', 'https://www.amazon.com.au/gp/browse.html?node=4913307051&ref_=nav_em_pc_storage_0_2_10_8'], cwd=dirneural)
        
        # scrape storage sub menu links
        subprocess.run(['scrapy', 'crawl', 'amazon_categ_crawl', '-a', 'domain=https://www.amazon.com.au/gp/browse.html?node=4913307051&ref_=nav_em_pc_storage_0_2_10_8', '-s', 'CLOSESPIDER_ITEMCOUNT=100', '-o', 'computersCate/computers-storage.csv'], cwd=dirspider)
                        
        # change the host and referer in settings.py
        subprocess.run(['python', 'modify_settings.py', 'www.amazon.com.au', 'https://www.amazon.com.au/gp/browse.html?node=4913310051&ref_=nav_em_pc_parts_0_2_10_9'], cwd=dirneural)
        
        # scrape parts sub menu links
        subprocess.run(['scrapy', 'crawl', 'amazon_categ_crawl', '-a', 'domain=https://www.amazon.com.au/gp/browse.html?node=4913310051&ref_=nav_em_pc_parts_0_2_10_9', '-s', 'CLOSESPIDER_ITEMCOUNT=100', '-o', 'computersCate/computers-parts.csv'], cwd=dirspider)
                        
        # change the host and referer in settings.py
        subprocess.run(['python', 'modify_settings.py', 'www.amazon.com.au', 'https://www.amazon.com.au/gp/browse.html?node=4913314051&ref_=nav_em_off_printers_0_2_10_10'], cwd=dirneural)
        
        # scrape printers sub menu links
        subprocess.run(['scrapy', 'crawl', 'amazon_categ_crawl', '-a', 'domain=https://www.amazon.com.au/gp/browse.html?node=4913314051&ref_=nav_em_off_printers_0_2_10_10', '-s', 'CLOSESPIDER_ITEMCOUNT=100', '-o', 'computersCate/computers-printers.csv'], cwd=dirspider)
        
        print ("\n============ done with csv link scraping, merge next ==========")
        
        # working directory of computersCate
        dirspi_computers = r"C:\Users\weeze\Documents\neuralcrawling\neuralcrawling\spiders\computersCate"
        
        # run python csvmerge
        subprocess.run(['python', 'computersCatecsvmerge.py'], cwd=dirspi_computers)
        
        # run scrapy to scrape pet links
        subprocess.run(['scrapy', 'crawl', 'amazon_scraping', '-a' 'csv=computers.csv', '-o', 'computers/computers_out.csv'], cwd=dirspider)
        
    except Exception as e:
        print ("Exception: ", e)
        
start_computerscmds()