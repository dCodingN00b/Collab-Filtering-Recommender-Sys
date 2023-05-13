import pandas as pd
import os
import re
import sys

# Specify the regular expression pattern to match alphanumeric characters, spaces and other whitelist characters
pattern = r"[^a-zA-Z0-9\(\)\-\.\,\& ]+"

try:
    # check whether there are 1 different arguments
    if len(sys.argv) != 2:
        print("Usage: python specialcharfilter.py <src>") 
        sys.exit(1)
    
    # specify filepath from argument
    arg_filepath = sys.argv[1]

    # Loop over the files in the folder
    for file_name in os.listdir(arg_filepath):
        if file_name.endswith('.csv'):
            file_path = os.path.join(arg_filepath, file_name)
            df = pd.read_csv(file_path)
            
            # Get and remove special characters from each column of the DataFrame
            if df["prodname"].dtype == 'object':  # Check if column data type is string-like
                df["prodname"] = df["prodname"].apply(lambda x: re.sub(pattern, '', x))  # Replace special characters with empty string
            
            # Write the cleaned DataFrame to the same CSV file
            df.to_csv(file_path, index=False)
except Exception as e:
    print ("Exception: ", e)
         
    # exit the program
    exit()