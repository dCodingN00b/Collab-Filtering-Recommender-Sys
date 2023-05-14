import os
import shutil
import pandas as pd

try:
    # Specify the paths to the source
    folder = r'C:\Users\weeze\Documents\neuralcrawling\neuralcrawling\spiders\computers-processing'
    
    # Specify the path to the destination folder
    destination_folder = r'C:\Users\weeze\Documents\neuralcrawling\neuralcrawling\spiders\computers'
    
    # Specify the name of the file you want to copy
    filename = 'computers_out.csv'
    
    # Exit program when file is empty
    if os.path.getsize(os.path.join(folder, filename)) == 0:
        sys.exit()
    
    # Check if the file exists in the destination folder
    if os.path.exists(os.path.join(destination_folder, filename)):
        # Load the destination file into a DataFrame
        dest_df = pd.read_csv(os.path.join(destination_folder, filename))
        
        # Load the source file into a DataFrame
        src_df = pd.read_csv(os.path.join(folder, filename))
        
        # Append the source data to the destination data
        merged_df = pd.concat([dest_df, src_df])
        
        # df to drop duplicates
        merged_df = merged_df.drop_duplicates()
        
        # Write the merged data to the destination file
        merged_df.to_csv(os.path.join(destination_folder, filename), index=False)
        
        print(f"{filename} has been merged in {destination_folder}")
    
    # If the file doesn't exist in the destination folder
    else:
        # Copy the file to the destination folder
        shutil.copy2(os.path.join(folder, filename), destination_folder)
        print(f"{filename} has been copied from {folder} to {destination_folder}")
        
except Exception as e:
    print ("Exception", e)
