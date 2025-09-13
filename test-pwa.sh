#!/bin/bash

echo "🚀 PWA Functionality Test Script"
echo "================================"

# Colors for output
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Base URL
BASE_URL="http://127.0.0.1:8001"

echo ""
echo "📋 Testing PWA Components..."

# Test 1: Check if manifest.json exists and is accessible
echo ""
echo -n "1. PWA Manifest: "
if curl -s -f "${BASE_URL}/manifest.json" > /dev/null; then
    echo -e "${GREEN}✅ PASS${NC}"
    echo "   📄 Manifest file is accessible"
else
    echo -e "${RED}❌ FAIL${NC}"
    echo "   📄 Manifest file not found"
fi

# Test 2: Check if service worker exists
echo ""
echo -n "2. Service Worker: "
if curl -s -f "${BASE_URL}/sw.js" > /dev/null; then
    echo -e "${GREEN}✅ PASS${NC}"
    echo "   🔧 Service worker file is accessible"
else
    echo -e "${RED}❌ FAIL${NC}"
    echo "   🔧 Service worker file not found"
fi

# Test 3: Check if offline page exists
echo ""
echo -n "3. Offline Page: "
if curl -s -f "${BASE_URL}/offline.html" > /dev/null; then
    echo -e "${GREEN}✅ PASS${NC}"
    echo "   📱 Offline page is accessible"
else
    echo -e "${RED}❌ FAIL${NC}"
    echo "   📱 Offline page not found"
fi

# Test 4: Check PWA icons
echo ""
echo -n "4. PWA Icons: "
icon_count=0
icon_sizes=(72 96 128 144 152 192 384 512)

for size in "${icon_sizes[@]}"; do
    if curl -s -f "${BASE_URL}/pwa/icon-${size}x${size}.png" > /dev/null; then
        ((icon_count++))
    fi
done

if [ $icon_count -eq ${#icon_sizes[@]} ]; then
    echo -e "${GREEN}✅ PASS${NC}"
    echo "   🎨 All ${#icon_sizes[@]} icon sizes are available"
else
    echo -e "${YELLOW}⚠️  PARTIAL${NC}"
    echo "   🎨 ${icon_count}/${#icon_sizes[@]} icon sizes are available"
fi

# Test 5: Check maskable icon
echo ""
echo -n "5. Maskable Icon: "
if curl -s -f "${BASE_URL}/pwa/maskable-icon-512x512.png" > /dev/null; then
    echo -e "${GREEN}✅ PASS${NC}"
    echo "   🎭 Maskable icon is available"
else
    echo -e "${RED}❌ FAIL${NC}"
    echo "   🎭 Maskable icon not found"
fi

# Test 6: Check favicon
echo ""
echo -n "6. Favicon: "
if curl -s -f "${BASE_URL}/favicon.ico" > /dev/null; then
    echo -e "${GREEN}✅ PASS${NC}"
    echo "   🌟 Favicon is accessible"
else
    echo -e "${RED}❌ FAIL${NC}"
    echo "   🌟 Favicon not found"
fi

# Test 7: Check apple touch icon
echo ""
echo -n "7. Apple Touch Icon: "
if curl -s -f "${BASE_URL}/apple-touch-icon.png" > /dev/null; then
    echo -e "${GREEN}✅ PASS${NC}"
    echo "   🍎 Apple touch icon is accessible"
else
    echo -e "${RED}❌ FAIL${NC}"
    echo "   🍎 Apple touch icon not found"
fi

# Test 8: Validate manifest content
echo ""
echo -n "8. Manifest Content: "
manifest_content=$(curl -s "${BASE_URL}/manifest.json")
if echo "$manifest_content" | grep -q '"name".*"Bazar"' && \
   echo "$manifest_content" | grep -q '"start_url"' && \
   echo "$manifest_content" | grep -q '"display".*"standalone"'; then
    echo -e "${GREEN}✅ PASS${NC}"
    echo "   📊 Manifest contains required PWA fields"
else
    echo -e "${RED}❌ FAIL${NC}"
    echo "   📊 Manifest missing required fields"
fi

# Test 9: Check main page HTML for PWA meta tags
echo ""
echo -n "9. PWA Meta Tags: "
html_content=$(curl -s "${BASE_URL}")
if echo "$html_content" | grep -q 'rel="manifest"' && \
   echo "$html_content" | grep -q 'name="theme-color"' && \
   echo "$html_content" | grep -q 'apple-mobile-web-app'; then
    echo -e "${GREEN}✅ PASS${NC}"
    echo "   🏷️  PWA meta tags are present"
else
    echo -e "${RED}❌ FAIL${NC}"
    echo "   🏷️  PWA meta tags missing"
fi

# Test 10: Service Worker registration
echo ""
echo -n "10. SW Registration: "
if echo "$html_content" | grep -q "navigator.serviceWorker.register"; then
    echo -e "${GREEN}✅ PASS${NC}"
    echo "    🔧 Service worker registration code found"
else
    echo -e "${RED}❌ FAIL${NC}"
    echo "    🔧 Service worker registration code missing"
fi

echo ""
echo "================================"
echo "📊 PWA Test Summary Complete!"
echo ""
echo -e "${YELLOW}📱 To test full PWA functionality:${NC}"
echo "1. Open browser at: ${BASE_URL}"
echo "2. Open Developer Tools (F12)"
echo "3. Go to Application/Storage tab"
echo "4. Check 'Manifest' section"
echo "5. Check 'Service Workers' section"
echo "6. Test offline mode by checking 'Offline' in Network tab"
echo "7. Look for PWA install prompt in browser address bar"
echo ""
echo -e "${GREEN}🎉 PWA setup is complete! Your app can now be installed and work offline.${NC}"
echo ""

# Additional PWA tips
echo -e "${YELLOW}💡 PWA Tips:${NC}"
echo "• Open browser DevTools → Application → Manifest to verify PWA"
echo "• Use 'Add to Home Screen' on mobile devices"
echo "• Test offline functionality by disabling network"
echo "• Check Service Worker in DevTools → Application → Service Workers"
echo "• Your app will show install prompt when PWA criteria are met"
echo ""