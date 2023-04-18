from os import path, remove, listdir, chdir, getcwd


# os change directory
chdir(r"C:\Users\weeze\Documents\neuralcrawling\neuralcrawling\spiders")


def delete_computers():
    try:
        # for pets.csv deletion
        dirspider = r"C:\Users\weeze\Documents\neuralcrawling\neuralcrawling\spiders"
        for filename in listdir(dirspider):
            if filename=='computers.csv':
                remove(path.join(dirspider, filename))
        
        # to remove computers.csv
        dir = r"C:\Users\weeze\Documents\neuralcrawling\neuralcrawling\spiders\computers"
        for filename in listdir(dir):
            if filename.endswith('.csv'):
                remove(path.join(dir, filename))
        
        # to remove files in computersCate.
        dir = r"C:\Users\weeze\Documents\neuralcrawling\neuralcrawling\spiders\computersCate"
        for filename in listdir(dir):
            if filename.endswith('.csv'):
                remove(path.join(dir, filename))
        
        print ("removed relevant files")
    except Exception as e:
        print ("Exception: ", e)

delete_computers()