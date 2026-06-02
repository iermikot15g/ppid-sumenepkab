# change-color.ps1
# Script untuk mengubah warna dari blue ke maroon

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "  Mengubah Warna Theme dari Blue ke Maroon" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

# 1. Backup file app.css
Write-Host "[1/6] Membackup file app.css..." -ForegroundColor Yellow
Copy-Item "resources/css/app.css" "resources/css/app.css.backup" -Force
Write-Host "      Backup tersimpan di resources/css/app.css.backup" -ForegroundColor Green

# 2. Update app.css dengan theme maroon
Write-Host "[2/6] Mengupdate app.css dengan theme maroon..." -ForegroundColor Yellow

$appCssContent = @"
@import "tailwindcss";

@theme {
    --color-maroon-50: #fdf2f2;
    --color-maroon-100: #fce8e8;
    --color-maroon-200: #f8d4d4;
    --color-maroon-300: #f1b0b0;
    --color-maroon-400: #e88484;
    --color-maroon-500: #c41e3a;
    --color-maroon-600: #a01830;
    --color-maroon-700: #7c1425;
    --color-maroon-800: #58101b;
    --color-maroon-900: #340a10;
    
    --color-blue-50: #fdf2f2;
    --color-blue-100: #fce8e8;
    --color-blue-200: #f8d4d4;
    --color-blue-300: #f1b0b0;
    --color-blue-400: #e88484;
    --color-blue-500: #c41e3a;
    --color-blue-600: #a01830;
    --color-blue-700: #7c1425;
    --color-blue-800: #58101b;
    --color-blue-900: #340a10;
}

@layer base {
    body {
        @apply antialiased;
    }
}

@layer components {
    .btn-primary {
        @apply inline-flex items-center px-4 py-2 bg-maroon-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-maroon-700 active:bg-maroon-800 focus:outline-none focus:ring-2 focus:ring-maroon-500 focus:ring-offset-2 transition ease-in-out duration-150;
    }

    .btn-secondary {
        @apply inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150;
    }

    .form-input {
        @apply mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-maroon-500 focus:ring-maroon-500;
    }
}
"@

Set-Content -Path "resources/css/app.css" -Value $appCssContent -NoNewline
Write-Host "      app.css berhasil diupdate" -ForegroundColor Green

# 3. Update semua file blade
Write-Host "[3/6] Mengupdate semua file blade..." -ForegroundColor Yellow

$bladeFiles = Get-ChildItem -Path "resources\views" -Recurse -Filter "*.blade.php"
$fileCount = 0

foreach ($file in $bladeFiles) {
    $content = Get-Content $file.FullName -Raw
    
    # Ganti class warna biru dengan maroon
    $content = $content -replace 'bg-blue-600', 'bg-maroon-600'
    $content = $content -replace 'bg-blue-700', 'bg-maroon-700'
    $content = $content -replace 'bg-blue-800', 'bg-maroon-800'
    $content = $content -replace 'bg-blue-50', 'bg-maroon-50'
    $content = $content -replace 'bg-blue-100', 'bg-maroon-100'
    $content = $content -replace 'text-blue-600', 'text-maroon-600'
    $content = $content -replace 'text-blue-700', 'text-maroon-700'
    $content = $content -replace 'text-blue-800', 'text-maroon-800'
    $content = $content -replace 'hover:bg-blue-600', 'hover:bg-maroon-600'
    $content = $content -replace 'hover:bg-blue-700', 'hover:bg-maroon-700'
    $content = $content -replace 'focus:ring-blue-500', 'focus:ring-maroon-500'
    $content = $content -replace 'focus:border-blue-500', 'focus:border-maroon-500'
    $content = $content -replace 'border-blue-500', 'border-maroon-500'
    $content = $content -replace 'ring-blue-500', 'ring-maroon-500'
    $content = $content -replace 'from-blue-600', 'from-maroon-600'
    $content = $content -replace 'to-blue-700', 'to-maroon-700'
    
    Set-Content $file.FullName -Value $content -NoNewline
    $fileCount++
}

Write-Host "      $fileCount file blade berhasil diupdate" -ForegroundColor Green

# 4. Update file CSS tambahan
Write-Host "[4/6] Mengupdate file CSS tambahan..." -ForegroundColor Yellow

$cssFiles = Get-ChildItem -Path "resources\css" -Recurse -Filter "*.css"
foreach ($file in $cssFiles) {
    if ($file.Name -ne "app.css") {
        $content = Get-Content $file.FullName -Raw
        $content = $content -replace 'bg-blue-600', 'bg-maroon-600'
        $content = $content -replace 'text-blue-600', 'text-maroon-600'
        Set-Content $file.FullName -Value $content -NoNewline
        Write-Host "      Updated: $($file.Name)" -ForegroundColor Green
    }
}

# 5. Update chart colors di dashboard
Write-Host "[5/6] Mengupdate warna chart.js..." -ForegroundColor Yellow

$dashboardFiles = @(
    "resources\views\dashboard\pimpinan\dashboard.blade.php",
    "resources\views\dashboard\utama\monitoring\index.blade.php",
    "resources\views\dashboard\pembantu\dashboard.blade.php"
)

foreach ($dashboardFile in $dashboardFiles) {
    if (Test-Path $dashboardFile) {
        $content = Get-Content $dashboardFile -Raw
        
        # Ganti warna chart dari biru ke maroon
        $content = $content -replace "rgb\(59, 130, 246\)", "#c41e3a"
        $content = $content -replace "rgba\(59, 130, 246, 0.1\)", "rgba(196, 30, 58, 0.1)"
        $content = $content -replace "rgb\(59, 130, 246", "#c41e3a"
        $content = $content -replace "'#3b82f6'", "'#c41e3a'"
        
        Set-Content $dashboardFile -Value $content -NoNewline
        Write-Host "      Updated: $dashboardFile" -ForegroundColor Green
    }
}

# 6. Rebuild assets
Write-Host "[6/6] Rebuild assets..." -ForegroundColor Yellow
npm run build

Write-Host ""
Write-Host "========================================" -ForegroundColor Green
Write-Host "  PERUBAHAN SELESAI!" -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Green
Write-Host ""
Write-Host "Langkah selanjutnya:" -ForegroundColor Cyan
Write-Host "1. Clear browser cache (Ctrl + Shift + R)" -ForegroundColor White
Write-Host "2. Restart server: php artisan serve" -ForegroundColor White
Write-Host "3. Login dan cek tampilan baru" -ForegroundColor White
Write-Host ""
Write-Host "Jika terjadi error, restore backup:" -ForegroundColor Yellow
Write-Host "   Copy-Item resources/css/app.css.backup resources/css/app.css -Force" -ForegroundColor White