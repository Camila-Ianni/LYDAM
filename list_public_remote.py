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
    print("Remote files in public_html/public:")
    ftp.cwd('public_html/public')
    ftp.dir()
    ftp.quit()
except Exception as e:
    print("Error:", e)
