from os import path, remove, listdir, chdir, getcwd

# os change directory
chdir(r"C:\Users\weeze\Documents\neuralcrawling\neuralcrawling\spiders")


def delete_pets():
    try:
        # for pets.csv deletion
        dirspider = r"C:\Users\weeze\Documents\neuralcrawling\neuralcrawling\spiders"
        for filename in listdir(dirspider):
            if filename=='pets.csv':
                remove(path.join(dirspider, filename))
        
        # to remove pets.json
        dir = r"C:\Users\weeze\Documents\neuralcrawling\neuralcrawling\spiders\pets"
        for filename in listdir(dir):
            if filename.endswith('.csv'):
                remove(path.join(dir, filename))
        
        # to remove files in petsCate.
        dir = r"C:\Users\weeze\Documents\neuralcrawling\neuralcrawling\spiders\petsCate"
        for filename in listdir(dir):
            if filename.endswith('.csv'):
                remove(path.join(dir, filename))
        
        print ("removed relevant files")
    except Exception as e:
        print ("Exception: ", e)
        
delete_pets()