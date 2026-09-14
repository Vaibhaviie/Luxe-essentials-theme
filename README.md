# ✨ Luxe Essentials — Contemporary Elevated Basics

A luxury editorial e-commerce theme built for WooCommerce on WordPress, featuring mindful minimalism, rich typography, smooth micro-interactions, and a bespoke design system.

---

## 🌟 Key Features

- **Fixed Frosted Glass Header**:
  - Top announcement marquee with promotional tags.
  - Transparent blur navigation bar (`backdrop-filter: blur(20px)`) that remains sticky as users scroll.
  - Interactive cart counter badge.
- **Editorial Typography**:
  - Headings & Brand Identity: *Playfair Display* (Editorial Serif).
  - Body & UI: *Plus Jakarta Sans* (Contemporary Sans-Serif).
- **Responsive Product Grid**:
  - Modern CSS Grid (4 columns desktop, 3 tablet, 2 mobile).
  - Hover zoom animations, ambient drop shadows, and refined price formatting in ₹ (INR).
  - Seamless pill-shaped *Add to Cart* interactions.
- **Single Product Experience**:
  - Edge-to-edge product photography display.
  - Integrated trust badges (*100% Genuine Materials*, *Complimentary Express Shipping*, *14-Day Returns*).
- **Payment Gateways Integrated**:
  - **Stripe**: Credit/Debit cards, Apple Pay, Google Pay, Link.
  - **Razorpay**: UPI (PhonePe, Google Pay, Paytm), NetBanking, Wallets, Cards.
  - **Cash on Delivery (COD)**: Available out of the box for testing.
- **Luxury 4-Column Footer**:
  - Brand story, collection navigation, customer care, and *The Luxe Journal* newsletter subscription.

---

## 📁 Repository Structure

```
├── assets/
│   ├── css/
│   │   ├── aura-luxury.css          # Custom luxury design system & fixed header styling
│   │   └── ...
│   └── js/
├── inc/                             # Theme modules and WooCommerce integrations
├── functions.php                    # Theme hooks, payment gateway init, custom templates
├── style.css                        # Parent theme stylesheet declaration
└── .gitignore                       # Git ignore configuration
```

---

## 🛠️ Local Development Setup

1. **Prerequisites**:
   - WordPress 6.x+
   - WooCommerce 9.x+
   - PHP 8.1 / 8.2+
   - Local by WP (or equivalent local server)

2. **Installation**:
   - Place this theme directory inside `wp-content/themes/storefront` (or your child theme folder).
   - Activate the theme from **WordPress Admin → Appearance → Themes**.

3. **Active Plugins**:
   - WooCommerce
   - WooCommerce Stripe Payment Gateway (`woocommerce-gateway-stripe`)
   - Razorpay for WooCommerce (`woo-razorpay`)

---

## 👤 Author
- **Brand**: Luxe Essentials
- **Developer**: Vaibhaviie ([@Vaibhaviie](https://github.com/Vaibhaviie))
- **License**: GPLv2 or later
