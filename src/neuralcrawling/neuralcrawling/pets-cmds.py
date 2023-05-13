import subprocess

# make sure to delete files before running this script, only if there are already files created.

def start_petscmds():
    try:
        # working directory of delete
        dirdel = r"C:\Users\weeze\Documents\neuralcrawling\neuralcrawling\del"
        # working directory of spider
        dirspider = r"C:\Users\weeze\Documents\neuralcrawling\neuralcrawling\spiders"
        # working directory of neuralcrawling
        dirneural = r"C:\Users\weeze\Documents\neuralcrawling\neuralcrawling"
        
        # Run the commands
        # delete if there is those files
        subprocess.run(['python', 'del-files-pets.py'], cwd=dirdel)
        
        # change the host and referer in settings.py
        subprocess.run(['python', 'modify_settings.py', 'www.amazon.com.au', 'https://www.amazon.com.au/gp/browse.html?node=5581858051&ref_=nav_em__pets_birds_0_2_22_3'], cwd=dirneural)
        
        # scrape birds sub menu links
        subprocess.run(['scrapy', 'crawl', 'amazon_categ_crawl', '-a', 'domain=https://www.amazon.com.au/gp/browse.html?node=5581858051&ref_=nav_em__pets_birds_0_2_22_3', '-s', 'CLOSESPIDER_ITEMCOUNT=100', '-o', 'petsCate/pets-birds.csv'], cwd=dirspider)
        
        # change the host and referer in settings.py
        subprocess.run(['python', 'modify_settings.py', 'www.amazon.com.au', 'https://www.amazon.com.au/gp/browse.html?node=5581859051&ref_=nav_em__pets_cat_0_2_22_4'], cwd=dirneural)
        
        # scrape cats sub menu links
        subprocess.run(['scrapy', 'crawl', 'amazon_categ_crawl', '-a', 'domain=https://www.amazon.com.au/gp/browse.html?node=5581859051&ref_=nav_em__pets_cat_0_2_22_4', '-s', 'CLOSESPIDER_ITEMCOUNT=100', '-o', 'petsCate/pets-cats.csv'], cwd=dirspider)
        
        # change the host and referer in settings.py
        subprocess.run(['python', 'modify_settings.py', 'www.amazon.com.au', 'https://www.amazon.com.au/gp/browse.html?node=5581860051&ref_=nav_em__pets_dog_0_2_22_5'], cwd=dirneural)
        
        # scrape dogs sub menu links
        subprocess.run(['scrapy', 'crawl', 'amazon_categ_crawl', '-a', 'domain=https://www.amazon.com.au/gp/browse.html?node=5581860051&ref_=nav_em__pets_dog_0_2_22_5', '-s', 'CLOSESPIDER_ITEMCOUNT=100', '-o', 'petsCate/pets-dogs.csv'], cwd=dirspider)
        
        # change the host and referer in settings.py
        subprocess.run(['python', 'modify_settings.py', 'www.amazon.com.au', 'https://www.amazon.com.au/gp/browse.html?node=5581857051&ref_=nav_em__pets_fish_0_2_22_6'], cwd=dirneural)
        
        # scrape fish sub menu links
        subprocess.run(['scrapy', 'crawl', 'amazon_categ_crawl', '-a', 'domain=https://www.amazon.com.au/gp/browse.html?node=5581857051&ref_=nav_em__pets_fish_0_2_22_6', '-s', 'CLOSESPIDER_ITEMCOUNT=100', '-o', 'petsCate/pets-fish.csv'], cwd=dirspider)
        
        # change the host and referer in settings.py
        subprocess.run(['python', 'modify_settings.py', 'www.amazon.com.au', 'https://www.amazon.com.au/gp/browse.html?node=5581863051&ref_=nav_em__pets_small_0_2_22_7'], cwd=dirneural)
        
        # scrape small animals sub menu links
        subprocess.run(['scrapy', 'crawl', 'amazon_categ_crawl', '-a', 'domain=https://www.amazon.com.au/gp/browse.html?node=5581863051&ref_=nav_em__pets_small_0_2_22_7', '-s', 'CLOSESPIDER_ITEMCOUNT=100', '-o', 'petsCate/pets-small.csv'], cwd=dirspider)
        
        # set the directory of petsCate
        dirspiCate = r"C:\Users\weeze\Documents\neuralcrawling\neuralcrawling\spiders\petsCate"
        
        # run python csvmerge
        subprocess.run(['python', 'petsCatecsvmerge.py'], cwd=dirspiCate)
        
        # run scrapy to scrape pet links
        subprocess.run(['scrapy', 'crawl', 'amazon_scraping', '-a' 'csv=pets.csv', '-o', 'pets-processing/pets_out.csv'], cwd=dirspider)
        
        # run python specialcharfilter to remove unwanted special characters
        subprocess.run(['python', 'specialcharfilter.py', r"C:\Users\weeze\Documents\neuralcrawling\neuralcrawling\spiders\pets-processing"], cwd=dirneural)
        
        # working directory of pets-processing
        dirspiProcess = r"C:\Users\weeze\Documents\neuralcrawling\neuralcrawling\spiders\pets-processing"
        
        # copy processing output to toys folder
        subprocess.run(['python', 'copytoPets.py'], cwd=dirspiProcess)
        
    except Exception as e:
        print ("Exception: ", e)
        
start_petscmds()