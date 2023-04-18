import pandas as pd
import os
import sys

# Get folder path, have to set to the particular directory.
folder_path = 'C:/Users/weeze/Documents/neuralcrawling/neuralcrawling/spiders/dataset'

def start():
    try:
        if len(sys.argv) != 2:
            print("Usage: python svdpp_csv_inputs.py <name.csv>")
            sys.exit(1)
        
        arg_csv = sys.argv[1]
        
        # Get list of csv files in folder
        csv_files = [os.path.join(folder_path, f) for f in os.listdir(folder_path) if f.endswith('.csv')]
        
        # Initialize empty dataframe to store merged data
        merged_df = pd.DataFrame()
        
        # Loop through csv files and merge data
        for file in csv_files:
            df = pd.read_csv(file)
            merged_df = merged_df.append(df)
        
        # Save merged data to csv at the spider folder
        merged_df.to_csv(os.path.join('C:/Users/weeze/Documents/neuralcrawling/neuralcrawling/spiders/dataset', arg_csv), index=False)
    except Exception as e:
        print ("Exception found: ", e)
        
start()