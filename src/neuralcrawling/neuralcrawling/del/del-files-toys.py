from os import path, remove, listdir, chdir, getcwd


# os change directory
chdir(r"C:\Users\weeze\Documents\neuralcrawling\neuralcrawling\spiders")


def delete_toys():
    try:
        # for toys.csv deletion
        dirspider = r"C:\Users\weeze\Documents\neuralcrawling\neuralcrawling\spiders"
        for filename in listdir(dirspider):
            if filename=='toys.csv':
                remove(path.join(dirspider, filename))
        
        # to remove toys.csv
        dir = r"C:\Users\weeze\Documents\neuralcrawling\neuralcrawling\spiders\toys"
        for filename in listdir(dir):
            if filename.endswith('.csv'):
                remove(path.join(dir, filename))
        
        # to remove files in toysCate.
        dir = r"C:\Users\weeze\Documents\neuralcrawling\neuralcrawling\spiders\toysCate"
        for filename in listdir(dir):
            if filename.endswith('.csv'):
                remove(path.join(dir, filename))
        
        print ("removed relevant files")
    except Exception as e:
        print ("Exception: ", e)

delete_toys()