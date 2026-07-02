import ssl
from ftplib import FTP_TLS

context = ssl.create_default_context()
context.check_hostname = False
context.verify_mode = ssl.CERT_NONE

try:
    ftp = FTP_TLS(context=context)
    ftp.connect('a0150776.ferozo.com', 21, timeout=30)
    ftp.login('a0150776', '9lu*uRo6**@P8mY')
    ftp.prot_p()
    
    # Read laravel.log lines
    lines = []
    try:
        ftp.retrlines('RETR public_html/storage/logs/laravel.log', lines.append)
        print("Total lines in laravel.log:", len(lines))
        # Print the last 150 lines that are NOT stack trace lines starting with #
        printed = 0
        for line in reversed(lines):
            if not line.startswith('#'):
                print(line)
                printed += 1
                if printed > 15:
                    break
    except Exception as e:
        print("Error reading log:", e)
        
    ftp.quit()
except Exception as e:
    print("General Error:", e)
