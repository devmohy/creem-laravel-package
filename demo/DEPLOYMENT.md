# Deploy CREEM Laravel Demo to Render.com (Free)

This guide will help you deploy the CREEM Laravel demo to Render.com's free tier.

## Prerequisites

- GitHub account
- Render.com account (free, no credit card required)
- Your CREEM API key

## Step 1: Push to GitHub

1. Create a new GitHub repository for the demo
2. Push the demo code:

```bash
cd demo
git init
git add .
git commit -m "Initial commit"
git branch -M main
git remote add origin https://github.com/YOUR_USERNAME/creem-laravel-demo.git
git push -u origin main
```

## Step 2: Deploy to Render.com

1. Go to [render.com](https://render.com) and sign up (free)
2. Click **"New +"** → **"Blueprint"**
3. Connect your GitHub repository
4. Render will auto-detect the `render.yaml` file
5. Click **"Apply"**

## Step 3: Configure Environment Variables

After deployment starts, go to your web service settings:

1. Navigate to **Environment** tab
2. Add your CREEM credentials:
   - `CREEM_API_KEY`: Your CREEM test API key
   - `CREEM_WEBHOOK_SECRET`: Your CREEM webhook secret (optional)
3. Click **"Save Changes"**

The service will automatically redeploy with your credentials.

## Step 4: Access Your Demo

Your demo will be available at:
```
https://creem-laravel-demo.onrender.com
```

**Note:** The free tier spins down after 15 minutes of inactivity. The first request after that will take ~30 seconds to wake up.

## Troubleshooting

### Build Fails

Check the build logs in Render dashboard. Common issues:
- Missing PHP extensions: Add to `render.yaml`
- Composer dependencies: Check `composer.json`

### App Key Error

Render auto-generates `APP_KEY`. If you see an error:
1. Go to Environment tab
2. Delete the `APP_KEY` variable
3. Add a new one with value: `generateValue: true`

### Database Issues

The demo uses SQLite by default. If you need PostgreSQL:
1. Uncomment the database section in `render.yaml`
2. Update `DB_CONNECTION=pgsql` in environment variables

## Free Tier Limits

- **RAM**: 512MB
- **Bandwidth**: 100GB/month
- **Build time**: 90 minutes/month
- **Uptime**: Spins down after 15 min inactivity

Perfect for demos! 🎉
