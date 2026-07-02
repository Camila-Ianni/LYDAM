import ssl
from ftplib import FTP_TLS

context = ssl.create_default_context()
context.check_hostname = False
context.verify_mode = ssl.CERT_NONE

def read_log_file(ftp, path):
    try:
        print(f"\n--- Reading log: {path} ---")
        lines = []
        ftp.retrlines(f'RETR {path}', lines.append)
        # Print the last 150 lines
        for line in lines[-150:]:
            print(line)
    except Exception as e:
        print(f"Could not read {path}: {e}")

try:
    ftp = FTP_TLS(context=context)
    ftp.connect('a0150776.ferozo.com', 21, timeout=30)
    ftp.login('a0150776', '9lu*uRo6**@P8mY')
    ftp.prot_p()
    
    # Check different log files
    read_log_file(ftp, 'public_html/error_log')
    read_log_file(ftp, 'public_html/public/error_log')
    read_log_file(ftp, 'public_html/storage/logs/laravel.log')
    
    ftp.quit()
except Exception as e:
    print("Error:", e)
