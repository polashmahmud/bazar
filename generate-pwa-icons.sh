#!/bin/bash

# PWA Icons Generator Script for Bazar App
# This script creates all necessary icon sizes for PWA

echo "🎨 Generating PWA Icons for Bazar App..."

# Create PWA directory if it doesn't exist
mkdir -p /home/polashmahmud/Sites/bazar/public/pwa

# Check if ImageMagick is installed
if ! command -v convert &> /dev/null; then
    echo "❌ ImageMagick not found. Installing..."
    sudo apt update
    sudo apt install -y imagemagick
fi

# Create a base icon using text (since we don't have a design file)
echo "📱 Creating base icon..."

# Create SVG base icon
cat > /home/polashmahmud/Sites/bazar/public/pwa/base-icon.svg << 'EOF'
<svg width="512" height="512" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
  <defs>
    <linearGradient id="bg" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" style="stop-color:#667eea"/>
      <stop offset="100%" style="stop-color:#764ba2"/>
    </linearGradient>
  </defs>
  
  <!-- Background -->
  <rect width="512" height="512" fill="url(#bg)" rx="80"/>
  
  <!-- Shopping bag icon -->
  <g transform="translate(128, 100)">
    <!-- Bag body -->
    <rect x="32" y="80" width="192" height="240" fill="white" fill-opacity="0.9" rx="20"/>
    
    <!-- Bag handles -->
    <circle cx="96" cy="64" r="32" fill="none" stroke="white" stroke-width="16" stroke-opacity="0.9"/>
    <circle cx="160" cy="64" r="32" fill="none" stroke="white" stroke-width="16" stroke-opacity="0.9"/>
    
    <!-- Bazar text -->
    <text x="128" y="280" text-anchor="middle" fill="white" font-family="Arial, sans-serif" font-size="36" font-weight="bold">
      BAZAR
    </text>
    
    <!-- Bengali text -->
    <text x="128" y="310" text-anchor="middle" fill="white" font-family="Arial, sans-serif" font-size="16" font-weight="normal" fill-opacity="0.8">
      Shopping List
    </text>
  </g>
</svg>
EOF

echo "✅ Base SVG icon created"

# Convert SVG to PNG in different sizes
sizes=(72 96 128 144 152 192 384 512)

for size in "${sizes[@]}"; do
    echo "🔄 Generating ${size}x${size} icon..."
    
    # Convert SVG to PNG
    convert -background transparent \
            -size ${size}x${size} \
            /home/polashmahmud/Sites/bazar/public/pwa/base-icon.svg \
            /home/polashmahmud/Sites/bazar/public/pwa/icon-${size}x${size}.png
    
    echo "✅ Generated icon-${size}x${size}.png"
done

# Create maskable icons (with safe zone)
echo "🎭 Creating maskable icons..."

cat > /home/polashmahmud/Sites/bazar/public/pwa/maskable-icon.svg << 'EOF'
<svg width="512" height="512" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
  <defs>
    <linearGradient id="bg" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" style="stop-color:#667eea"/>
      <stop offset="100%" style="stop-color:#764ba2"/>
    </linearGradient>
  </defs>
  
  <!-- Background with safe zone -->
  <rect width="512" height="512" fill="url(#bg)"/>
  
  <!-- Shopping bag icon (centered with safe zone) -->
  <g transform="translate(156, 156)">
    <!-- Bag body -->
    <rect x="20" y="40" width="160" height="200" fill="white" fill-opacity="0.9" rx="16"/>
    
    <!-- Bag handles -->
    <circle cx="70" cy="32" r="24" fill="none" stroke="white" stroke-width="12" stroke-opacity="0.9"/>
    <circle cx="130" cy="32" r="24" fill="none" stroke="white" stroke-width="12" stroke-opacity="0.9"/>
    
    <!-- Letter B -->
    <text x="100" y="180" text-anchor="middle" fill="white" font-family="Arial, sans-serif" font-size="80" font-weight="bold">
      B
    </text>
  </g>
</svg>
EOF

