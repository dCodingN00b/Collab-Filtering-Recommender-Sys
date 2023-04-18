from os import path, remove, listdir, chdir, getcwd


# os change directory
chdir(r"C:\Users\weeze\Documents\neuralcrawling\neuralcrawling\spiders")


def delete_videogames():
    try:
        # for videogames.csv deletion
        dirspider = r"C:\Users\weeze\Documents\neuralcrawling\neuralcrawling\spiders"
        for filename in listdir(dirspider):
            if filename=='videogames.csv':
                remove(path.join(dirspider, filename))
        
        # to remove videogames.csv
        dir = r"C:\Users\weeze\Documents\neuralcrawling\neuralcrawling\spiders\videogames"
        for filename in listdir(dir):
            if filename.endswith('.csv'):
                remove(path.join(dir, filename))
        
        # to remove files in videogamesCate.
        dir = r"C:\Users\weeze\Documents\neuralcrawling\neuralcrawling\spiders\videogamesCate"
        for filename in listdir(dir):
            if filename.endswith('.csv'):
                remove(path.join(dir, filename))
        
        print ("removed relevant files")
    except Exception as e:
        print ("Exception: ", e)
        
delete_videogames()