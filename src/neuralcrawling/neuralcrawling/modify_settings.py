import sys

try:
    if len(sys.argv) != 3:
        print("Usage: python modify_settings.py <new_host> <new_referer>")
        sys.exit(1)
    
    new_host = sys.argv[1]
    new_referer = sys.argv[2]
    
    with open('settings.py', 'r') as f:
        lines = f.readlines()
    
    modified_lines = []
    inside_header = False
    
    for line in lines:
        if "DEFAULT_REQUEST_HEADERS" in line:
            inside_header = True
        elif "}" in line:
            inside_header = False
        
        if inside_header and "Host" in line:
            line = f"    'Host': '{new_host}',\n"
            
        if inside_header and "Referer" in line:
            line = f"    'Referer': '{new_referer}',\n"
            
        modified_lines.append(line)
    
    with open('settings.py', 'w') as f:
        for line in modified_lines:
            f.write(line)
except Exception as e:
    print ("Exception: ", e)