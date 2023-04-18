from os import path, remove, listdir, chdir, getcwd


# os change directory
chdir(r"C:\Users\weeze\Documents\neuralcrawling\neuralcrawling\spiders")


def delete_electronics():
    try:
        # for electronics.csv deletion
        dirspider = r"C:\Users\weeze\Documents\neuralcrawling\neuralcrawling\spiders"
        for filename in listdir(dirspider):
            if filename=='electronics.csv':
                remove(path.join(dirspider, filename))
        
        # to remove electronics.csv
        dir = r"C:\Users\weeze\Documents\neuralcrawling\neuralcrawling\spiders\electronics"
        for filename in listdir(dir):
            if filename.endswith('.csv'):
                remove(path.join(dir, filename))
        
        # to remove files in electronicsCate.
        dir = r"C:\Users\weeze\Documents\neuralcrawling\neuralcrawling\spiders\electronicsCate"
        for filename in listdir(dir):
            if filename.endswith('.csv'):
                remove(path.join(dir, filename))
        
        print ("removed relevant files")
    except Exception as e:
        print ("Exception: ", e)
        
delete_electronics()