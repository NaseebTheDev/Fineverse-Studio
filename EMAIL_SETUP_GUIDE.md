# EmailJS Setup Guide for FineVerse Studio

## Overview
This guide will help you set up email notifications for employee check-ins using EmailJS, which works perfectly with InfinityFree hosting.

## Step 1: Create EmailJS Account
1. Go to [https://www.emailjs.com](https://www.emailjs.com)
2. Click "Sign Up Free"
3. Create your free account (no credit card required)
4. The free tier includes 200 emails/month, which is sufficient for most studios

## Step 2: Add Email Service
1. After logging in, go to **Email Services** in the left menu
2. Click **"Add New Service"**
3. Select your email provider (e.g., Gmail, Outlook, or Custom SMTP)
4. For Gmail:
   - Connect your Gmail account
   - You may need to enable "Less secure apps" or create an App Password
5. Copy the **Service ID** (looks like `service_abc123`)

## Step 3: Create Email Template
1. Go to **Email Templates** in the left menu
2. Click **"Create New Template"**
3. Design your email:

**Subject:**
```
New Check-in: {{employee_name}}
```

**Message Body (HTML):**
```html
<html>
<body>
<h2>Employee Check-in Notification</h2>
<p><strong>Employee:</strong> {{employee_name}}</p>
<p><strong>Check-in Time:</strong> {{checkin_time}}</p>
<p><strong>Date:</strong> {{date}}</p>
<p>This is an automated notification from FineVerse Studio Portal.</p>
</body>
</html>
```

4. Save the template
5. Copy the **Template ID** (looks like `template_xyz789`)

## Step 4: Get Your Public Key
1. Go to **Account** (click your name in top-right)
2. Navigate to **API Keys** or **General** section
3. Copy your **Public Key** (looks like `user_abc123xyz`)

## Step 5: Update index.php
Open your `index.php` file and find line ~52 where it says:

```javascript
emailjs.init("YOUR_PUBLIC_KEY")
```

Replace the placeholders with your actual credentials:
- Replace `YOUR_PUBLIC_KEY` with your Public Key from Step 4
- Replace `YOUR_SERVICE_ID` with your Service ID from Step 2
- Replace `YOUR_TEMPLATE_ID` with your Template ID from Step 3
- Optionally change `admin@fineverse.local` to your actual admin email

Example:
```javascript
emailjs.init("user_abc123xyz");
emailjs.send("service_abc123", "template_xyz789", {...})
```

## Step 6: Test the System
1. Log in to your FineVerse Studio portal as an employee
2. Click "Check In" on the dashboard
3. Check your admin email inbox for the notification
4. Check browser console (F12) for any errors

## Troubleshooting

### Emails not sending?
- Verify all three keys are correctly entered in index.php
- Check browser console for error messages
- Ensure your EmailJS service is connected properly
- Check if you've exceeded the free tier limit (200 emails/month)

### Gmail-specific issues:
- Enable "Less secure app access" OR
- Create an App Password: https://myaccount.google.com/apppasswords
- Use the App Password instead of your regular password

### InfinityFree considerations:
- EmailJS works client-side, so no server configuration needed
- No PHP mail() function required
- Works with InfinityFree's free hosting restrictions

## Upgrade Options
If you need more than 200 emails/month:
- EmailJS paid plans start at $10/month for 2,000 emails
- Consider upgrading as your team grows

## Security Notes
- Your Public Key is safe to expose in client-side code
- Never share your Private Key (not needed for this implementation)
- EmailJS handles all email delivery securely
