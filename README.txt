
# Secure PDF UPI Payment System

## Features
- User inputs: Name, Email, Phone, UPI Reference ID
- QR Code payment
- Admin approval panel
- Auto-refresh/polling for approval
- Google Sheets logging on approval
- Optional: Add email notifications using PHP `mail()` or SMTP

## Setup
1. Replace `your_qr_code.png` with your real QR code.
2. Deploy Google Apps Script (see google_apps_script.js) and paste Script ID in `approve.php`.
3. Upload your secure PDF to `loader.php` (edit that script to point to it).
4. Make sure your server supports PHP and file permissions allow writing.