# Generate maskable icon
convert -background transparent \
        -size 512x512 \
        /home/polashmahmud/Sites/bazar/public/pwa/maskable-icon.svg \
        /home/polashmahmud/Sites/bazar/public/pwa/maskable-icon-512x512.png

echo "✅ Generated maskable-icon-512x512.png"

# Create splash screen images for iOS
echo "📱 Creating iOS splash screens..."

# iPhone splash screens
splash_sizes=(
    "640x1136:iPhone 5/SE"
    "750x1334:iPhone 6/7/8"
    "828x1792:iPhone XR"
    "1125x2436:iPhone X/XS"
    "1242x2208:iPhone 6/7/8 Plus"
    "1242x2688:iPhone XS Max"
    "1170x2532:iPhone 12/13"
    "1284x2778:iPhone 12/13 Pro Max"
)

for splash in "${splash_sizes[@]}"; do
    IFS=':' read -r size desc <<< "$splash"
    IFS='x' read -r width height <<< "$size"
    
    echo "🔄 Generating splash screen: ${desc} (${size})"
    
    # Create splash screen SVG
    cat > /tmp/splash-${size}.svg << EOF
<svg width="${width}" height="${height}" viewBox="0 0 ${width} ${height}" xmlns="http://www.w3.org/2000/svg">
  <defs>
    <linearGradient id="bg" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" style="stop-color:#667eea"/>
      <stop offset="100%" style="stop-color:#764ba2"/>
    </linearGradient>
  </defs>
  
  <!-- Background -->
  <rect width="${width}" height="${height}" fill="url(#bg)"/>
  
  <!-- App icon in center -->
  <g transform="translate($((width/2 - 60)), $((height/2 - 60)))">
    <rect x="24" y="40" width="72" height="80" fill="white" fill-opacity="0.9" rx="8"/>
    <circle cx="42" cy="32" r="12" fill="none" stroke="white" stroke-width="6" stroke-opacity="0.9"/>
    <circle cx="54" cy="32" r="12" fill="none" stroke="white" stroke-width="6" stroke-opacity="0.9"/>
    <text x="60" y="100" text-anchor="middle" fill="white" font-family="Arial" font-size="24" font-weight="bold">B</text>
  </g>
  
  <!-- App name -->
  <text x="${width/2}" y="$((height/2 + 120))" text-anchor="middle" fill="white" font-family="Arial" font-size="24" font-weight="bold">
    Bazar
  </text>
</svg>
EOF
    
    # Convert to PNG
    convert -background transparent \
            /tmp/splash-${size}.svg \
            /home/polashmahmud/Sites/bazar/public/pwa/splash-${size}.png
    
    echo "✅ Generated splash-${size}.png"
done

# Clean up temporary files
rm -f /tmp/splash-*.svg

# Create favicon files
echo "🌟 Creating favicon files..."

# Generate ICO favicon
convert /home/polashmahmud/Sites/bazar/public/pwa/icon-32x32.png \
        /home/polashmahmud/Sites/bazar/public/pwa/icon-16x16.png \
        /home/polashmahmud/Sites/bazar/public/favicon.ico

echo "✅ Generated favicon.ico"

# Copy to main public directory
cp /home/polashmahmud/Sites/bazar/public/pwa/icon-192x192.png /home/polashmahmud/Sites/bazar/public/apple-touch-icon.png

echo "✅ Created apple-touch-icon.png"

# List all generated files
echo "📋 Generated files:"
ls -la /home/polashmahmud/Sites/bazar/public/pwa/

echo "🎉 PWA Icons generation completed!"
echo ""
echo "📱 Files created:"
echo "   • PWA Icons: /public/pwa/icon-*x*.png"
echo "   • Maskable Icon: /public/pwa/maskable-icon-512x512.png"
echo "   • Splash Screens: /public/pwa/splash-*x*.png"
echo "   • Favicon: /public/favicon.ico"
echo "   • Apple Touch Icon: /public/apple-touch-icon.png"
echo ""
echo "🚀 Your PWA is ready for installation!"